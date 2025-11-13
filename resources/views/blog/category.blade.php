 @extends('layouts.app-others')
@section('title', 'Blog '. $category->name)

@section('content')

<section class="container my-5 py-5">
    <h4 class="page-title py-3">{{$category->name}}</h4>
    <div class="row blog" id="blog-Layout">
        @foreach($posts as $post)
           <div class="col-md-4 my-5 blog-card">
                <a href="{{route('blog.post', ['slug' =>$post->slug])}}" class="text-decoration-none text-dark" onClick="setPost(${e.id})">
                <div class="blog-img-wrapper">
                    <img src="{{ str_replace("https://myyanga.fra1.digitaloceanspaces.com/", "https://myyanga.com/storage/", $post->picture[0]->url) }}" width="100%">
                </div>
                <div class="my-3">
                    <h5 class="blog-title">{{ ( strlen($post->name) > 20 ? substr($post->name, 0, 15)."..." : $post->name ) }}</h5>
                    <p class="my-4">{!! ( strlen($post->description) > 50 ? strip_tags(substr($post->description, 0, 100))."..." : strip_tags($post->description )) !!}</p>
                    <a href="{{route('blog.post', ['slug' =>$post->slug])}}" class="readmore-btn d-flex text-decoration-none" onClick="setPost(${e.id})">
                        <h6>Read More <i class="fa-solid fa-angles-right"></i> </h6>
                    </a>
                </div>
            </div> 
        @endforeach
            
            <div class="col-12 float-left" style="margin-bottom: 26%;">
	            {{ $posts->links() }}
            </div>

       
    </div>
    <!-- <div style="text-align: center;" class="my-5">
        <button class="btn custom-btn" type="submit">Show More</button>
    </div> -->
</section>

@endsection

@push('styles')
    
@endpush
@push('scripts')
 
 @endpush
