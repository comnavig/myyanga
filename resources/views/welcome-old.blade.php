@extends('layouts.app')
@section('title', 'Home')

@section('content')
@php 
	$settings = App\Settings::where('name', 'background_1')->get();
	$premium_page = App\Page::where('slug', 'premium')->get()->first();
	$background = $settings->last();
@endphp

<div class=" d-none d-sm-none d-lg-block" >
	<div class=" col-12 d-flex justify-content-center align-items-center" style="min-height: 220px; background-image:url('{{$background->value}}');">
		<h3 class="text-center white font-weight-bolder welcome-greeting" >
			Discover and connect with the best <br/>of African fashion and creativity, <br/>all in one spot.
			<br/><br/><a class="btn btn-lg golden-btn" href="{{route('tour')}}">Slide Tour</a>
			<br/>
		</h3>
		
	</div>
</div>

<!--
@auth
	@php
		$user = auth()->user();
	@endphp
	@if($user->type == "INDIVIDUAL")
		<div class="collapse show" id="closePCollapse">
			<div class="fixed-top d-flex justify-content-center align-items-center" style="height:100%; background-color: rgba(21,21,21, .45);">
				<div class="col-lg-3 col-md-4 col-sm-10 mx-4 white-bg">
					<div style="width: 20px; height: 20px; position: absolute; top: -15px; right: -21px;">
						<a class="btn-link main-color" data-toggle="collapse" href="#closePCollapse" role="button" aria-expanded="false" aria-controls="closeCollapse">
							<i class="bi bi-x-circle-fill"></i>
						</a>	
					</div>
					
					
					<div class="col-12 p-4">
						<center><p>{!!$premium_page->description!!}</p></center>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 m-0 p-1">
							@auth
							<a  class="btn main-color-bg btn-block rounded-0" href="{{route('premiums')}}">
								View Premium
							</a>
							@endauth
							@guest
							<a  class="btn main-color-bg btn-block rounded-0" href="{{route('login', ['redirect' => route('premiums') ] )}}">
								View Premium
							</a>
							@endguest
						</div>
						
					</div>
					 
				</div>
			</div>
		</div>
	@endif
@endauth
@guest
	<div class="collapse show" id="closePCollapse">
		<div class="fixed-top d-flex justify-content-center align-items-center" style="height:100%; background-color: rgba(21,21,21, .45);">
			<div class="col-lg-3 col-md-4 col-sm-10 mx-4 white-bg">
				<div style="width: 20px; height: 20px; position: absolute; top: -15px; right: -21px;">
					<a class="btn-link main-color" data-toggle="collapse" href="#closePCollapse" role="button" aria-expanded="false" aria-controls="closeCollapse">
						<i class="bi bi-x-circle-fill"></i>
					</a>	
				</div>
				
				
				<div class="col-12 p-4">
					<center><p>{!!$premium_page->description!!}</p></center>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 m-0 p-1">
						@auth
						<a  class="btn main-color-bg btn-block rounded-0" href="{{route('premiums')}}">
							View Premium
						</a>
						@endauth
						@guest
						<a  class="btn main-color-bg btn-block rounded-0" href="{{route('login', ['redirect' => route('premiums') ] )}}">
							View Premium
						</a>
						@endguest
					</div>
					
				</div>
				 
			</div>
		</div>
	</div>
@endguest
-->

