@extends('layouts.app')
@section('title', $tv->name)

@section('content')
<div class="col-lg-7 col-md-12 col-sm-12" style="margin-top: 3%;">
	<h3 class="main-color font-weight-bolder"><span class="float-left">{{$tv->name}}</span> </h3>
</div>
<div class="white-bg" style="width:100%; min-height: 300px; float: left; margin-bottom: 79px;">
	<div style="margin-top: 2%;">
		<div class="row m-0 p-0">
			<div class="col-lg-7 col-md-12 col-sm-12">
				@php 
				$id = explode("=", $tv->youtube);
				$youtube = last($id);
				
				@endphp
				<iframe id="showbox" src="https://www.youtube.com/embed/{{$youtube}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
			<div class="col-lg-5 col-md-12 col-sm-12 p-2">
				@include('components.product-description', ['description' => $tv->description ])
				<div class="col-12 mt-3" style=" display: flex; flex-wrap: wrap; justify-content: space-around;">
					@foreach($tvs->take(9) as $tv)
						<div class="product-item">
							<a class="link" href="{{route('tvs.show', ['id' =>$tv->id])}}">
								<div class="img" style="background-image:url('{{$tv->photo }}'); background-size: cover; background-position: center;">
<!--
									<img src="{{$tv->photo }}" width="100%" />
-->
								</div>
								{{ ( strlen($tv->name) > 15 ? substr($tv->name, 0, 15)."..." : $tv->name ) }}
							</a>
						</div>
					@endforeach
				</div>
				<div class="col-12">
					<a class="btn btn-sm main-color-bg"href="#">See more</a>
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
