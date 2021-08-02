@extends('layouts.app')
@section('title', 'Home')

@section('content')

<div class="col-12 p-0">
	<div class="tour">
		<div class="owl-carousel">
				@for($i = 1; $i < 7; $i++)
				
					@php
						$filename = "assets/img/tour/tp".$i.".jpg"; 
					@endphp
				<div class="tour-img" style="background-image: url('{{ asset($filename) }}');"></div>
				@endfor
		</div>
	</div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
	<style>
		.brand {color: #000000; height: 16px; letter-spacing: .2px; line-height: 16px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}
		.brand .link {color: #000000; font-size: 11px; letter-spacing: .2px; line-height: 20px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}
		.link {color: #000000; font-size: 14px; letter-spacing: .2px; line-height: 20px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}
		.link:hover, .brand .link:hover {color: #85000b;}

		.gp-tabs { margin-bottom: 10px!important; border: 0px;}
		
		.gp-tabs .active{ color: #E1232B!important; border-radius: 0px; border: 0px; border-right: 2px solid #000000!important;}
		.gp-tabs .nav-item .nav-link{font-size: 18px; font-weight: bold; color: #000000; padding: 0rem 1rem!important;}
		.gp-tabs .nav-item .nav-link{ border-radius: 0px; border: 0px; border-right: 2px solid #000000;}
		.no-border{ border-radius: 0px;  border: 0px!important;}
		
		.gp-tabs .nav-link:hover{color: #E1232B}
		
		.tab-pane {padding:6px 0px; border-top: 2px solid #000000; border-bottom: 2px solid #000000;}
		
		.fade:not(.show) {
    display: none;
}
	</style>
@endpush
@push('scripts')
     <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
     <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
    <script>
		$(document).ready(function() {	
			$(".owl-carousel").owlCarousel({
				items:1,
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
