@extends('layouts.shop')
@section('title', 'Make Payment')

@section('content')

<div class="container" style="margin-bottom: 100px;">
	<div class="col-12 mt-1 p-0">
		<h3 class="main-color">Make Payment</h3>
	</div>
	
	<div class="white-bg" style="min-height: 300px; margin-bottom: 160px; ">
		<div style="margin-top: 2%;">
			<div class="col-12 m-0">
				<div class=" d-none d-sm-block">
					<ul class="row d-flex justify-content-center" style="list-style: none; padding-left: 0px;">
						<li class="col-md-4 col-sm-12 p-2">Name</li>
						<li class="col-md-2 col-sm-12 p-2">QTY</li>
						<li class="col-md-3 col-sm-12 p-2">Delivery Cost</li>
						<li class="col-md-3 col-sm-12 p-2 main-color-bg text-center">Total</li>
					</ul>
				</div>
					@php 
						$grandtotal = array();
					@endphp
					@foreach($items as $item)
						@php
							$subtotal[] = ($item['product']['price'] * $item['quantity']); 
							$shippingcost[] = $item['shipment']['price'];
							$grandtotal[] = ($item['product']['price'] * $item['quantity']) + $item['shipment']['price'] 
						@endphp
						<ul class="row d-flex justify-content-center" style="list-style: none; padding-left: 0px; border-bottom: 1px solid #ddd;">
							<li class="col-md-4 col-sm-12 p-2">
								
								<div style="width: 70px; height: 70px; overflow: hidden; float: left; margin-right: 6px;"><img src="{{$item['picture'][0]['url']}}" width="100%" /></div>
								<small><span class="main-color">{{$item['product']['name']}}</span><br/><span class="d-inline d-sm-none font-weight-bolder"> ₦{{number_format($item['product']['price'])}} </span></small>
								
								<div class="d-block d-sm-none">
									<div class="row">
										<div class="col-6 p-0">QTY</div>
										<div class="col-6 p-0 black gold-bg rounded text-center">{{$item['quantity']}} </div>
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
			<div class="col-12 m-0 p-0" style="min-height: 250px;">
					<h5 class="main-color">Delivery Address</h5>
					<p>{{$order->address->address}}</p>
					<form method="post" action="#">
						@csrf
						
						<button type="button" class="btn btn-lg main-color-bg" onClick="makePayment()">Pay</button>
					</form>
				</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<!--
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
-->
	<style>
		
	</style>
@endpush
@push('scripts')

     <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script>
	  function makePayment() {
		FlutterwaveCheckout({
		  public_key: "{{$settings[0]['value']}}",
		  tx_ref: "{{$txn}}",
		  amount: {{$order->amount}},
		  currency: "NGN",
		  country: "NG",
		  payment_options: "card, mobilemoneyghana, ussd",
		  redirect_url: "{{route('shop.confirm.payment')}}",
		  customer: {
			email: "{{$user->email}}",
			phone_number: "{{$user->mobile}}",
			name: "{{$user->name}}",
		  },
		  callback: function (data) {
			console.log(data);
		  },
		  onclose: function() {
			// close modal
		  },
		  customizations: {
			title: "{{ config('app.name', 'Laravel') }}",
			description: "Payment for items in cart",
			logo: "{{asset('assets/img/logo.svg')}}",
		  },
		});
	  }
	</script>
@endpush
