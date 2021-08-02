@extends('layouts.app')
@section('title', 'Search')

@section('content')
<div class="d-block d-sm-block d-lg-none ">
	<div class="col-12 float-left mt-4" >
		<h4 class="main-color">Two search options</h4>
	</div>
</div>

<div class="d-block d-sm-block d-lg-none ">
	<form class="m-3" method="get" action="{{route('search') }}" >
		@csrf
		<input class="form-control my-2 p-4" type="search" name="search" value="{{ $keyword ?? old('search')}}" placeholder="Type in what you are looking for and press enter to search" aria-label="Search" style="width: 100%;" required />
		<button class="btn btn-block main-color-bg my-2 my-sm-0" type="submit">Search</button>
	</form>
</div>

@if (count($products) == 0 )

	<div class="col-12 float-left d-flex justify-content-center align-items-center search_lady" >
		<a href="{{route('search.smart')}}"><img src="{{asset('assets/img/search_lady.jpg') }}" /></a>
	</div>

@else
	<div class="col-12 float-left py-3" style="min-height: 50px;">
		<h4 class="main-color d-inline" >Here are {{ count($products) }} items for {{ $keyword }}</h4>
	</div>
	
	<div class="col-12 float-left" style="margin-bottom: 26%;">
		@foreach($products as $product)
			<div class="product-item">
				<a class="link" href="{{route('brand.product', ['slug' =>$product->listing->slug, 'product_slug' =>$product->slug]  )}}">
					<div class="img" >
						<img src="{{$product->picture[0]->url }}" width="100%" />
					</div>
					{{ ( strlen($product->name) > 20 ? substr($product->name, 0, 15)."..." : $product->name ) }}
				</a>
				<div class="brand">
					<a class="link" href="{{route('pages', ['slug' =>$product->listing->slug] )}}">{{$product->listing->name }}</a>
				</div>
			</div>
		@endforeach
	</div>

@endif

@endsection

@push('styles')
    
@endpush
@push('scripts')
 
 @endpush
