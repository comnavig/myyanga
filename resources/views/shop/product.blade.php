@extends('layouts.shop')
@section('title', $product->name)

@section('content')

<div class="col-lg-7 col-md-12 col-sm-12 mt-1">
	<h3 class="main-color"><span class="float-left">{{$product->name}}</span></h3>

</div>

<div class="white-bg" style="width:100%; min-height: 300px; float: left; margin-bottom: 100px;">
	<div style="margin-top: 2%;">
		<div class="row m-0 p-0">
			<div class="col-lg-7 col-md-12 col-sm-12">
				<div class="product-image black-bg">
					@for ($i = 1; $i < count($product->picture); $i++)
						<img src="{{$product->picture[$i]['url']}}" class="d-block m-auto" alt="{{$product->name}}">
					@endfor
				</div>
			</div>
			<div class="col-lg-5 col-md-12 col-sm-12">
				
				<div class="col-12">
					<h3 class="font-weight-bolder" style="font-size: 20px;">{{$product->name}}</h3>
					
					<div class="col-12 m-0 p-0 my-3">
						@include('components.product-description', ['description' => $product->description ])
						@include('components.styling-tips', ['tips' => $product->tips ])
						@include('components.favourite-button', ['product_id' => $product->id ])
						@include('components.share-button')
						@include('components.product-reviews', ['product_id' => $product->id, 'products_purchased' => $products_purchased, 'reviews' => $product->review ])
					</div>
					
					<p>
						<h5><span class="main-color">Price:</span> ₦{{number_format($product->price )}}</h5>
						
					</p>
					<div class="border main-color-border p-2 ">
						@if ($product->quantity <= 0)
							<h5>Not Available</h5>
						@else
							<form method="post" action="{{route('shop.add.cart')}}">
								@csrf
								<input type="hidden" name="product_id" value="{{$product->id}}" />
                                    <div class="form-group">
                                        <label for="quantity" class="main-color">Delivery Cost</label>
                                        @if(isset($product->shipment))
                                            ₦{{ number_format($product->shipment->price) }}
                                            <a class="btn-link" data-toggle="collapse" href="#shippingInfo" role="button" aria-expanded="false" aria-controls="shippingInfo">
                                                <i class="main-color bi bi-caret-down-fill"></i>
                                            </a>
                                    
                                            <div class="collapse" id="shippingInfo">
                                                <div class="card card-body">
                                                    {{ $product->shipment->description }}
                                                </div>
                                            </div>
                                        @else
                                            <p>Shipping information not available.</p>
                                        @endif
                                    </div>

								<div class="form-group">
                                    <label class="main-color">Return Policy</label>
                                    @if(isset($product->shipment) && !empty($product->shipment->return_policy))
                                        <a class="btn-link" data-toggle="collapse" href="#returnpolicy" role="button" aria-expanded="false" aria-controls="returnpolicy">
                                            <i class="main-color bi bi-caret-down-fill"></i>
                                        </a>
                                
                                        <div class="collapse" id="returnpolicy">
                                            <div class="card card-body">
                                                {{ $product->shipment->return_policy }}
                                            </div>
                                        </div>
                                    @else
                                        <p>Return policy information not available.</p>
                                    @endif
                                </div>

								<div class="form-group">
									<label for="quantity" class="main-color">Quantity</label>
									<select class="form-control" name="quantity" id="quantity">
										@for ($i = 0; $i < $product->quantity; $i++)
											<option value="{{$i+1}}">{{$i+1}}</option>
										@endfor
									</select>
								 </div>
								 
								 <button type="submit" class="btn btn-sm main-color-bg">Add Cart <i class="bi bi-cart-fill"></i></button>
							</form>
						@endif
					</div>
				</div>
				<div class="col-12" style="margin-top: 5%;">
					<h5 class="main-color shop-product-by">Design / Provided By</h5>
					<a class="btn-link main-color" href="{{route('pages', ['slug' => $listing['slug'] ])}}"><img src="{{$listing['logo']}}" width="60px" /> {{$listing['name']}}</a>
				</div>
				<div class="col-12">
					<div class="col-12 mx-0 p-0 my-2">
						<h5 class="main-color shop-other-products">Other Products by {{$listing['name']}}</h5>
					</div>
					@foreach($products->take(6) as $product)
						<div class="product-item">
							<a class="link" href="{{route('shop.product', ['id' =>$product->id] )}}">
								<div class="img">
									<img src="{{$product->picture[0]->url }}" width="100%" />
								</div>
								{{ ( strlen($product->name) > 20 ? substr($product->name, 0, 15)."..." : $product->name ) }}
								
								<div class="main-color">
									₦{{number_format($product->price) }}
								</div>
							</a>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	
	</div>
</div>
	
@endsection
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
	<style>
		
	</style>
@endpush
@push('scripts')
	<script async src="https://static.addtoany.com/menu/page.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
     <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
    <script>
		$(document).ready(function() {	
			$(".owl-carousel").owlCarousel({
				items:4,
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
