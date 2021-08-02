@extends('layouts.app')
@section('title', 'Discovers')

@section('content')

<div class="col-12 float-left" style="margin-bottom: 3px;">
	@php
		$today = date("Y-m-d");
		$ads = App\Ads::where([
									['status','=', 'APPROVED'],
									['expired_at','>',$today]	
									])->get();
		$photo = array();
	@endphp
	<div id="" class="adts owl-carousel" data-items="1" >
		<div>
			<a href="#">
				<img class="d-none d-sm-none d-lg-block" src="{{ asset('assets/img/d3.jpg') }}" />
				<img class="d-block d-sm-block d-lg-none" src="{{ asset('assets/img/d3.jpg') }}" width="300px" />
			</a>
		</div>
			@foreach($ads as $ad)
				@php
					$photo = json_decode($ad->photo, true); 
				@endphp
				<div>
					<a href="{{ $ad['url'] }}">
						<img class="d-none d-sm-none d-lg-block" src="{{ $photo['desktop'] }}" alt="{{ $ad['name'] }}"  />
						<img class="d-block d-sm-block d-lg-none" src="{{ $photo['mobile'] }}" alt="{{ $ad['name'] }}"  width="300px" />
					</a>
				</div>
			@endforeach
	</div>
</div>
<!--
<div class="col-12 float-left p-3">
	<h3 class="main-color">Discovers</h3>
</div>
-->

<div class="col-12 float-left" style="margin-bottom: 100px;">
	@php
	$i = 1;
	@endphp
	@foreach($categories as $category)
		<div class="col-12 float-left p-0" @if($i == 1) style="  border-top: 1px solid #DDDDDD;" @endif>
			<h4 class="p-1 discover-title">{{$category->name}} <a class="btn p-0 m-0 btn-sm gold float-right" href="{{route('discovers.category',['id' =>$category->id])}}">See more</a></h4>
		</div>
		<div class="col-12 float-left p-0 discover-items owl-carousel" style="min-height: 130px; padding-bottom: 2%!important; margin-bottom: 2%; border-bottom: 1px solid #DDDDDD;">
		@foreach($category->discovers->sortDesc()->take(8) as $discover)
			<div>
				<a class="link " href="{{route('discovers.story', ['slug' =>$discover->slug])}}">
					<div class="discover-item" style="background-position: top center; background-image: url('{{$discover->picture[0]->url }}');">
						<div class="white clear-black-bg d-flex justify-content-center align-items-center" style="width: 100%;position: absolute; height: 100%;">
							{{ ( strlen($discover->name) > 20 ? substr($discover->name, 0, 15)."..." : $discover->name ) }}
						</div>
					</div>		
					
				</a>
			</div>
		@php 
		$i++;
		@endphp
		@endforeach
		</div>
	@endforeach
</div>
@endsection

@push('styles')
    
@endpush
@push('scripts')
 <script>
		function itemsNumber()
		{
			if (screen.width < 400 )
			{
				return 3;
			}
			else if (screen.width > 401 && screen.width < 575.98 )
			{
				return 3;
			}
			else if (screen.width > 576 && screen.width < 766.98 )
			{
				return 4;
			}
			else if (screen.width > 767 && screen.width < 991.98 )
			{
				return 5;
			}
			else if (screen.width > 992 && screen.width < 1199.98 )
			{
				return 6;
			}
			else if (screen.width > 1200  && screen.width < 1399.98 )
			{
				return 7;
			}
			else (screen.width > 1400 )
			{
				return 8;
			}
			
		}
		$(document).ready(function() {	
			$(".adts").owlCarousel({
				items:1,
				loop:true,
				margin:10,
				autoplay:true,
			});
			
			$(".discover-items").owlCarousel({
				items: itemsNumber(),
				loop:true,
				margin:10,
				autoplay:true,
			});
			
		});
	</script>
 @endpush
