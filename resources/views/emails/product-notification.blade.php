@php 
	$settings = App\Settings::where('name', 'logo')->get();
	$logo = $settings->last();
@endphp

<div style="width: 100%; min-height: 100px; float: left;">
	<img src="{{$logo->value}}" width="180px"/>
	<h2>Dear {{$user->name}} </h2> 
	<br />
	<p>Listed below are the latest product(s):. </p>
</div>

	@if(empty($user->listings))
		<center>No Content</center>
	@else
		@foreach ($user->listings as $listing)
			<p><a href="{{route('pages',['slug'=> $listing['details']->slug ])}}">{{$listing['details']->name}}</a> has uploaded the following designs / services</p>
			@foreach($listing['products'] as $product)
				<li>
					<a style="color: #A51818;" href="{{route('brand.product', ['slug' =>$product->listing->slug, 'product_slug' =>$product->slug] )}}">
					{{$product->name}} 
					</a>
				</li>
			@endforeach
		@endforeach
		
	@endif

<div style="width: 100%; height: 100px; float: left;">
	<p>Thank you</p>
</div>

