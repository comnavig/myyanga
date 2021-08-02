@extends('layouts.shop')
@section('title', 'Check out')

@section('content')

<div class="container"  style="margin-bottom: 100px;">
	<div class="col-12 mt-1 p-0">
		<h3 class="main-color">Check out</h3>
	</div>
	
	<div class="white-bg" style="min-height: 300px;  margin-bottom: 160px;">
		<div style="margin-top: 2%;">
			<div class="row">
				<div class="col-lg-9 col-md-12 col-sm-12">
					<div class="col-12 m-0">
						<div class=" d-none d-sm-block">
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
								
							</li>
							
								<li class="col-md-2 col-sm-12 p-2 d-none d-sm-block">{{$item['quantity']}}</li>
								<li class="col-md-3 col-sm-12 p-2 d-none d-sm-block">{{$item['shipment']['price']}}</li>
								<li class="col-md-3 col-sm-12 p-2 main-color-bg text-center d-none d-sm-block">{{ number_format(($item['product']['price'] * $item['quantity']) + $item['shipment']['price']) }}</li>
							</ul>
						@endforeach
						<div class="d-none d-sm-block">
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
						
						<div class="d-block d-sm-none">
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
						
				</div>
	
				</div>
				
				<div class="col-lg-3 col-md-12 col-sm-12">
					<form method="post" action="{{route('shop.process.payment')}}">
						@csrf
						<div class="form-check">
							<p>Please select an address</p>
						</div>
						
						<div class="form-check p-0">
							<input class="form-check-input ml-0" type="radio" name="address" id="address0" value="new" checked >
							<label class="form-check-label col-12 pl-4" for="address0">New Address</label>
							<textarea name="new_address" class="form-control col-12" id="new_address" aria-describedby="new_addressHelp"></textarea>
	<!--
							<small id="new_addressHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
	-->
						</div>
	<!--
						<label for="new_address">Or select from your address list</label>
	-->
						<div style="width: 100%; min-height:100px; max-height: 250px; margin-top: 5px; overflow-y:auto;">
							
							@foreach($addresses as $address)
								<div class="form-check">
								  <input class="form-check-input" type="radio" name="address" id="address{{$address->id}}" value="{{$address->id}}" >
								  <label class="form-check-label" for="address{{$address->id}}">
									{{$address->address}}
								  </label>
								</div>
							@endforeach
						</div>
						
						<div class="form-check p-0 m-0" style="min-height: 200px;">
							<button type="submit" class="btn btn-lg btn-block main-color-bg">Make Payment</button>
						</div>
					</form>
				</div>
			</div>
		</div>
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
