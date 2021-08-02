@extends('layouts.business')
@section('title', 'Dashboard')
@section('page.title', 'Welcome '.$user->name)
@section('content')
<div class="container mt-2 ">
	<div class="row dashboard">
		<div class="col-lg-4 col-md-6 col-sm-12 stat">
			<div class="d-flex flex-column justify-content-center align-items-center box">
				<h3 class="main-color">
					{{$listings->count()}}
				</h3>
			</div>
			<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
				<a class="btn-block text-uppercase white" href="{{route('listings')}}">listings</a>
			</div>
		</div>
		
		<div class="col-lg-4 col-md-6 col-sm-12 stat">
			<div class="d-flex flex-column justify-content-center align-items-center box">
				<h3 class="main-color">
					{{$products->count()}}
				</h3>
			</div>
			<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
				<a class="btn-block text-uppercase white" href="{{route('products')}}">products</a>
			</div>
		</div>
		
		<div class="col-lg-4 col-md-6 col-sm-12 stat">
			<div class="d-flex flex-column justify-content-center align-items-center box">
				<h3 class="main-color">
					{{$products_sold->count() ?? 0}}
				</h3>
			</div>
			<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
				<a class="btn-block text-uppercase white" href="{{route('products.sold')}}">products sold</a>
			</div>
		</div>
		
	</div>
	
	<div class="col-12 d-flex justify-content-start align-items-center" style="height: 70px;">
		<h4>Recent product uploaded</h4>
	</div>
	<div class="col-12">
		@if($products->count() == 0 )
			<h4>No upload yet</h4>
		@else
			<table class="table">
				<thead>
					<tr>
						<th>Picture</th>
						<th>Name</th>
						<th>Category</th>
						<th>Created on</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
				@foreach($products->take(9) as $product)
				<tr>
					<td><div style="width: 100px; height: 100px; overflow: hidden;"><img src="{{$product->picture[0]->url}}"  width="100%"/></div></td>
					<td>{{$product->name}}<br/><small><a target="_blank" href="{{ route('brand.product', ['slug' => $product->listing->slug, 'product_slug' => $product->slug ]) }}">view product page</small></td>
					<td>{{$product->category->name ?? '' }}</td>
					<td>{{$product->created_at}}</td>
					<td>
						<span class="font-weight-bold {{strtolower($product->status)}}">{{$product->status}}</span>
					</td>
				</tr>
				@endforeach
				</tbody>
			</table>
			
		</div>
		@endif
	</div>
	
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
@endpush
@push('scripts')
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
    <script>
		$(document).ready( function () {
			$('.dt').DataTable();
			
			new Splide( '.splide', {
				autoplay : true,
				type : 'loop',
				arrows : false,
				pagination : false,
			}).mount();
			
		} );
    </script>
@endpush
