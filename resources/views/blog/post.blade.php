@extends('layouts.app')
@section('title', $post->name)

@section('content')
<div class="container my-5">
    <h3 class="main-color p-4 font-weight-bolder">{{$post->name}}</h3>
    <div class="white-bg mb-5 p-4">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card img-fluid">
                    <img class="card-img-top" src="{{str_replace("https://myyanga.fra1.digitaloceanspaces.com/", "https://myyanga.com/storage/", $post->picture[0]->url) }}" alt="{{$post->name}}" style="width:100%; height:auto">
                </div>
                
                <!--@if(isset($post->picture[0]))-->
                <!--    <div class="card img-fluid">-->
                <!--        <img class="card-img-top" src="{{ str_replace("https://myyanga.fra1.digitaloceanspaces.com/", "https://myyanga.com/storage/", $post->picture[0]->url) }}" alt="{{$post->name}}" style="width:100%; height:auto">-->
                <!--    </div>-->
                <!--@endif-->

            </div>
            <div class="col-12">
                {!! $post->description !!}
            </div>
            <div class="col-12 mt-5">
                <div id="disqus_thread"></div>
                <script>
                    var disqus_config = function () {
                        this.page.url = "{{url()->current()}}"; 
                        this.page.identifier = "post{{$post->id}}"; 
                    };
                    
                    (function() {
                        var d = document, s = d.createElement('script');
                        s.src = 'https://myyanga.disqus.com/embed.js';
                        s.setAttribute('data-timestamp', +new Date());
                        (d.head || d.body).appendChild(s);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
            </div>
            <div class="col-12 mt-5">
                <h4 class="main-color font-weight-bolder">Related Posts</h4>
                <div class="row">
                    @foreach($category->posts->take(9) as $relatedPost)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <a href="{{route('blog.post', ['slug' => $relatedPost->slug])}}" class="text-decoration-none">
                                    <img class="card-img-top" src="{{str_replace("https://myyanga.fra1.digitaloceanspaces.com/", "https://myyanga.com/storage/", $relatedPost->picture[0]->url) }}" alt="{{ $relatedPost->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ ( strlen($relatedPost->name) > 20 ? substr($relatedPost->name, 0, 15) . "..." : $relatedPost->name ) }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                    
                    <!--@foreach($category->posts->take(9) as $relatedPost)-->
                    <!--    <div class="col-md-4 mb-4">-->
                    <!--        <div class="card">-->
                    <!--            <a href="{{route('blog.post', ['slug' => $relatedPost->slug])}}" class="text-decoration-none">-->
                    <!--                @if(isset($relatedPost->picture[0]))-->
                    <!--                    <img class="card-img-top" src="{{ str_replace("https://myyanga.fra1.digitaloceanspaces.com/", "https://myyanga.com/storage/", $relatedPost->picture[0]->url) }}" alt="{{ $relatedPost->name }}">-->
                    <!--                @endif-->
                    <!--                <div class="card-body">-->
                    <!--                    <h5 class="card-title">{{ ( strlen($relatedPost->name) > 20 ? substr($relatedPost->name, 0, 15) . "..." : $relatedPost->name ) }}</h5>-->
                    <!--                </div>-->
                    <!--            </a>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--@endforeach-->

                </div>
                <div class="text-center">
                    <a class="btn btn-sm main-color-bg" href="{{route('blog.category',['id' => $post->post_category_id ])}}">See more</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        .card-img-top {
            height: 300px;
            object-fit: cover;
        }
    </style>
@endpush
@push('scripts')
    <script async src="https://static.addtoany.com/menu/page.js"></script>
@endpush
