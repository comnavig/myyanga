@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page.title', 'Dashboard')
@section('content')
<div class="container mt-2 ">
	<div class="row dashboard">
		<div class="col-lg-4 col-md-6 col-sm-12 stat">
			<div class="d-flex flex-column justify-content-center align-items-center box">
				<h3 class="main-color">
					{{$users->where('type', 'BUSINESS')->count()}}
				</h3>
			</div>
			<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
				<a class="btn-block text-uppercase white" href="{{route('admin.business.users')}}">Businesses</a>
			</div>
		</div>
		
		<div class="col-lg-4 col-md-6 col-sm-12 stat">
			<div class="d-flex flex-column justify-content-center align-items-center box">
				<h3 class="main-color">
					{{$users->where('type', 'INDIVIDUAL')->count()}}
				</h3>
			</div>
			<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
				<a class="btn-block text-uppercase white" href="{{route('admin.individual.users')}}">Individual</a>
			</div>
		</div>
		
		<div class="col-lg-4 col-md-6 col-sm-12 stat">
			<div class="d-flex flex-column justify-content-center align-items-center box">
				<h3 class="main-color">
					{{$listings->count()}}
				</h3>
			</div>
			<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
				<a class="btn-block text-uppercase white" href="{{route('admin.listings')}}">Brands</a>
			</div>
		</div>
		
		<div class="col-lg-4 col-md-6 col-sm-12 stat">
			<div class="d-flex flex-column justify-content-center align-items-center box">
				<h3 class="main-color">
					{{$products->count()}}
				</h3>
			</div>
			<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
				<a class="btn-block text-uppercase white" href="{{route('admin.products')}}">products</a>
			</div>
		</div>
		
		<div class="col-lg-4 col-md-6 col-sm-12 stat">
			<div class="d-flex flex-column justify-content-center align-items-center box">
				<h3 class="main-color">
					{{$ply_uploads->count() ?? 0}}
				</h3>
			</div>
			<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
				<a class="btn-block text-uppercase white" href="{{route('admin.pyls.uploads')}}">post your looks uploads</a>
			</div>
		</div>
		
		<div class="col-lg-4 col-md-6 col-sm-12 stat">
			<div class="d-flex flex-column justify-content-center align-items-center box">
				<h3 class="main-color">
					{{$products_sold->count() ?? 0}}
				</h3>
			</div>
			<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
				<a class="btn-block text-uppercase white" href="{{route('admin.products.sold')}}">products sold</a>
			</div>
		</div>
		
		<div class="col-lg-4 col-md-6 col-sm-12 stat">
			<div class="d-flex flex-column justify-content-center align-items-center box">
				<h3 class="main-color">
					{{$orders->count() ?? 0}}
				</h3>
			</div>
			<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
				<a class="btn-block text-uppercase white" href="{{route('admin.products.orders')}}">Orders</a>
			</div>
		</div>
	
		<div class="col-lg-4 col-md-6 col-sm-12 stat">
			<div class="d-flex flex-column justify-content-center align-items-center box">
				<h3 class="main-color">
					{{$premia->count() ?? 0}}
				</h3>
			</div>
			<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
				<a class="btn-block text-uppercase white" href="{{route('admin.premia')}}">Premium</a>
			</div>
		</div>
	
		<div class="col-lg-4 col-md-6 col-sm-12 stat">
			<div class="d-flex flex-column justify-content-center align-items-center box">
				<h3 class="main-color">
					{{$premium_subscriptions->where('status','PAID')->count() ?? 0}}
				</h3>
			</div>
			<div class="main-color-bg p-3" style="width: 100%; height: 50px;">
				<a class="btn-block text-uppercase white" href="{{route('admin.users.premium.subscriptions')}}">Paid Premium Subscriptions</a>
			</div>
		</div>
	
	</div>

</div>

@endsection
