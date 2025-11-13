@extends('layouts.app-others')
@section('title', 'Shop')

@section('content')

    <section class="container py-5">
        <h4 class="page-title py-3 product-title"></h4>
        <div class="row single-product  justify-content-evenly">
            <div class="col-md-7 text-center product-review-img p-5 mx-1">
                @for ($i = 1; $i < count($product[0]['picture']); $i++)
                <img src="{{$product[0]['picture'][$i]['url']}}" alt="{{$product[0]['name']}}" id="product-img">
                @endfor
            </div>
            <div class="col-md text-left mx-5 product-details">
            
                <p>Description: <span id="product-desc">{{ $product[0]['description'] }}</span></p>
                <!-- <p>Reviews: <span> djhidhidhuihsi</span></p> -->
                
               
                <p id="pppp"></p>
                @include('components.styling-tips', ['tips' => $product[0]['tips'] ])
                @include('components.favourite-button', ['product_id' => $product[0]['id'] ])
			    @include('components.share-button')
                <div class="col-12 my-2">
					<img src="{{$listing['logo']}}" width="100px" style="margin-right: 3px;" />{{$listing['name']}}
				</div>
				<div class="col-12" style=" display: flex; flex-wrap: wrap;  justify-content: space-around;">
					@foreach($products->take(12) as $product)
						<div class="col-6 product-item">
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
                <div>
                <button type="button" class="btn btn-lg hero-btn my-3 cart-btn"> <i class="fa-sharp fa-solid fa-cart-plus"></i> add to cart</button>
                </div>
               
            </div>
        </div>
        
    </section>

@endsection
