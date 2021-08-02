@extends('layouts.app')
@section('title', 'Premiums')

@section('content')
<div class="col-12 float-left p-3">
	<h3 class="main-color">Premium</h3>
</div>

<div class="col-12 float-left" style="margin-bottom: 100px;">
	@php
	$i = 1;
	@endphp
	@foreach($categories as $category)
		<div class="col-12 float-left p-0" @if($i == 1) style="  border-top: 1px solid #DDDDDD;" @endif>
			<h4 class="p-1 premium-title">{{$category->name}} <a class="btn p-0 m-0 btn-sm gold float-right" href="{{route('premiums.category',['id' =>$category->id])}}">See more</a></h4>
		</div>
		<div class="col-12 float-left p-0 premium-items owl-carousel" style="min-height: 130px; padding-bottom: 2%!important; margin-bottom: 2%; border-bottom: 1px solid #DDDDDD;">
		@foreach($category->premia->sortDesc()->take(8) as $premium)
			<div>
				<a class="link " href="{{route('premiums.story', ['id' =>$premium->id])}}">
					<div class="discover-item" style="background-position: top center; background-image: url('{{$premium->picture[0]->url }}');">
						<div class="white clear-black-bg d-flex justify-content-center align-items-center" style="width: 100%;position: absolute; height: 100%;">
							{{ ( strlen($premium->name) > 20 ? substr($premium->name, 0, 15)."..." : $premium->name ) }}
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
			
			$(".premium-items").owlCarousel({
				items: itemsNumber(),
				loop:true,
				margin:10,
				autoplay:true,
			});
			
		});
	</script>
 @endpush
