@extends('layouts.app')
@section('title', 'Blog '. $category->name)

@section('content')


<div class="col-12 float-left p-3">
	<h3 class="main-color">{{$category->name}}</h3>
</div>

<div class="col-12 float-left">
	
	@foreach($posts as $post)
		<div class="product-item">
			<a class="link" href="{{route('blog.post', ['slug' =>$post->slug])}}">
				<div class="img" >
					<img src="{{$post->picture[0]->url }}" width="100%" />
				</div>
				{{ ( strlen($post->name) > 20 ? substr($post->name, 0, 15)."..." : $post->name ) }}
			</a>
		</div>
	@endforeach
</div>
<div class="col-12 float-left" style="margin-bottom: 26%;">
	{{ $posts->links() }}
</div>
@endsection

@push('styles')
    
@endpush
@push('scripts')
 
 @endpush
