@extends('layouts.user')
@section('title', 'Premium Subscription Payment')
@section('page.title', 'Premium Subscription Payment')
@section('content')
<div class="container mt-2 ">
	<div class="col-12"  style="">
		<div class="table-responsive-sm">
			<table class="table">
				<thead>
					<tr>
						<th>Subscription Package</th>
						<th>Transaction Date</th>
						<th>Expiry Date</th>
						<th>Amount</th>
						<th>VAT</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{$package}} Days</td>
						<td>{{$transactionDate->format('D dS, M Y')}}</td>
						<td>{{$expiry->format('D dS, M Y')}}</td>
						<td>₦{{$amount}}</td>
						<td>₦{{$vat}}</td>
						<th>₦{{$total}}</th>
					</tr>
				</tbody>
			</table>
		</div>
<!--
		<p class="main-color">Payment Options</p>
-->
		<hr/>
		<form id="paymentForm" method="post" action="#">
			@csrf
			<div class="form-row">
				<div class="col-md-9 col-sm-12">
					<input type="hidden" id="trackThis" name="trackThis" value="{{$track_id}}}">
				</div>
				<div class="col-md-3 col-sm-12">
					<button type="button" class="btn btn-lg btn-block main-color-bg" onClick="makePayment()">Pay</button>
				</div>
			</div>
		</form>
		
	</div>

</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
@endpush
@push('scripts')
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script>
	  function makePayment() {
		FlutterwaveCheckout({
		  public_key: "{{$public_key->value}}",
		  tx_ref: "{{$track_id}}",
		  amount: {{$total}},
		  currency: "NGN",
		  country: "NG",
		  payment_options: "card, mobilemoneyghana, ussd",
		  redirect_url: "{{route('user.premium.subscription.confirm.payment')}}",
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
			description: "Premium Subscription Payment",
			logo: "{{asset('assets/img/logo.svg')}}",
		  },
		});
	  }
	</script>
@endpush
