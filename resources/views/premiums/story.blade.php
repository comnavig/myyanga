@extends('layouts.app')
@section('title', $premium->name)

@section('content')
<div class="col-lg-7 col-md-12 col-sm-12" style="margin-top: 3%;">
	<h3 class="main-color font-weight-bolder"><span class="float-left">{{$premium->name}}</span> </h3>
</div>
<div class="white-bg" style="width:100%; min-height: 300px; float: left; margin-bottom: 79px;">
	<div style="margin-top: 2%;">
		<div class="row m-0 p-0">
			<div class="col-lg-7 col-md-12 col-sm-12">
				<div class="product-image">
					<img src="{{$premium->picture[1]->url}}" />
				</div>
				@include('components.product-description', ['description' => $premium->description ])
				@guest
					<a class="btn btn-link main-color m-0 p-0 my-2" style="font-size: 17px;" href="{{ route('login', ['redirect' => url()->full() ]) }}"> Login to Share</a>
				@endguest
				@auth
					<p class="gold"><strong>Share the Fun!</strong><br/><br/>Sharing is caring, and sharing is easy! We made it easy!</p>
				@endauth
				@include('components.share-button')
			</div>
			<div class="col-lg-5 col-md-12 col-sm-12 p-2">
				
				<div class="col-12" style=" display: flex; flex-wrap: wrap; justify-content: space-around;">
					@foreach($premiums->take(9) as $premium)
						<div class="product-item">
							<a class="link" href="{{route('premiums.story', ['id' =>$premium->id])}}">
								<div class="img" >
									<img src="{{$premium->picture[0]->url }}" width="100%" />
								</div>
								{{ ( strlen($premium->name) > 20 ? substr($premium->name, 0, 15)."..." : $premium->name ) }}
							</a>
						</div>
					@endforeach
				</div>
				<div class="col-12">
					<a class="btn btn-sm main-color-bg"href="{{route('premiums.category',['id' => $premium->premium_category_id ])}}">See more</a>
				</div>
			</div>
		</div>
	
	</div>
</div>
	
@endsection

@push('styles')
	<style>
		#showbox {width: 100%; height: 60vh; }
	</style>
@endpush
@push('scripts')
    <script async src="https://static.addtoany.com/menu/page.js"></script>
@endpush
