@extends('layouts.app')
@section('title', 'Grooming Tips')

@section('content')


<div class="col-12 float-left p-3">
	<h3 class="main-color">Grooming Tips</h3>
</div>

<div class="col-12 float-left">
	
	@foreach($categories as $category)
		<div class="col-12 float-left p-0 main-color-bg">
			<h4 class="p-2">{{$category->name}} <a class="btn btn-sm gold float-right" href="{{route('groomtips.category',['id' =>$category->id])}}">See more</a></h4>
		</div>
		<div class="col-12 float-left p-4" style="min-height: 300px; display: flex; flex-wrap: wrap; justify-content: space-around;">
		@foreach($category->groomtips->sortDesc()->take(8) as $groomtip)
			<div class="product-item">
				<a class="link" href="{{route('groomtips.tip', ['slug' =>$groomtip->slug])}}">
					<div class="img" >
						@if($groomtip->picture && count($groomtip->picture) > 0)
							<img src="{{$groomtip->picture[0]->url }}" width="100%" />
						@else
							<img src="{{ asset('assets/img/default-grooming.jpg') }}" width="100%" alt="Default grooming tip image" />
						@endif
					</div>
					{{ ( strlen($groomtip->name) > 20 ? substr($groomtip->name, 0, 15)."..." : $groomtip->name ) }}
				</a>
			</div>
		@endforeach
		</div>
	@endforeach
</div>
@endsection

@push('styles')
    
@endpush
@push('scripts')
 
 @endpush
