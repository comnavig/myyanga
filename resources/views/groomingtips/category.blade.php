@extends('layouts.app')
@section('title', 'Grooming Tips '. $category->name)

@section('content')


<div class="col-12 float-left p-3">
	<h3 class="main-color">{{$category->name}}</h3>
</div>

<div class="col-12 float-left" style=" display: flex; flex-wrap: wrap; justify-content: space-around;">
	
	@foreach($groomingtips as $groomtip)
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
<div class="col-12 float-left" style="margin-bottom: 26%;">
	{{ $groomingtips->links() }}
</div>
@endsection

@push('styles')
    
@endpush
@push('scripts')
 
 @endpush
