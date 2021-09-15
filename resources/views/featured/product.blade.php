@extends('layouts.app')
@section('title', $product[0]['name'])

@section('content')
<div class="col-lg-7 col-md-12 col-sm-12" style="margin-top: 3%;">
	<h3 class="main-color font-weight-bolder"><span class="float-left">{{$product[0]['name']}}</span> </h3>
</div>
<div class="white-bg" style="width:100%; min-height: 300px; float: left;">
	<div style="margin-top: 2%;">
		<div class="row m-0 p-0">
			<div class="col-lg-7 col-md-12 col-sm-12">
				<div class="product-image">
					@for ($i = 1; $i < count($product[0]['picture']); $i++)
						<img src="{{$product[0]['picture'][$i]['url']}}" class="d-block m-auto" alt="{{$product[0]['name']}}">
					@endfor
				</div>
			</div>
			<div class="col-lg-5 col-md-12 col-sm-12 p-2">
				
				<div class="col-12 m-0 p-0 my-3">
					@include('components.product-description', ['description' => $product[0]['description'] ])
					@include('components.styling-tips', ['tips' => $product[0]['tips'] ])
					@include('components.favourite-button', ['product_id' => $product[0]['id'] ])
					@include('components.share-button')
				</div>
					
				<div class="col-12 my-2">
					<h4 class="mani-color">{{$category->name}}</h4>
				</div>
				<div class="col-12" style=" display: flex; flex-wrap: wrap; justify-content: space-around;">
					@foreach($category->featured->sortDesc()->take(12) as $featured)
						<div class="product-item">
							<a class="link" href="{{route('featured.product', ['cat' =>$category->id, 'id' =>$featured->product->id] )}}">
								<div class="img">
									<img src="{{$featured->product->picture[0]->url }}" width="100%" />
								</div>
								{{ ( strlen($featured->product->name) > 20 ? substr($featured->product->name, 0, 15)."..." : $featured->product->name ) }}
							</a>
						</div>
					@endforeach
				</div>				
				<div class="col-12">
					<a class="btn btn-sm main-color-bg"href="{{route('featured.category',['cat' => $category->id ])}}">See more</a>
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
