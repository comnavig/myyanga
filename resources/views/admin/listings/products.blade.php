@extends('layouts.admin')
@section('title', 'Product(s)')
@section('page.title', 'Product(es)')
@section('content')

<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Products
			<a class="btn btn-sm main-btn-bg float-right" href="{{route('admin.listings')}}">Back</a>
		</h3>
	</div>
	<div class="col-12">
		@if(empty($products[0]->id))
			<p>No Products</p>
		@else
<!--
			<div class="col-md-4 col-sm-12 ml-auto">
				<form class="form-row" action="{{route('admin.products')}}">
					@csrf
					<div class="col-10">
						<div class="form-group mx-sm-6 mb-2">
							<input type="text" name="search" class="form-control" value="{{old('search')}}" placeholder="Search a Product" required />
						</div>
					</div>
					<div class="col-2">
						<button type="submit" class="btn main-color-bg mb-2">Search</button>
					</div>
				</form>	
			</div>
-->
			<table class="table">
				<thead>
					<tr>
						<th>Photo</th>
						<th>Category</th>
						<th>Price / Quantity</th>
						<th>Delivery</th>
						<th>Listed by</th>
						<th>Featured</th>
					</tr>
				</thead>
				<tbody>
				@foreach($products as $product)
					<tr>
						<td>
							<div style="width: 100px; height: 100px; overflow: hidden;"><img src="{{$product->picture[0]['url']}}"  width="100%"/></div>
							<strong>  <a class="btn-link" data-toggle="modal" data-target="#desc{{$product->id}}Modal">{{$product->name}} <span class="badge badge-pill badge-info">{{$product->status}}</span></a></strong>
							<br/>  <a class="btn-link" data-toggle="modal" data-target="#review{{$product->id}}Modal"><small>{{$product->review->count() }} REVIEWS</small></a>
						</td>
						<td>{{$product->category['name'] }}<br><small>{{$product->category['parent']['name'] }}</small> </td>
						<td>₦{{number_format($product->price)}} / {{$product->quantity}} QTY </td>
						<td>
								₦{{$product->shipment->price ?? ''}} 
								<br/> <a class="btn-link" data-toggle="collapse" href="#collapseSD{{$product->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">memo</a>
								<div class="collapse" id="collapseSD{{$product->id}}">
								  <div class="card card-body">
									{{$product->shipment->description ?? ''}} 
								  </div>
								</div>
						</td>
						<td>{{$product->user->name}}<br/>{{$product->listing->name}}<br/><small>created on {{$product->created_at}}</small></td>
						<td>
							{{(empty($product->featuredCategory) ? "No" : $product->featuredCategory->name ) }} 
							<br><a href="#" class="main-color" data-toggle="modal" data-target="#desc{{$product->id}}FCModal">Change</a>
						</td>
					</tr>
					
					<!-- Modal -->
					<div class="modal fade" id="desc{{$product->id}}Modal" tabindex="-1" aria-labelledby="p{{$product->id}}ModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header main-color-bg">
							<h5 class="modal-title" id="p{{$product->id}}ModalLabel">{{$product->name}}</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							  <div id="carousel{{$product->id}}Controls" class="carousel slide" data-ride="carousel">
									<div class="carousel-inner">
										@for ($i = 1; $i < $product->picture->count(); $i++)
										<div class="carousel-item {{ ($i == 1 ? 'active' : '') }}">
											<img src="{{$product->picture[$i]->url}}" class="d-block w-100" alt="" />
										</div>
										@endfor
									</div>
								  
							</div>
							
							  {!!$product->description!!}
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
							<form method="post" action="{{route('admin.product.action')}}">
								@csrf
								<input type="hidden" name="product_id" value="{{$product->id}}" />
								@if ($product->status == "PENDING")
									<button type="submit" class="btn main-color-bg btn-sm" name="action" value="approved" >Approve</button>
								@elseif ($product->status == "SUSPENDED")
									<button type="submit" class="btn main-color-bg btn-sm" name="action" value="approved" >Approve</button>
								@else
									<button type="submit" class="btn main-color-bg btn-sm" name="action" value="suspended" >Suspend</button>
								@endif
							</form>
						  </div>
						</div>
					  </div>
					</div>
					
					<!--Review Modal -->
					<div class="modal fade" id="review{{$product->id}}Modal" tabindex="-1" aria-labelledby="review{{$product->id}}ModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header main-color-bg">
							<h5 class="modal-title" id="review{{$product->id}}ModalLabel">{{$product->name}} Review(s)</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body" style="height: 450px; overflow-y: scroll;">
							@foreach($product->review as $review)
							<div class="col-12" style="border-bottom: 1px solid #ddd;">
								<p>
									{{$review->review}} <small> by <strong>{{$review->user->name}}</strong> at {{$review->created_at->format('jS M Y h:iA') }}</small>
								</p>
							</div>
							@endforeach
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
						  </div>
						</div>
					  </div>
					</div>
					
				
					<!-- Featured Category Modal -->
					<div class="modal fade" id="desc{{$product->id}}FCModal" tabindex="-1" aria-labelledby="p{{$product->id}}FCModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header main-color-bg">
							<h5 class="modal-title" id="p{{$product->id}}FCModalLabel">Assign a Featured Category to {{$product->name}}</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <form method="post" action="{{route('admin.product.featured')}}">
								@csrf
								<input type="hidden" name="product_id" value="{{$product->id}}" />
								<div class="modal-body">
									 <div class="form-group">
										<label for="featuredcategory">Category</label>
										<select class="form-control" name="featuredcategory" id="featuredcategory">
											<option value="0"  selected >No</option>
											@foreach($featuredCategories as $category)
												<option value="{{$category->id}}">{{$category->name}}</option>
											@endforeach
										</select>
									</div>
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn main-color-bg btn-sm">Save</button>
								</div>
						  </form>
						</div>
					  </div>
					</div>
					
				@endforeach
				
				</tbody>
			
			</table>
			<div class="col-12">
				{{$products->withQueryString()->links()}}
			</div>
		@endif
		
	</div>
	
	
	
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
@endpush
@push('scripts')
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
		$(document).ready( function () {
			$('.dt').DataTable({
				"order": []
			});
		} );
    </script>
@endpush
