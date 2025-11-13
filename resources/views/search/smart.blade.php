@extends('layouts.app')
@section('title', 'Smart Search')

@section('content')
<div class="col-12 float-left">
	<div class="container">
<!--
		<div class="col-12 p-0">
			<h3 class="main-color">Smart Search</h3>
		</div>
-->
		<form class="mt-1" method="get" action="{{route('search.smart') }}?#results" >
			@csrf
			<div class="form-row m-0 p-0">
				<div class="col-md-4 col-sm-12 my-4">
					<h4 style="color: #94000e"><b>BRANDS</b></h4>
					<div class="col--12 my-2" style="height: 150px; overflow-y: scroll;">
						@foreach($listings->sortBy('name') as $listing)
						
						<div class="custom-control custom-checkbox checkbox-xl">
                          <input type="checkbox" name="brands[]" class="custom-control-input" id="checkL{{$listing->id}}" value="{{$listing->id}}" >
                          <label class="custom-control-label" for="checkL{{$listing->id}}">{{ucwords(strtolower($listing->name))}}</label>
                        </div>
						@endforeach
					</div>
				</div>
				<div class="col-sm-12 d-block d-md-none black-border" style="border-bottom: 1px solid;"></div>
				<div class="col-md-4 col-sm-12 my-4">
					<h4 style="color: #94000e"><b>CATEGORIES</b> </h4>
					<div class="col--12 my-2" style="height: 150px; overflow-y: scroll;">
						@foreach($categories->where('parent_id', 0 ) as $parent_category)
						<br>
						<label class="font-weight-bolder">{{$parent_category->name}}</label>
							@foreach($parent_category->subcategories as $category)
								
								<div class="custom-control custom-checkbox checkbox-xl">
                                  <input type="checkbox" name="categories[]" class="custom-control-input" id="checkK{{$category->id}}" value="{{$category->id}}" >
                                  <label class="custom-control-label" for="checkK{{$category->id}}">{{ucwords(strtolower($category->name))}}</label>
                                </div>
								@endforeach
						@endforeach
					</div>
				</div>
				<div class="col-sm-12 d-block d-md-none black-border" style="border-bottom: 1px solid;"></div>
				<div class="col-md-4 col-sm-12 my-4">
					<h4 style="color: #94000e"><b>LOCATIONS</b> </h4>
					<div class="col--12 my-2" style="height: 150px; overflow-y: scroll;">
					
						@foreach($locations->where('parent_id', 0 ) as $parent_location)
						<br>
						<label class="font-weight-bolder">{{strtoupper($parent_location->name)}}</label>
							@foreach($parent_location->areas as $location)
								
								<div class="custom-control custom-checkbox checkbox-xl">
                                  <input type="checkbox" name="locations[]" class="custom-control-input" id="checkC{{$location->id}}" value="{{$location->id}}" >
                                  <label class="custom-control-label" for="checkC{{$location->id}}">{{$location->name}}</label>
                                </div>
								@endforeach
						@endforeach
					</div>
				</div>
				
				<div class="col-md-12 col-sm-12 my-2"><button class="btn btn-block main-color-bg my-2 my-sm-0" type="submit">Search</button></div>
			</div>
		</form>
	</div>
</div>


<!--@if (count($products) == 0 )-->

	<!--div class="col-12 float-left d-flex justify-content-center align-items-center " style="min-height: 100px;">
<!--		<h4 class="main-color" >{{ (empty($keyword) ? "" :"No result for " .$keyword ) }}</h4>-->
<!--	</div>-->

<!--	<div class="col-12 float-left d-flex justify-content-center align-items-center search_lady"  style="margin-bottom: 70px;">-->
<!--		<a href="{{route('search.smart')}}"><img src="{{asset('assets/img/search_lady.jpg') }}" /></a>-->
<!--	</div-->-->
	
<!--	<div id="results" class="col-12 float-left py-3" style="min-height: 50px;">-->
<!--		<h4 class="main-color d-inline" >{{ (empty($keyword) ? "" :"No result for " .$keyword ) }}</h4>-->
<!--	</div>-->

<!--@else-->
<!--	<div id="results" class="col-12 float-left py-3" style="min-height: 50px;">-->
<!--		<h4 class="main-color d-inline" >Here are {{ count($products) }} items</h4>-->
<!--	</div>-->
	
<!--	<div class="col-12 float-left" style="margin-bottom: 300px; display: flex; flex-wrap: wrap;  justify-content: space-around;">-->
<!--		@foreach($products as $product)-->
<!--			<div class="product-item">-->
<!--				<a class="link" href="{{route('brand.product', ['slug' =>$product->listing->slug, 'product_slug' =>$product->slug]  )}}">-->
<!--					<div class="img" >-->
<!--						<img src="{{$product->picture[0]->url }}" width="100%" />-->
<!--					</div>-->
<!--					{{ ( strlen($product->name) > 20 ? substr($product->name, 0, 15)."..." : $product->name ) }}-->
<!--				</a>-->
<!--				<div class="brand">-->
<!--					<a class="link" href="{{route('pages', ['slug' =>$product->listing->slug] )}}">{{$product->listing->name }}</a>-->
<!--				</div>-->
<!--			</div>-->
<!--		@endforeach-->
<!--	</div>-->
<!--<div style="padding: 20px 10px;"></div>-->
<!--@endif-->


@if (count($products) == 0)
    <div id="results" class="col-12 float-left py-3" style="min-height: 50px;">
        <h4 class="main-color d-inline" >{{ (empty($keyword) ? "" :"No result for " .$keyword ) }}</h4>
    </div>
@else
    <div id="results" class="col-12 float-left py-3" style="min-height: 50px;">
        <!--<h4 class="main-color d-inline" >Here are {{ count($products) }} items</h4>-->
        <h4 class="main-color d-inline" >Here are {{ $products->count() }} of {{ $products->total() }} items</h4>
    </div>

    <div class="col-12 float-left" style="margin-bottom: 50px; display: flex; flex-wrap: wrap;  justify-content: space-around;">
        @foreach($products as $product)
            <div class="product-item">
                <a class="link" href="{{route('brand.product', ['slug' =>$product->listing->slug, 'product_slug' =>$product->slug]  )}}">
                    <div class="img" >
                        <!--<img src="{{$product->picture[0]->url }}" width="100%" />-->
                        <img 
                                src="{{ str_replace('https://myyanga.fra1.digitaloceanspaces.com/', 'https://myyanga.com/storage/', $product->picture[0]['url']) }}" 
                                width="100%" 
                                alt="Product Image"
                            />
                    </div>
                    {{ ( strlen($product->name) > 20 ? substr($product->name, 0, 15)."..." : $product->name ) }}
                </a>
                <div class="brand">
                    <a class="link" href="{{route('pages', ['slug' =>$product->listing->slug] )}}">{{$product->listing->name }}</a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination links -->
    <div class="col-12 float-left" style="padding-bottom: 100px;">
        <div class="pagination-wrapper">
            <!--{{ $products->links() }}-->
            {{ $products->withQueryString()->links() }}
        </div>
    </div>


<div style="padding: 20px 50px;"></div>
@endif

@endsection


@push('styles')
    
@endpush
@push('scripts')
 
 @endpush
