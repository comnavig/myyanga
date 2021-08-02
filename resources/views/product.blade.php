@extends('layouts.app')
@section('title', $product[0]['name'])

@section('content')
<div class="col-lg-7 col-md-12 col-sm-12 py-0" style="padding-top: 3%;">
	<h3 class="main-color font-weight-bolder"><span class="float-left">{{$product[0]['name']}}</span> </h3>
</div>
<div class="white-bg" style="width:100%; min-height: 300px; float: left;">
	<div style="margin-top: 2%; margin-bottom: 75px;">
		<div class="row m-0 p-0">
			<div class="col-lg-7 col-md-12 col-sm-12">
				<div class="product-image black-bg">
					@for ($i = 1; $i < count($product[0]['picture']); $i++)
						<img src="{{$product[0]['picture'][$i]['url']}}" class="d-block m-auto" alt="{{$product[0]['name']}}">
					@endfor
				</div>
				
			</div>
			<div class="col-lg-5 col-md-12 col-sm-12">
				
				<div class="col-12 my-3">
<!--
					<h3 class="font-weight-bolder" style="font-size: 20px;">{{$product[0]['name']}}</h3>
-->
					@include('components.product-description', ['description' => $product[0]['description'] ])
					@include('components.styling-tips', ['tips' => $product[0]['tips'] ])
					@include('components.favourite-button', ['product_id' => $product[0]['id'] ])
					@include('components.share-button')
					
				</div>
				<div class="col-12 my-2">
					<img src="{{$listing['logo']}}" width="100px" style="margin-right: 3px;" />{{$listing['name']}}
				</div>
				<div class="col-12" style=" display: flex; flex-wrap: wrap;  justify-content: space-around;">
					@foreach($products->take(12) as $product)
						<div class="product-item">
							<a class="link" href="{{route('brand.product', ['slug' =>$product->listing->slug, 'product_slug' =>$product->slug] )}}">
								<div class="img">
									<img src="{{$product->picture[0]->url }}" width="100%" />
								</div>
								{{ ( strlen($product->name) > 20 ? substr($product->name, 0, 15)."..." : $product->name ) }}
							</a>
						</div>
					@endforeach
				</div>
				<div class="col-12">
					<a class="btn main-color-bg" href="{{route('pages',['slug' => $listing['slug'] ])}}">See More</a>
				</div>
			</div>
		</div>
	
	</div>
</div>
	
@endsection

@push('styles')

@endpush
@push('scripts')
    <script async src="https://static.addtoany.com/menu/page.js"></script>
@endpush
