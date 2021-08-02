@extends('layouts.app')
@section('title', 'Discover '. $category->name)

@section('content')


<div class="col-12 float-left p-3">
	<h3 class="main-color">{{$category->name}}</h3>
</div>

<div class="col-12 float-left">
	
	@foreach($premiums as $premium)
		<div class="product-item">
			<a class="link" href="{{route('premiums.story', ['id' =>$premium->id])}}">
				<div class="img" >
					<img src="{{$premium->picture[0]->url }}" width="100%" />
				</div>
				{{ ( strlen($premium->name) > 20 ? substr($premium->name, 0, 15)."..." : $premium->name ) }}
			</a>
		</div>
	@endforeach
</div>
<div class="col-12 float-left" style="margin-bottom: 26%;">
	{{ $premiums->links() }}
</div>
@endsection

@push('styles')
    
@endpush
@push('scripts')
 
 @endpush
