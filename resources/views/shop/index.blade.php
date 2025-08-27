@extends('layouts.shop')
@section('title', 'Shop')

@section('content')

<div class="col-12 mt-1">
	<h3 class="main-color">Shop</h3>
</div>

<div class="col-12 white-bg" style="width:100%; min-height: 250px; float: left; padding: 20px;">
	@foreach($products->sortByDesc('updated_at') as $product)
		<div class="product-item" style="position: relative;">
			@if($product->show_days($product->updated_at) < 8)
				<div style="position:absolute; top: 0; right: 0;">
					<span class="main-color-bg font-weight-bolder"style="padding: 3px 6px; margin:5px; border-radius: 20px;">NEW</span>
				</div>
			@endif
			@if($product->quantity == 0)
				<div style="position:absolute; top: 0; right: 0;">
					<span class="main-color-bg font-weight-bolder"style="padding: 3px 6px; margin:5px; border-radius: 20px;">SOLD OUT</span>
				</div>
			@endif
			<a class="link" href="{{route('shop.product', ['id' =>$product->id] )}}">
				<div class="img" >
					<img src="{{$product->picture[0]->url }}" width="100%" />
				</div>
				{{ ( strlen($product->name) > 20 ? substr($product->name, 0, 15)."..." : $product->name ) }}
			
				<div class="main-color">
					₦{{number_format($product->price) }}
				</div>
				
				
			</a>
		</div>
	@endforeach
</div>


@endsection
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
	<style>
		.gp-tabs .active{ color: #E1232B!important; border: 0px; border-right: 1px solid #000000!important;}
		.gp-tabs .nav-item .nav-link{font-weight: bold; color: #000000;}
		.gp-tabs .nav-item .nav-link{ border: 0px; border-right: 1px solid #000000;}
		.no-border{ border: 0px!important;}
		
		.gp-tabs .nav-link:hover{color: #E1232B}
		
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
