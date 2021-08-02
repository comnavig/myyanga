@extends('layouts.user')
@section('title', 'Premium Subscriptions')
@section('page.title', 'Premium Subscriptions')
@section('content')
<div class="container mt-2 ">
	<div class="col-12 mt-2 border-1 main-border-color d-flex flex-column justify-content-center align-items-start p-0" style="min-height: 200px;">
		@if(empty($active_subscription))
			<strong class="mb-3 p-0">No Subscription Yet</strong>
			
			<p class="p-0">Subscribe to any of our premium packages and get tips on what to wear and how to wear it. Bring out the fashionista in you!!!</p>
			<div class="col-12 p-0">
					@foreach($premia->sortDesc()->take(4) as $premium)
						<div>
							<a class="link " href="{{route('premiums.story', ['id' =>$premium->id])}}">
								<div class="discover-item" style="position:relative; width: 150px; height: 150px; float: left; margin-right: 5px; margin-bottom: 5px; background-position: top center; background-image: url('{{$premium->picture[0]->url }}');">
									<div class="white clear-black-bg d-flex justify-content-center align-items-center" style="width: 100%;position: absolute; height: 100%;">
										{{ ( strlen($premium->name) > 20 ? substr($premium->name, 0, 15)."..." : $premium->name ) }}
									</div>
								</div>		
								
							</a>
						</div>
					@endforeach
				</div>
		@else
			@if( $active_subscription->daysOver($active_subscription->expiry) )
				<strong class="mb-3">No Active Subscription</strong>
				<p class="p-0">Subscribe to any of our premium packages and get tips on what to wear and how to wear it. Bring out the fashionista in you!!!</p>
				<div class="col-12 p-0">
					@foreach($premia->sortDesc()->take(4) as $premium)
						<div>
							<a class="link " href="{{route('premiums.story', ['id' =>$premium->id])}}">
								<div class="discover-item" style="position:relative; width: 150px; height: 150px; float: left; margin-right: 5px; margin-bottom: 5px; background-position: top center; background-image: url('{{$premium->picture[0]->url }}');">
									<div class="white clear-black-bg d-flex justify-content-center align-items-center" style="width: 100%;position: absolute; height: 100%;">
										{{ ( strlen($premium->name) > 20 ? substr($premium->name, 0, 15)."..." : $premium->name ) }}
									</div>
								</div>		
								
							</a>
						</div>
					@endforeach
				</div>	
			@else
				<p class="p-0">Subscribe to any of our premium packages and get tips on what to wear and how to wear it. Bring out the fashionista in you!!!</p>
				<h4 class="p-0"> You have <strong class="main-color">{{$active_subscription->daysLeft($active_subscription->expiry) }}</strong> days left</h4>
			@endif
		@endif
	</div>
	
	<div class="col-12 p-0" style="min-height: 100px; margin-top: 10px;">
		<p class="main-color">Renew your subscription</p>
		
		<form method="post" action="{{route('user.premium.subscription.calculation')}}">
			@csrf
			<div class="form-row">
				<div class="col-md-9 col-sm-12">
					<select class="custom-select custom-select-lg mb-3" name="package" required />
						@for ($i = 1; $i < 13; $i++)
							<option value="{{$i}}">{{$i}} Package(s) - {{$subscribtion_duration->value * $i}}Days </option>
						@endfor
					</select>
				</div>
				<div class="col-md-3 col-sm-12">
					<button class="btn btn-lg btn-block main-color-bg">Pay</button>
				</div>
			</div>
		</form>
	</div>
	
	<div class="col-12 p-0"  style="border-top: 2px solid #dddddd; min-height: 100px; margin-top: 10px;">
		<p class="main-color">Subscription History</p>
		@if(empty($subscriptions[0]))
			<center><strong>No Subscription Yet</strong></center>
		@else
			<div class="table-responsive-sm">
				<table class="table dt">
					<thead>
						<tr>
							<th>Transaction Date</th>
							<th>Expiry Date</th>
							<th>Amount</th>
							<th>VAT</th>
							<th>Total</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($subscriptions as $subscription)
						<tr>
							<td>{{$subscription->created_at->format('D dS, M Y')}}</td>
							<td>{{date_format(date_create($subscription->expiry), 'D dS, M Y')}}</td>
							<td>₦{{$subscription->amount}}</td>
							<td>₦{{$subscription->vat}}</td>
							<th>₦{{round($subscription->amount + $subscription->vat)}}</th>
							<th>{{$subscription->status}}</th>
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
