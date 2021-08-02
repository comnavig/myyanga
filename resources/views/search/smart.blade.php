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
		<form class="mt-1" method="get" action="{{route('search.smart') }}" >
			@csrf
			<div class="form-row m-0 p-0">
				<div class="col-md-6 col-sm-12 my-4">
					<h4>Brands</h4>
					<div class="col--12 my-2" style="height: 150px; overflow-y: scroll;">
						@foreach($listings->sortBy('name') as $listing)
						<div class="form-check">
							<input class="form-check-input" name="brands[]" type="checkbox" value="{{$listing->id}}"  id="checkB{{$listing->id}}" {{ (in_array($listing->id, $selected['brands']) ? 'checked':'') }} />
							<label class="form-check-label" for="checkB{{$listing->id}}">
								{{$listing->name}}
							</label>
						</div>
						@endforeach
					</div>
				</div>
				
				<div class="col-md-6 col-sm-12 my-4">
					<h4>Categories </h4>
					<div class="col--12 my-2" style="height: 150px; overflow-y: scroll;">
						@foreach($categories->where('parent_id', 0 ) as $parent_category)
						<label class="font-weight-bolder">{{$parent_category->name}}</label>
							@foreach($parent_category->subcategories as $category)
								<div class="form-check">
									<input class="form-check-input" name="categories[]" type="checkbox" value="{{$category->id}}" id="checkC{{$category->id}}" {{ (in_array($category->id, $selected['categories']) ? 'checked':'') }}  />
									<label class="form-check-label" for="checkC{{$category->id}}">
										{{$category->name}}
									</label>
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


@if (count($products) == 0 )

	<div class="col-12 float-left d-flex justify-content-center align-items-center " style="min-height: 100px;">
		<h4 class="main-color" >{{ (empty($keyword) ? "" :"No result for " .$keyword ) }}</h4>
	</div>

	<div class="col-12 float-left d-flex justify-content-center align-items-center search_lady"  style="margin-bottom: 70px;">
		<a href="{{route('search.smart')}}"><img src="{{asset('assets/img/search_lady.jpg') }}" /></a>
	</div>

@else
	<div class="col-12 float-left py-3" style="min-height: 50px;">
		<h4 class="main-color d-inline" >Here are {{ count($products) }} items</h4>
	</div>
	
	<div class="col-12 float-left" style="margin-bottom: 70px;">
		@foreach($products as $product)
			<div class="product-item">
				<a class="link" href="{{route('brand.product', ['slug' =>$product->listing->slug, 'product_slug' =>$product->slug]  )}}">
					<div class="img" >
						<img src="{{$product->picture[0]->url }}" width="100%" />
					</div>
					{{ ( strlen($product->name) > 20 ? substr($product->name, 0, 15)."..." : $product->name ) }}
				</a>
				<div class="brand">
					<a class="link" href="{{route('pages', ['slug' =>$product->listing->slug] )}}">{{$product->listing->name }}</a>
				</div>
			</div>
		@endforeach
	</div>

@endif

@endsection

@push('styles')
    
@endpush
@push('scripts')
 
 @endpush
