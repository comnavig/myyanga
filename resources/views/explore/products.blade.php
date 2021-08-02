@extends('layouts.app')
@section('title', $category->name)

@section('content')

	<div class="col-12 py-2">
		<h3 class="main-color explore-title">{{$category->name}}</h3>
	</div>

@if($products->count() == 0)
	
@else
	<div class="col-12 float-left" style="margin-bottom: 10%; display: flex; flex-wrap: wrap;  justify-content: space-around;">
		@foreach($products as $product)
			<div class="product-item">
				<a class="link" href="{{route('brand.product', ['slug' =>$product->listing->slug, 'product_slug' =>$product->slug] )}}">
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
<!--
	<div class="col-12 float-left" style="height: 10vh;"></div>
-->
@endif


@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
	<style>
		.brand {color: #000000; height: 16px; letter-spacing: .2px; line-height: 16px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}
		.brand .link {color: #000000; font-size: 11px; letter-spacing: .2px; line-height: 20px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}
		.link {color: #000000; font-size: 14px; letter-spacing: .2px; line-height: 20px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}
		.link:hover, .brand .link:hover {color: #85000b;}

		.gp-tabs { margin-bottom: 10px!important; border: 0px;}
		
		.gp-tabs .active{ color: #E1232B!important; border-radius: 0px; border: 0px; border-right: 2px solid #000000!important;}
		.gp-tabs .nav-item .nav-link{font-size: 18px; font-weight: bold; color: #000000; padding: 0rem 1rem!important;}
		.gp-tabs .nav-item .nav-link{ border-radius: 0px; border: 0px; border-right: 2px solid #000000;}
		.no-border{ border-radius: 0px;  border: 0px!important;}
		
		.gp-tabs .nav-link:hover{color: #E1232B}
		
		.tab-pane {padding:6px 0px; border-top: 2px solid #000000; border-bottom: 2px solid #000000;}
		
		.fade:not(.show) {
    display: none;
}
	</style>
@endpush
@push('scripts')
     <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
     <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
    <script>
		$(document).ready(function() {	
			$(".owl-carousel").owlCarousel({
				items:4,
				loop:true,
				margin:10,
				autoplay:true,
			});
			
		});

		new Splide( '.splide', {
				autoplay : true,
				type : 'loop',
				arrows : false,
				pagination : false,
			}).mount();
			
		function hideAndShow(hide, show)
		{
			var h = document.getElementById(hide);
			h.style.display = "none";
			
			var s = document.getElementById(show);
			s.style.display = "block";
			
		}
	</script>
@endpush
