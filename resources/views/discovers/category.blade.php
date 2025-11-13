@extends('layouts.app')
@section('title', 'Discover '. $category->name)

@section('content')


<div class="col-12 float-left p-3">
	<h3 class="main-color">{{$category->name}}</h3>
</div>

<div class="col-12 float-left" style=" display: flex; flex-wrap: wrap; justify-content: space-around;">
	
	@foreach($discovers as $discover)
	
		<div class="product-item">
			<a class="link" href="{{route('discovers.story', ['slug' =>$discover->slug])}}">
				<div class="img" >
				    @if(isset($discover->picture[0]))
					    <img src="{{$discover->picture[0]->url }}" width="100%" />
					@else
					    <div>No image uploaded</div>
					@endif
				</div>
				{{ ( strlen($discover->name) > 20 ? substr($discover->name, 0, 15)."..." : $discover->name ) }}
			</a>
		</div>
	@endforeach
</div>
<div class="col-12 float-left" style="margin-bottom: 26%;">
	{{ $discovers->links() }}
</div>
@endsection

@push('styles')
    
@endpush
@push('scripts')
 
 @endpush
