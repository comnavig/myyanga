@extends('layouts.business')
@section('title', 'All Products')
@section('page.title', 'All Products')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			All Products
		</h3>
	</div>
	<div class="col-12">
		<table class="table dt">
			<thead>
				<tr>
					<th>Picture</th>
					<th>Name</th>
					<th>Category</th>
					<th>Created on</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach($products as $product)
			<tr>
				<td><div style="width: 100px; height: 100px; overflow: hidden;"><img src="{{$product->picture[0]->url}}"  width="100%"/></div></td>
				<td>{{$product->name}}<br/><small><a target="_blank" href="{{ route('brand.product', ['slug' => $product->listing->slug, 'product_slug' => $product->slug ]) }}">view product page</small></td>
				<td>{{$product->category->name ?? '' }}</td>
				<td>{{$product->created_at}}</td>
				<td>
					<span class="font-weight-bold {{strtolower($product->status)}}">{{$product->status}}</span>
				</td>
				<td>
					@if ($product->status == "SUSPENDED")
					
					@else
						<div class="btn-group" role="group" aria-label="Basic example">
							<a class="btn btn-sm main-btn-bg mr-2" href="{{ route('listings.edit.product', ['id' => $product->id]) }}">EDIT</a>
							@if($product->sold->count() == 0 )
								<form id="delete{{$product->id}}Form" class="form-inline" method="post" action="{{ route('listings.delete.product') }}" onsubmit = "confirm_this(event)">
									@csrf
									<input type="hidden"  name="product_id" value="{{$product->id}}" />
									<button class="btn btn-sm warm-red-bg " >DELETE</button>
								</form>
								
							@endif
						</div>
					@endif
					
				</td>
			</tr>
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
