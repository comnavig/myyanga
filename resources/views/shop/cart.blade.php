@extends('layouts.shop')
@section('title', 'Cart')

@section('content')

<div class="container" style="margin-bottom: 100px;">
	<div class="col-12 mt-1 p-0">
		<h3 class="main-color">Cart</h3>
	</div>
	
	<div class="white-bg" style="min-height: 300px; margin-bottom: 160px;">
	@if(count($cart) == 0)
	<div class="d-flex flex-column justify-content-between align-items-center" style="margin-top: 2%;">
		<i class="bi bi-cart3" style="color: #ddd; font-size: 10em;"></i>
		<h4 style="font-size: 14px;">You have no items in the cart</h4>
		<a class="btn btn-lg main-color-bg" href="{{route('shop')}}">Continue Shopping</a>
	</div>
	@else
		<div style="margin-top: 2%;">
			<div class="col-12">
				<div class=" d-none d-lg-block">
					<ul class="row d-flex justify-content-center" style="list-style: none; padding-left: 0px;">
						<li class="col-md-4 col-sm-12 p-0">Name</li>
						<li class="col-md-2 col-sm-12 p-0">QTY</li>
						<li class="col-md-3 col-sm-12 p-0">Delivery Cost</li>
						<li class="col-md-3 col-sm-12 p-0 main-color-bg text-center">Total</li>
					</ul>
				</div>
					@php 
						$grandtotal = array();
					@endphp
					@foreach($cart as $key => $item)
						@php
							$subtotal[] = ($item['product']['price'] * $item['quantity']); 
							$shippingcost[] = $item['shipment']['price'];
							$grandtotal[] = ($item['product']['price'] * $item['quantity']) + $item['shipment']['price'] 
						@endphp
						<ul class="row d-flex justify-content-center" style="list-style: none; padding-left: 0px; border-bottom: 1px solid #ddd;">
							<li class="col-md-4 col-sm-12 px-3">
								<div class="d-block d-lg-none">
									<form method="post" action="{{route('shop.remove.item.cart')}}">
										@csrf
										<button class="float-right btn btn-link btn-xs warm-red p-0" name="key" value="{{$key}}" href="">x</button>
									</form>
								</div>
								<div class="row">
									<div class="col-3 p-0"><div style="width: 60px; height: 60px; overflow: hidden; float: left; margin-right: 6px;"><img src="{{$item['picture'][0]['url']}}" width="100%" /></div></div>
									<div class="col-9 p-0">
										<small>
											<span class="main-color">{{$item['product']['name']}}</span>
											<br/><span class="d-inline d-lg-none font-weight-bolder"> ₦{{number_format($item['product']['price'])}} </span>
										</small>
								
										<div class="d-block d-lg-none">
											<div class="row mt-2">
												<div class="col-9">QTY</div>
												<div class="col-3 p-0 black gold-bg rounded text-center">{{$item['quantity']}} </div>
											</div>
										</div>
									</div>
								</div>
								
								
								
								<div class="d-none d-lg-block p-0">
									<form method="post" action="{{route('shop.remove.item.cart')}}">
										@csrf
										<button class="btn btn-link btn-xs warm-red p-0" name="key" value="{{$key}}" href="">REMOVE</button>
									</form>
								</div>
							</li>
							<li class="col-md-2 col-sm-12 p-2 d-none d-lg-block">{{$item['quantity']}}</li>
							<li class="col-md-3 col-sm-12 p-2 d-none d-lg-block">{{$item['shipment']['price']}}</li>
							<li class="col-md-3 col-sm-12 p-2 main-color-bg text-center d-none d-lg-block">{{ number_format(($item['product']['price'] * $item['quantity']) + $item['shipment']['price']) }}</li>
						</ul>
					@endforeach
					<div class="d-none d-lg-block">
						<ul class="row p-0" style="list-style: none; padding-left: 0px;">
							<li class="col-md-9 col-sm-6 p-0 main-color">Sub total</li>
							<li class="col-md-3 col-sm-6 p-0 main-color  text-center font-weight-bolder">₦{{number_format(array_sum($subtotal))}}</li>
						</ul>
						<ul class="row p-0" style="list-style: none; padding-left: 0px;">
							<li class="col-md-9 col-sm-6 p-0 main-color">Delivery Cost</li>
							<li class="col-md-3 col-sm-6 p-0 main-color  text-center font-weight-bolder">₦{{number_format(array_sum($shippingcost))}}</li>
						</ul>
						<ul class="row p-0" style="list-style: none; padding-left: 0px;">
							<li class="col-md-9 col-sm-6 p-0 main-color">Total</li>
							<li class="col-md-3 col-sm-6 p-0 main-color  text-center font-weight-bolder">₦{{number_format(array_sum($grandtotal))}}</li>
						</ul>
					</div>
					
					<div class="d-block d-lg-none">
						<ul class="row p-0" style="list-style: none; padding-left: 0px;">
							<li class="col-6 p-0 py-2">Sub total</li>
							<li class="col-6 p-0 py-2 text-center">₦{{number_format(array_sum($subtotal))}}</li>
						</ul>
						<ul class="row p-0" style="list-style: none; padding-left: 0px;">
							<li class="col-6 p-0 py-2">Delivery Cost</li>
							<li class="col-6 p-0 py-2 text-center">₦{{number_format(array_sum($shippingcost))}}</li>
						</ul>
						<ul class="row p-0" style="list-style: none; padding-left: 0px;">
							<li class="col-6 p-0 py-2">Total</li>
							<li class="col-6 p-0 py-2 text-center">₦{{number_format(array_sum($grandtotal))}}</li>
						</ul>
					</div>
					<div class="row text-right main-color">
						<div class="col-12 p-0 m-0" style="min-height: 300px;">
							@guest
								<a class="btn btn-lg btn-block main-color-bg m-0 rounded-0" href="{{route('login', ['redirect' => route('shop.checkout') ] )}}">Check Out</a>
							@endguest
							@auth
								<a class="btn btn-lg btn-block main-color-bg m-0 rounded-0" href="{{route('shop.checkout') }}">Check Out</a>
							@endauth
							
						</div>		
					</div>		
			</div>
		</div>
	@endif
	</div>

</div>
@endsection
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
	<style>
		
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
