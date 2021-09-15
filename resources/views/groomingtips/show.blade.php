@extends('layouts.app')
@section('title', $groomtip->name)

@section('content')
<div class="col-lg-7 col-md-12 col-sm-12" style="margin-top: 3%;">
	
</div>
<div class="white-bg" style="width:100%; min-height: 300px; float: left; margin-bottom: 79px;">
	<div style="margin-top: 2%;">
		<div class="row m-0 p-0">
			<div class="col-lg-7 col-md-12 col-sm-12">
				<div class="product-image">
					<img src="{{$groomtip->picture[1]->url}}" />
				</div>
				<div class="col-12 my-4 p-2" style="border-top: 1px solid #ddd; border-bottom: 1px solid #ddd;">
					<h3 class="gold font-weight-bolder">{{$groomtip->name}}</h3>
				</div>
				{!!$groomtip->description!!}
				<div class="col-12 m-0 p-0" style="border-top: 1px solid #ddd; border-bottom: 1px solid #ddd;">
					<p class="gold"><strong>Share the Fun!</strong><br/><br/>Sharing is caring, and sharing is easy! We made it easy!</p>
						<!-- AddToAny BEGIN -->
						<div>
							<div class="col-12 m-0 p-0 my-2">
								<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
									<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
									<a class="a2a_button_facebook"></a>
									<a class="a2a_button_twitter"></a>
									<a class="a2a_button_whatsapp"></a>
									<a class="a2a_button_linkedin"></a>
									<a class="a2a_button_telegram"></a>
									
								</div>
							</div>
						</div>
						
						<!-- AddToAny END -->
				</div>
			</div>
			<div class="col-lg-5 col-md-12 col-sm-12 p-2">
				
				<div class="col-12" style=" display: flex; flex-wrap: wrap; justify-content: space-around;">
					@foreach($groomtips->take(9) as $groomtip)
						<div class="product-item">
							<a class="link" href="{{route('groomtips.tip', ['slug' =>$groomtip->slug])}}">
								<div class="img" >
									<img src="{{$groomtip->picture[0]->url }}" width="100%" />
								</div>
								{{ ( strlen($groomtip->name) > 20 ? substr($groomtip->name, 0, 15)."..." : $groomtip->name ) }}
							</a>
						</div>
					@endforeach
				</div>
				<div class="col-12">
					<a class="btn btn-sm main-color-bg"href="{{route('groomtips.category',['id' => $groomtip->category_id ])}}">See more</a>
				</div>
			</div>
		</div>
	
	</div>
</div>
	
@endsection

@push('styles')
	<style>
		#showbox {width: 100%; height: 60vh; }
	</style>
@endpush
@push('scripts')
    <script async src="https://static.addtoany.com/menu/page.js"></script>
@endpush
