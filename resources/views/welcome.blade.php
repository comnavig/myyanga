@extends('layouts.app_new')
@section('title', 'Home')

@section('content')
@php 
	$settings = App\Settings::where('name', 'background_1')->get();
	$premium_page = App\Page::where('slug', 'premium')->get()->first();
	$background = $settings->last();
@endphp
<section class="container" data-aos="fade-up" data-aos-duration="3000">
    <div class="d-flex flex-wrap justify-content-evenly">
    
        @foreach($featuredcategories as $category)
        
        <div class="img-card mx-1 p-1">
            <div class="img-text py-2">
                <h5>{{$category->name}}</h5>
            </div>
            @foreach($category->featured->sortDesc()->take(1) as $featured)
			@php
				$date_entered = date_create($featured->created_at);
				$timeframe = sprintf("%d Days", $category->expiry_date);
				date_add($date_entered, date_interval_create_from_date_string($timeframe));
				$today_date = date_create('now');
			@endphp
			{{--@if ($date_entered > $today_date ) --}}
            <img src="{{str_replace("https://myyanga.fra1.digitaloceanspaces.com/", "https://myyanga.com/storage/", $featured->product->picture[0]->url) }}" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" loading="lazy">
            <div class="row pt-3 mx-3 img-text">
                <div class="col">
                    <h6 onclick="location.href='{{route('pages', ['slug' =>$featured->product->listing->slug] )}}">{{strtoupper($featured->product->listing->name) }}</h6>
                    <p>{{ ( strlen($featured->product->name) > 20 ? substr($featured->product->name, 0, 15)."..." : $featured->product->name ) }} </p>
                    
                </div>
                <div class="col text-end">
                    <button type="button" class="btn  px-1 card-btn" onclick="location.href='{{route('featured.product', ['cat' =>$category->id, 'id' =>$featured->product->id] )}}'">see more <i
                            class="fa-solid fa-arrow-right ms-1"></i></button> 
                </div>
        
            </div>
            
        </div>
        
        {{--@endif--}}
        @endforeach
        @endforeach
        
        <!-- <div class="card py-4 m-1">
            <h5>What To wear today</h5>
            <img src="./images/card-img.jpg">
            <div class="row pt-5 mx-3">
                <div class="col">
                    <h6>Ebony</h6>
                    <p>Nerobeau</p>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn  px-4 card-btn">see more <i class="fa-solid fa-arrow-right"></i></button>
                </div>
            
            </div>
        </div>
        <div class="card py-4 m-1">
            <h5>What To wear today</h5>
            <img src="./images/card-img.jpg">
            <div class="row pt-5 mx-3">
                <div class="col">
                    <h6>Ebony</h6>
                    <p>Nerobeau</p>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn  px-4 card-btn">See more <i class="fa-solid fa-arrow-right"></i></button>
                </div>
            
            </div>
        </div>
        <div class="card py-4 m-1">
            <h5>What To wear today</h5>
            <img src="./images/card-img.jpg">
            <div class="row pt-5 mx-3">
                <div class="col">
                    <h6>Ebony</h6>
                    <p>Nerobeau</p>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn px-4 card-btn"> see more <i class="fa-solid fa-arrow-right"></i></button>
                </div>
            
            </div>
        </div>
        <div class="card py-4 m-1">
            <h5>What To wear today</h5>
            <img src="./images/card-img.jpg">
            <div class="row pt-5 mx-3">
                <div class="col">
                    <h6>Ebony</h6>
                    <p>Nerobeau</p>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn px-4 card-btn"> see more <i class="fa-solid fa-arrow-right"></i></button>
                </div>
        
            </div>
        </div> -->
    </div>
</section>
@endsection
