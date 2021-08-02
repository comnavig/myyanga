@extends('layouts.user')
@section('title', 'My Profile')
@section('page.title', 'My Profile')
@section('content')
<div class="container mt-2 ">
	<div class="col-12 mt-2 border-1 main-border-color">
		<div class="row profile">
			<div class="col-md-3 col-sm-12 mt-2">
				<div class="img">
					<img src="{{$user->avatar}}" width="100%"/>
				</div>
			</div>
			<div class="col-md-9 col-sm-12 mt-2">
				<h5><small style="font-size: 11px;">NAME</small><br/> {{$user->name}}</h5>
				<h5><small style="font-size: 11px;">MOBILE</small><br/> {{$user->mobile}}</h5>
				<h5><small style="font-size: 11px;">EMAIL</small><br/> {{$user->email}}</h5>
				<div class="col-12">
					<a class="btn btn-sm main-color-bg float-right" href="{{route('user.profile.edit')}}">Edit profile</a>
					<a class="btn btn-sm main-color-bg float-right mx-2" href="{{route('user.notification.edit')}}">Edit notification</a>
				</div>
				
			</div>
		</div>
<!--
		<div style="width: 150px; height: 150px; float: left; overflow: hidden; margin-right: 10px;">
			<img src="{{$user->avatar}}" width="100%"/>
		</div>
		<div style="">
			<a class="btn btn-sm main-color-bg float-right" href="{{route('user.profile.edit')}}">edit profile</a>
			<h5><small style="font-size: 11px;">NAME</small><br/> {{$user->name}}</h5>
			<h5><small style="font-size: 11px;">MOBILE</small><br/> {{$user->mobile}}</h5>
			<h5><small style="font-size: 11px;">EMAIL</small><br/> {{$user->email}}</h5>
			
		</div>
-->
	</div>
	
	<div class="col-12"  style="border-top: 2px solid #dddddd;">
		<div class="row dashboard">
			<div class="col-lg-3 col-md-6 col-sm-12 stat">
				<div class="d-flex flex-column justify-content-center align-items-center box">
					<h3 class="main-color">
						{{$user->favourites->count() ?? '0'}}
					</h3>
				</div>
				<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
					<a class="btn-block text-uppercase white" href="{{route('user.favourites')}}">Favourites</a>
				</div>
			</div>
			
			<div class="col-lg-3 col-md-6 col-sm-12 stat">
				<div class="d-flex flex-column justify-content-center align-items-center box">
					<h3 class="main-color">
						{{$user->orders->count() ?? '0'}}
					</h3>
				</div>
				<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
					<a class="btn-block text-uppercase white" href="{{route('user.orders')}}">Orders</a>
				</div>
			</div>
			
			<div class="col-lg-3 col-md-6 col-sm-12 stat">
				<div class="d-flex flex-column justify-content-center align-items-center box">
					<h3 class="main-color">
						{{$user->follows->count() ?? '0'}}
					</h3>
				</div>
				<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
					<a class="btn-block text-uppercase white" href="{{route('user.following')}}">Following</a>
				</div>
			</div>
			
			<div class="col-lg-3 col-md-6 col-sm-12 stat">
				<div class="d-flex flex-column justify-content-center align-items-center box">
					<h3 class="main-color">
						{{$user->pyls->count() ?? '0'}}
					</h3>
				</div>
				<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
					<a class="btn-block text-uppercase white" href="{{route('user.pyls')}}">PYL Stats</a>
				</div>
			</div>
			
			<div class="col-sm-12 my-4"  style="min-height:250px; border-top: 2px solid #dddddd; margin-top: 20px;">
				<h4 class="main-color">Premium subscription <a class="btn btn-sm main-color-bg float-right" href="{{route('user.premium.subscriptions')}}">see all</a></h4>
				<div class="col-12 d-flex justify-content-center align-items-center flex-column p-0" style="min-height: 100px;">
					@if(empty($active_subscription))
						<strong>No Subscription Yet</strong>
						<a class="btn btn-link btn-sm main-color-bg text-center" href="{{route('user.premium.subscriptions')}}">Subscribe now</a>
					@else
						@if( $active_subscription->daysOver($active_subscription->expiry) )
							<strong>No Active Subscription</strong>
							<a class="btn btn-link btn-sm main-color-bg text-center" href="{{route('user.premium.subscriptions')}}">Subscribe now</a>
						@else
							<h4> You have <strong class="main-color">{{$active_subscription->daysLeft($active_subscription->expiry) }}</strong> days left</h4>
						@endif
					@endif
				</div>
				<div class="col-12 p-0">
					@if(!empty($active_subscription))
						<div class="table-responsive-sm">
							<table class="table">
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
									<tr>
										<td>{{$active_subscription->created_at->format('D dS, M Y')}}</td>
										<td>{{date_format(date_create($active_subscription->expiry), 'D dS, M Y')}}</td>
										<td>₦{{$active_subscription->amount}}</td>
										<td>₦{{$active_subscription->vat}}</td>
										<th>₦{{round($active_subscription->amount + $active_subscription->vat)}}</th>
										<th>{{$active_subscription->status}}</th>
									</tr>
								</tbody>
							</table>
						</div>
					@endif
				</div>
			</div>
			
			<div class="col-sm-12 my-4">
				<h4 class="main-color">Your last activities <a class="btn btn-sm main-color-bg float-right" href="{{route('user.activities')}}">see all</a></h4>
				@foreach( $activities->sortByDesc('date')->take(10) as $activity)
					<div class="col-12 py-2"  style="border-bottom: 2px solid #dddddd;">
						<p><i class="fas fa-flag"></i> {{$activity['activity']}} on {{$activity['date']->format('jS M Y h:iA')}}</p>
					</div>
				@endforeach
				
			</div>
		</div>
		
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
