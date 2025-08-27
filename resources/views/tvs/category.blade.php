@extends('layouts.app')
@section('title', 'Tv '. $category->name)

@section('content')


<div class="col-12 float-left p-3">
	<h3 class="main-color">{{$category->name}}</h3>
</div>

<div class="col-12 float-left" style="display: flex; flex-wrap: wrap;  justify-content: space-around;">
	
	@foreach($tvs as $tv)
		<div class="product-item">
			<a class="link" href="{{route('tvs.show', ['id' =>$tv->id])}}">
				<div class="img"  style="background-image:url('{{$tv->photo }}'); background-size: cover; background-position: center;">
<!--
					<img src="{{$tv->photo }}" width="100%" />
-->
				</div>
				{{ ( strlen($tv->name) > 15 ? substr($tv->name, 0, 15)."..." : $tv->name ) }}
			</a>
		</div>
	@endforeach
</div>
<div class="col-12 float-left" style="margin-bottom: 26%;">
	{{ $tvs->links() }}
</div>
@endsection

@push('styles')
    
@endpush
@push('scripts')
 
 @endpush
