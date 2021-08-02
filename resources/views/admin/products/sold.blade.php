@extends('layouts.admin')
@section('title', 'Sold Products')
@section('page.title', 'Sold Products')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Sold Products
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
						<th>Product</th>
						<th>Delivered To</th>
						<th>Delivery Note</th>
						<th>Sold on</th>
					</tr>
				</thead>
				<tbody>
				@foreach($products as $product_sold)
					<tr>
						<td>
							<div style="width: 100px; height: 100px; overflow: hidden;"><img src="{{$product_sold->product->picture[0]['url']}}"  width="100%"/></div>
							<strong><small><a target="_blank" href="{{ route('brand.product', ['slug' => $product_sold->product->listing->slug, 'product_slug' => $product_sold->product->slug ]) }}">{{$product_sold->product->name}}</a></small>
<!--
							<br/>{{$product_sold->product->listing->name}}
-->
							</strong>
							
						</td>
						<td>{{$product_sold->order->user->name }}<br>{{$product_sold->order->address->address }}<br>{{$product_sold->order->user->mobile }}</td>
						<td>{{$product_sold->delivery_status}}<br/><a class="main-color"href="{{route('admin.products.sold.deliverynotes',['id' => $product_sold->id])}}">({{$product_sold->delivery_note->count()}}) Notes</a></td>
						<td>{{$product_sold->created_at}}</td>
					</tr>
					
					<!-- Modal -->
					<div class="modal fade" id="desc{{$product_sold->id}}Modal" tabindex="-1" aria-labelledby="p{{$product_sold->id}}ModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header main-color-bg">
							<h5 class="modal-title" id="p{{$product_sold->id}}ModalLabel">{{$product_sold->name}}</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							  {{$product_sold->delivery_note}}
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
							<form method="post" action="{{route('admin.product.action')}}">
								@csrf
								<input type="hidden" name="product_sold_id" value="{{$product_sold->id}}" />
								@if ($product_sold->status == "PENDING")
									<button type="submit" class="btn main-color-bg btn-sm" name="action" value="approved" >Approve</button>
								@elseif ($product_sold->status == "SUSPENDED")
									<button type="submit" class="btn main-color-bg btn-sm" name="action" value="approved" >Approve</button>
								@else
									<button type="submit" class="btn main-color-bg btn-sm" name="action" value="suspended" >Suspend</button>
								@endif
							</form>
						  </div>
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
