@extends('layouts.app-others')
@section('title', 'Shop')

@section('content')

<section class="container my-1 py-1 d-flex flex-wrap">
  <!-- Blog List Column -->
  <div class="col-md-8 py-3 blog-list">
    <h4 class="page-title">Blog</h4>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
      @foreach($posts->where('status', 'APPROVED') as $post)
        <div class="col">
          <div class="card h-100">
            <a href="{{route('blog.post', ['slug' => $post->slug])}}" class="text-decoration-none text-dark">
              <div class="blog-img-wrapper">
                <img src="{{$post->picture[0]->url}}" class="card-img-top" alt="{{ $post->name }}">
              </div>
              <div class="card-body">
                <h5 class="card-title">{{ (strlen($post->name) > 20 ? substr($post->name, 0, 25) . "..." : $post->name) }}</h5>
                <p class="card-text">{!! (strlen($post->description) > 50 ? strip_tags(substr($post->description, 0, 50)) . "..." : strip_tags($post->description)) !!}</p>
              </div>
              <div class="card-footer bg-transparent border-0">
                <a href="{{route('blog.post', ['slug' => $post->slug])}}" class="btn btn-outline-primary d-flex align-items-center">
                  Read More <i class="fa-solid fa-angles-right ms-2"></i>
                </a>
              </div>
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <!-- Categories Column -->
  <div class="col-md-4 py-3 categories">
    <h4>Categories</h4>
    <ul class="list-group list-group-flush">
      @foreach($categories as $category)
        <li class="list-group-item">
          <a href="{{route('blog.category', ['id' => $category->id])}}" class="text-decoration-none">{{ $category->name }}</a>
        </li>
      @endforeach
    </ul>
  </div>
</section>

@endsection

<!-- Custom CSS -->
<style>
  .blog-img-wrapper img {
    object-fit: cover;
    height: 300px;
  }

  .card-title {
    font-size: 1.1rem;
    font-weight: bold;
  }

  .card-text {
    font-size: 0.9rem;
    color: #555;
  }

  .btn-outline-primary {
    font-size: 0.9rem;
  }
</style>
