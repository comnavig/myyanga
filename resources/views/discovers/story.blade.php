@extends('layouts.app')
@section('title', $discover->name)

@section('content')
<div class="container my-5">
    <h3 class="main-color font-weight-bolder">{{ $discover->name }}</h3>
    <div class="white-bg p-4 mb-5 rounded">
        <div class="row">
            <div class="col-lg-7 col-md-12 mb-4">
                <div class="card">
                    <img class="card-img-top" src="{{ $discover->picture[1]->url }}" alt="{{ $discover->name }}">
                    <div class="card-body">
                        @include('components.product-description', ['description' => $discover->description ])
                        @include('components.tag', ['tag' => $discover->tag ])
                        @guest
                            <a class="btn btn-link main-color my-2 p-0" style="font-size: 17px;" href="{{ route('login', ['redirect' => url()->full() ]) }}"> Login to Share</a>
                        @endguest
                        @auth
                            <p class="gold"><strong>Share the Fun!</strong><br/><br/>Sharing is caring, and sharing is easy! We made it easy!</p>
                        @endauth
                        @include('components.share-button')
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12">
                <h4>Related Discoveries</h4>
                <div id="relatedDiscovers" class="accordion">
                    @foreach($discovers->take(9) as $key => $relatedDiscover)
                        <div class="card">
                            <div class="card-header" id="heading{{ $key }}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{ $key }}" aria-expanded="false" aria-controls="collapse{{ $key }}">
                                        {{ (strlen($relatedDiscover->name) > 20 ? substr($relatedDiscover->name, 0, 15) . "..." : $relatedDiscover->name) }}
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse{{ $key }}" class="collapse" aria-labelledby="heading{{ $key }}" data-parent="#relatedDiscovers">
                                <div class="card-body">
                                    <a class="link" href="{{ route('discovers.story', ['slug' => $relatedDiscover->slug]) }}">
                                        <div class="img mb-2">
                                            @if(isset($relatedDiscover->picture[0]))
                                                <img src="{{ $relatedDiscover->picture[0]->url }}" class="img-fluid rounded" alt="{{ $relatedDiscover->name }}">
                                            @else
                                                <img src="/path/to/default/image.jpg" class="img-fluid rounded" alt="Default Image">
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-3">
                    <a class="btn btn-sm main-color-bg" href="{{ route('discovers.category', ['id' => $discover->discover_category_id ]) }}">See more</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        .main-color {
            color: #007bff;
        }
        .main-color-bg {
            background-color: #007bff;
            color: #fff;
        }
        .main-color-bg:hover {
            background-color: #0056b3;
            color: #fff;
        }
        .gold {
            color: #ffc107;
        }
        .card-img-top {
            object-fit: cover;
            height: 500px;
        }
        .accordion .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .accordion .card-body {
            padding: 1rem;
        }
    </style>
@endpush
@push('scripts')
    <script async src="https://static.addtoany.com/menu/page.js"></script>
@endpush
