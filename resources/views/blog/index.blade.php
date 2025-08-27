@extends('layouts.app')
@section('title', 'Blog')

@section('content')


<div class="col-12 float-left p-3">
	<h3 class="main-color">Blog</h3>
</div>

<div class="col-12 float-left">
	
	@foreach($categories as $category)
		<div class="col-12 float-left p-0 main-color-bg">
			<h4 class="p-2">{{$category->name}} <a class="btn btn-sm gold float-right" href="{{route('blog.category',['id' =>$category->id])}}">See more</a></h4>
		</div>
		<div class="col-12 float-left p-4" style="min-height: 300px; display: flex; flex-wrap: wrap; justify-content: space-around;">
			@foreach($category->posts->where('status', 'APPROVED')->take(12) as $post)
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
	@endforeach
</div>

@endsection

@push('styles')
    
@endpush
@push('scripts')
 
 @endpush