<div class="col-12 mt-4 d-none d-sm-none d-lg-block">
	<div class="row">
		@foreach($featuredcategories as $category)
			
			<div class="col-lg-4 col-md-12 col-sm-12 float-left" style="margin-top: 3%;">
				<h5 class="main-color font-weight-bold">{{$category->name}} </h5>
				@foreach($category->featured->sortDesc()->take(1) as $featured)
				@php
					$date_entered = date_create($featured->created_at);
					$timeframe = sprintf("%d Days", $category->expiry_date);
					date_add($date_entered, date_interval_create_from_date_string($timeframe));
					$today_date = date_create('now');
				@endphp
					<div class="lg-product-item">
						{{--@if ($date_entered > $today_date ) --}}
							<a class="link" href="{{route('featured.product', ['cat' =>$category->id, 'id' =>$featured->product->id] )}}">
								<div class="img">
									<img src="{{str_replace("https://myyanga.fra1.digitaloceanspaces.com/", "https://myyanga.com/storage/", $featured->product->picture[0]->url) }}" width="100%" />
								</div>
								<br>
								<b style="color: #000000;"> {{ ( strlen($featured->product->name) > 20 ? substr($featured->product->name, 0, 15)."..." : $featured->product->name ) }} </b>https://myyanga.com/home
								
								<a class="btn btn-outline-secondary float-right btn-sm" href="{{route('featured.product', ['cat' =>$category->id, 'id' =>$featured->product->id] )}}">See more <i class="fa-solid main-color fa-arrow-right"></i></a>
								{{-- <a class="link btn btn-sm float-right main-color btn-link mt-1" href="{{route('featured.category', ['cat' =>$category->id ] )}}">See more</a> --}}
							</a>
							<div class="brand">
								<a class="link" style="color: #850713;" href="{{route('pages', ['slug' =>$featured->product->listing->slug] )}}">{{strtoupper($featured->product->listing->name) }}</a>
							</div>
						{{--@endif--}}
					</div>
				@endforeach
			</div>
		@endforeach
		
	</div>
</div>

@php
 $fc = $featuredcategories->last();
 $last = $fc->featured->sortDesc()->take(1);
 $last = $last->last();
 
@endphp
<div class="col-12 p-0 m-0 d-block d-sm-block d-lg-none" style="padding-left:5px !important; padding-right:5px !important;">
    <br/> 
	<!--<div class="today-img col-12 d-flex justify-content-center align-items-center" style="height: 15%; background-image:url('{{$background->value}}');">-->
	<div class="today-img col-12 d-flex justify-content-center align-items-center" style="height: 15vh; background-image:url('https://myyanga.com/storage/settings/cxukWLWJCMIcRL40wRDQTot2umMZodA1cc0iLD4Q.jpg');">
	
		<h3 class="text-center py-3 white font-weight-bolder welcome-greeting" style="font-size: 20px;">
		<br/>
			The Best of <br/> African Fashion creativity, <br/> in one spot.
			<!--p style="font-size: 16px">Explore &nbsp;&nbsp;&nbsp;   Shop  &nbsp;&nbsp;&nbsp; Win</p> 
			<br/><a class="btn btn-lg golden-btn" href="{{route('tour')}}">Slide Tour</a>
			<br/-->
			<br>
			<br>
			
		</h3>
		<!--<div class="col-12 desc clear-black-bg">-->
		    
	 <!--   </div>-->
	</div>

</div>
<!--div class="container" style="padding-left:20px !important; padding-right:20px !important;">
                  <div class="row align-middle" style="background: rgba(0,0,0,0.3); color:white; ">
                      <div class="col-10 justify-content-center "><h3 class="text-center white font-weight-bolder align-middle welcome-greeting" style="align:left; font-size: 20px !important; vertical-align: middle;">
			                </div>
                      <!--div class="col-2 justify-content-right align-items-center"><a href="{{ route('today') }}"> <img src="{{asset('assets/img/arrow.png')}}" /></a></div>
                  </div>
</div-->



