@php 
	$settings = App\Settings::where('name', 'logo')->get();
	$logo = $settings->last();
@endphp

<div style="width: 100%; min-height: 100px; float: left;">
	<img src="{{$logo->value}}" width="180px"/>
	<h2>Dear {{$user->name}} </h2> 
	<br />
	<p>Listed below are the latest premium(s):. </p>
</div>

	@if(empty($user->premiums[0]))
		<center>No Content</center>
	@else
		@foreach ($user->premiums as $premium)
		<a class="link" href="{{route('login', ['redirect' => route('premiums.story', ['id' =>$premium->id] )] ) }}">
			<div style="width:200px; height: 230px; float: left; padding: 15px;">
				<div style="width: 200px; height: 200px; overflow: hidden;">
					<img src="{{$premium->picture[0]->url}} " width='100%' />
				</div>
				{{$premium->name}} 
			</div>
		</a>
		@endforeach
	@endif

<div style="width: 100%; height: 100px; float: left;">
	<p>Thank you</p>
</div>

