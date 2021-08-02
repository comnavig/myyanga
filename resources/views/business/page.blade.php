@extends('layouts.app')
@section('title', $listing['name'])

@section('content')
<div class="white-bg" style="width:100%; min-height: 300px; float: left;">
	<div class="container " style="margin-top: 7%; padding: 20px;">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-12">
				<img src="{{$listing['logo']}}" />
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12">
				<h3 class="font-weight-bolder" style="font-size: 30px;">{{$listing['name']}}</h3>
				{!!$listing['description']!!}
				<p>
					Address: {{$listing['address']}}, {{$listing['location']['name']}}, {{$listing['location']['state']['name']}}<br>
					Email: {{$listing['email'][0]['email']}}<br>
					Phone: {{$listing['phone'][0]['phone']}}<br>
					Website: {{$listing['url'][0]['url'] ?? ''}}
				</p>
				@include('components.follow-button', ['listing_id' => $listing['id'] ])
			</div>
		</div>
	
	</div>
</div>

	
<div class="white-bg" style="width:100%; min-height: 250px; float: left; padding: 20px; border-top: 1 solid #DDDDDD; ">
	<div class="container">
		<div style=" display: flex; flex-wrap: wrap;  justify-content: space-around;">
			@foreach($products as $product)
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
	</div>
</div>
	
@endsection

@push('styles')

@endpush
@push('scripts')
    
@endpush