<div id="carouselExampleIndicators" class="carousel slide" style="height: 65vh;" data-ride="carousel"> 
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner"> 
    @php
        $i =  1;
    @endphp
    @foreach($featuredcategories as $category)
    
		@foreach($category->featured->sortDesc()->take(1) as $featured) 
		@php
			$date_entered = date_create($featured->created_at);
			$timeframe = sprintf("%d Days", $category->expiry_date);
			date_add($date_entered, date_interval_create_from_date_string($timeframe));
			$today_date = date_create('now');
		@endphp
		{{--  @if ($date_entered > $today_date ) --}}
            <div class="carousel-item {{($i == 1) ? 'active': ''}}">
                
              {{--img src="{{$featured->product->picture[1]->url }}" class="d-block w-100" alt="..." style="background-size: contain; padding-left:5px !important; padding-right:5px !important; height:85%;"> --}}
              
              <div class="today-img" style="padding-left:5px !important; padding-right:5px; height: 65vh;">
		<!--
									<img src="{{$featured->product->picture[1]->url }}" class="d-block w-100" alt="...">
		-->
		                            <div style="background-size: contain; background-position: top; !important; height:100%; background-image: url('{{str_replace("https://myyanga.fra1.digitaloceanspaces.com/", "https://myyanga.com/storage/", $featured->product->picture[0]->url) }}');">
									    <div class="col-12 desc clear-black-bg">
										    <h5 class="gold font-weight-bold">{{$category->name}} </h5>
										    <a class="white link font-weight-bolder" href="{{route('featured.product', ['cat' =>$category->id, 'id' =>$featured->product->id] )}}">{{ ( strlen($featured->product->name) > 20 ? substr($featured->product->name, 0, 15)."..." : $featured->product->name ) }}</a>
										    <br/>
										    <a class="white link" href="{{route('pages', ['slug' =>$featured->product->listing->slug] )}}">by {{$featured->product->listing->name }}</a>
										    <a class="link gold float-right mt-1 mr-2" href="{{route('featured.category', ['cat' =>$category->id ] )}}">See Previous</a>
									    </div>
									    </div>
								</div>
              
              
            </div>
         {{-- @endif --}}
         @endforeach
         @php 
         $i++; 
         @endphp
     @endforeach
    
    

  </div>
  <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </button>
</div>
     
{{-- <div class="col-12 d-block d-sm-block d-lg-none" style="padding-left:5px !important; padding-right:5px !important; height:85%; background-image: url('{{$last->product->picture[0]->url ?? ""}}'); background-size: cover; background-position: top center;">
    
    
	<!--div class="clear-blacker-bg d-flex justify-content-left align-items-top" style="height: 100%;">
	
	    <!--a href="{{ route('today') }}"> <img src="{{asset('assets/img/swipe-right.png')}}" /></a>
		<h3 class="text-top white font-weight-bolder welcome-greeting" style="align:left;">
			What to wear today
			
			<!--br/><br/><a style="font-size: 1.4rem" class="btn btn-link white" href="{{route('today')}}">ENTER</a>
			<br/><br/><a class="btn btn-lg golden-btn" href="{{route('tour')}}">Slide Tour</a>
			
		</h3>
		<a href="{{ route('today') }}"> <img src="{{asset('assets/img/swipe-2.png')}}" /></a-->
	</div> --}}
</div>

</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/landingpage.css')}}">
	<style>
	
	    .carousel-control-next, .carousel-control-prev {
            background: rgba(0,0,0,0.1);
            border: 0;
        }
        
        .carousel-inner {
            /*height: 85vh !important;*/
            padding-bottom: 50px;
        }
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

		.btn-primary {
			color: #000;
			background-color: #fff;
			border-color: #357ebd; /*set the color you want here*/
		}
		.btn-outline-secondary:hover, .btn-outline-secondary:focus, .btn-outline-secondary:active, .btn-outline-secondary.active, .open>.dropdown-toggle.btn-outline-secondary {
			color: #85000b;
			background-color: #fff;
			border-color: #85000b; /*set the color you want here*/
		}
		
		.tab-pane {padding:6px 0px; border-top: 2px solid #000000; border-bottom: 2px solid #000000;}
		
		.fade:not(.show) {
    display: none;
}
	</style>
@endpush
@push('scripts')

    
    {{-- @if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swiped-events/1.1.6/swiped-events.min.js" integrity="sha512-AVWkE7WmKyUrLVDkwiGd1k2J/S6IDwbtRXP052gZu+M9V/BgLRBS5ZFHZ7qxlfIZ6SUcYR+8cIaD7vv7SwLjEg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.addEventListener('swiped', function(e) {
            console.log(e.target); // the element that was swiped
            console.log(e.detail.dir); // swiped direction
            location.href = "{{ route('today') }}";
        });
    </script>
    @endif --}}
     <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
     <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
     <!--<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/e7f64a8959eb61095fc704506/1f73469edd8f72b4a3dd6429a.js");</script>-->
    <script>
		$(document).ready(function() {	
			$(".owl-carousel").owlCarousel({
				items:4,
				loop:true,
				margin:10,
				autoplay:true,
			});
			
		});

		new Splide( '.splide', {autoplaySpeed
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
