@extends('layouts.app')
@section('title', 'My Yanga TV')

@section('content')


<div class="col-12 float-left p-3">
	<h3 class="main-color">My Yanga TV</h3>
</div>

<div class="col-12 float-left">
	
	@foreach($categories as $category)
		<div class="col-12 float-left p-0 main-color-bg">
			<h4 class="p-2">{{$category->name}} <a class="btn btn-sm gold float-right" href="{{route('tvs.category',['id' =>$category->id])}}">See more</a></h4>
		</div>
		<div class="col-12 float-left m-0" style="min-height: 300px; padding:0.6em 0px 0px 0px ; display: flex; flex-wrap: wrap;  justify-content: space-around;">
		@foreach($category->tvs->sortDesc()->take(8) as $tv)
			<div class="product-item">
				<a class="link" href="{{route('tvs.show', ['id' =>$tv->id])}}">
					<div class="img" style="background-image:url('{{$tv->photo }}'); background-size: cover; background-position: center;">
<!--
						<img src="" width="100%" />
-->
					</div>
					{{ ( strlen($tv->name) > 15 ? substr($tv->name, 0, 15)."..." : $tv->name ) }}
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
