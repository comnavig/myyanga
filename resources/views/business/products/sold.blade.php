@extends('layouts.business')
@section('title', 'Products Sold')
@section('page.title', 'Products Sold')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Products Sold ({{$products_sold->count()}})
		</h3>
	</div>
	<div class="col-12">
		<table class="table dt">
			<thead>
				<tr>
					<th>Product</th>
					<th>Quantity</th>
					<th>Amount Paid</th>
					<th>Delivery Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach($products_sold as $productsold)
			<tr>
				<td>
					<div style="width: 100px; height: 100px; overflow: hidden;"><img src="{{$productsold->product->picture[0]->url}}"  width="100%"/></div>
					{{$productsold->product->name}}<br/><small><a target="_blank" href="{{ route('brand.product', ['slug' => $productsold->product->listing->slug, 'product_slug' => $productsold->product->slug ]) }}">view product page</a></small>
					<br/>sold on {{$productsold->product->created_at}}
				</td>
				<td>{{$productsold->quantity }}</td>
				<td>₦{{number_format($productsold->amount)}}</td>
				<td>
					<span class="font-weight-bold {{strtolower($productsold->product->status)}}">{{$productsold->delivery_status}}</span>
				</td>
				<td>
					@if($productsold->delivery_status == "PENDING")
					<!-- Button trigger modal -->
					<a class="btn btn-sm main-color-bg" data-toggle="modal" data-target="#dn{{$productsold->id}}Modal">Delivery Note</a>
					@endif
				</td>
			</tr>
			
			@if($productsold->delivery_status == "PENDING")
			<!-- Modal -->
			<div class="modal fade" id="dn{{$productsold->id}}Modal" tabindex="-1" aria-labelledby="dn{{$productsold->id}}ModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="dn{{$productsold->id}}ModalLabel">Delivery Note</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <form method="post" action="{{route('products.sold.delivery.note')}}"  enctype="multipart/form-data" >
					@csrf
					<input type="hidden" name="product_sold_id" value="{{$productsold->id}}" />
					  <div class="modal-body">
						  
						<div class="form-group">
							<label for="picture">Please upload a scanned copy of the delivery note </label>
							<input type="file" name="picture" class="form-control" id="picture" accept="image/jpeg, image/png" aria-describedby="pictureHelp"/>
							
							@error('picture')
								<small id="pictureHelp" class="form-text text-muted red">{{ $message }}</small>
							@enderror
						</div>
						
						<div class="form-group">
							<label for="description">Note</label>
							<textarea name="description" class="form-control" id="description" aria-describedby="descriptionHelp" rows="12" required >{{ old('description') }}</textarea>
							
							@error('description')
								<small id="descriptionHelp" class="form-text text-muted red">{{ $message }}</small>
							@enderror
						</div>
						
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn main-color-bg">Send</button>
					  </div>
				  </form>
				</div>
			  </div>
			</div>
			@endif
			
			@endforeach
			</tbody>
		</table>
		
	</div>
	
	
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
@endpush
@push('scripts')
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
		var loadFile = function(event, image_id) {
			var image = document.getElementById(image_id);
			image.src = URL.createObjectURL(event.target.files[0]);
		};
	
		function confirm_this(event)
		{
			event.preventDefault();
			
			var r = confirm("Please Confirm, if you want to preform this action?");
			
			if (r == true) 
			{
				//~ alert(event.target.id);
			  document.getElementById(event.target.id).submit();
			} 
			else 
			{
			  event.preventDefault();
			}
		}
		
		$(document).ready( function () {
			$('.dt').DataTable();
		} );
    </script>
@endpush
