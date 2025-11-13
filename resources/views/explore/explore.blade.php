@extends('layouts.app')
@section('title', 'Explore')

@section('content')

    @php
        $today = date('Y-m-d');
        $ads = App\Ads::where([['status', '=', 'APPROVED'], ['expired_at', '>', $today]])->get();

        $settings = App\Settings::where('name', 'logo')->get();
        $logo = $settings->last();
    @endphp

    <div class="position-fixed dark-grey-bg"
        style="width: 100%; min-height: 100vh; height: 100%; top: 0; overflow: scroll; z-index: 9999;">
        <div class="col-12" style="height: 10vh;">
            <a class="float-left" href="{{ url('/') }}"> <img src="{{ asset('assets/img/logo.svg') }}" width="180px" />
            </a>
            <a class="btn btn-sm gold float-right m-3" data-toggle="collapse" href="#exploreMenu" role="button"
                aria-expanded="false" aria-controls="exploreMenu">Close</a>
        </div>
        @php
            $categories = App\Category::all();
            $premium_page = App\Page::where('slug', 'premium')->get()->first();
        @endphp

        <div class="col-12" style="overflow-y: auto; margin-bottom: 5px;">
            <div class="container explore">
                <div class="row" id="eCategory">
                    @foreach ($categories->where('parent', 0) as $category)
                        <div class="col-lg-3 col-md-12 col-sm-12 gold-border p-0" style="border-bottom: 1px solid;">
                            <div class="d-flex align-items-center" style="height: 50px;">
                                <h6 class="text-uppercase py-1 p-0">
                                    <a class="gold" data-toggle="collapse" href="#ec{{ $category->id }}" role="button"
                                        aria-expanded="false" aria-controls="ec{{ $category->id }}">
                                        {{ $category->name }}
                                    </a>
                                </h6>
                            </div>
                            <div class="collapse" id="ec{{ $category->id }}" data-parent="#eCategory">
                                @foreach ($category->subcategories as $subcategory)
                                    <div class="brand d-flex align-items-center">
                                        <a class="link gold"
                                            href="{{ route('explore.category', ['id' => $subcategory->id]) }}">{{ $subcategory->name }}</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-12 p-0" style="overflow-y: auto; margin-bottom: 20px;">
            <div class="container py-2 gold">
                <div class="col-md-12 col-sm-12 p-0">
                    @if ($premium_page)
                        {!! $premium_page->description !!}
                        @auth
                            <a class="btn main-color-bg rounded-0" href="{{ route('premiums') }}">
                                View Premium
                            </a>
                        @endauth
                        @guest
                            <a class="btn main-color-bg rounded-0"
                                href="{{ route('login', ['redirect' => route('premiums')]) }}">
                                View Premium
                            </a>
                        @endguest
                    @else
                        <a class="btn main-color-bg rounded-0"
                            href="{{ route('login', ['redirect' => route('premiums')]) }}">
                            View Premium
                        </a>
                    @endif

                </div>
            </div>
        </div>

        <div class="col-12" style="margin-bottom: 20px;">
            @php
                $photo = [];
            @endphp
            <div class="container">
                <div id="" class="adts owl-carousel" data-items="1">
                    @foreach ($ads as $ad)
                        @php
                            $photo = json_decode($ad->photo, true);
                        @endphp
                        <div>
                            <a href="{{ $ad['url'] }}">
                                <img class="d-none d-sm-none d-lg-block"
                                    src="{{ str_replace('https://myyanga.fra1.digitaloceanspaces.com/', 'https://myyanga.com/storage/', $photo['desktop']) }}"
                                    alt="{{ $ad['name'] }}" />
                                <img class="d-block d-sm-block d-lg-none" src="{{ $photo['mobile'] }}"
                                    alt="{{ $ad['name'] }}" width="300px" />
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        <div class="col-12" style="margin-bottom: 10px;">
            <div class="container">
                <div class="other-section">
                    <div class="box d-flex justify-content-center">
                        <a class="gold text-center" href="{{ route('shop') }}">
                            <i class="fas fa-shopping-cart fa-2x"></i>
                            <span>Shop</span>
                        </a>
                    </div>

                    <div class="box d-flex justify-content-center">
                        <a class="gold text-center"
                            href="@guest{{ route('login', ['redirect' => route('pyls')]) }} @endguest @auth {{ route('pyls') }} @endauth">
                            <i class="fas fa-file-image fa-2x"></i>
                            <span class="text-center">Post Your Look<br />Competitions</span>
                        </a>
                    </div>

                    <div class="box d-flex justify-content-center">
                        <a class="gold text-center" href="{{ route('tvs') }}">
                            <i class="fab fa-youtube fa-2x"></i>
                            <span>My Yanga Tv</span>
                        </a>
                    </div>

                    <div class="box d-flex justify-content-center">
                        <a class="gold text-center" href="{{ route('groomtips') }}">
                            <i class="fas fa-info-circle fa-2x"></i>
                            <span>Grooming Tips</span>
                        </a>
                    </div>

                    <div class="box d-flex justify-content-center">
                        <a class="gold text-center" href="{{ route('blog') }}">
                            <i class="fab fa-blogger fa-2x"></i>
                            <span>Blog</span>
                        </a>
                    </div>

                    <div class="box d-flex justify-content-center">
                        <a class="gold text-center" href="{{ route('discovers') }}">
                            <i class="fas fa-map-marked-alt fa-2x"></i>
                            <span>Discover</span>
                        </a>
                    </div>


                </div>
            </div>
        </div>


        <footer class="col-12 d-block d-sm-block d-lg-none" style="float: left; font-size: 14px;">
            <div class="container">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <p class="white">Powered by <a class="gold btn-link" href="http://www.zonicme.com"
                                target="_blank">ZonicMe</a>
                            | <a class="gold btn-link" href="{{ route('pages', ['slug' => 'about']) }}">About us</a>
                            | <a class="gold btn-link" href="{{ route('pages', ['slug' => 'privacy_policy']) }}">Privacy
                                Policy</a>
                            | <a class="gold btn-link" href="{{ route('pages', ['slug' => 'terms']) }}">Terms</a>
                            | <a class="gold btn-link" href="{{ route('pages', ['slug' => 'contact']) }}">Contact us</a>
                        </p>
                    </div>
                    <div class="col-12 p-0 d-flex justify-content-center">
                        <a class="btn btn-md gold float-right"
                            href="https://www.facebook.com/MyYangaAfrica/?ref=pages_you_manage"><i
                                class="bi bi-facebook"></i></a>
                        <a class="btn btn-md gold float-right" href="https://www.instagram.com/myyanga_backup/"><i
                                class="bi bi-instagram"></i></a>
                        <a class="btn btn-md gold float-right"
                            href="https://www.linkedin.com/in/myyanga-africa-1083a012b/"><i
                                class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </footer>


    </div>



@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    <style>
        .brand {
            color: #000000;
            height: 16px;
            letter-spacing: .2px;
            line-height: 16px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .brand .link {
            color: #000000;
            font-size: 11px;
            letter-spacing: .2px;
            line-height: 20px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .link {
            color: #000000;
            font-size: 14px;
            letter-spacing: .2px;
            line-height: 20px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .link:hover,
        .brand .link:hover {
            color: #85000b;
        }

        .gp-tabs {
            margin-bottom: 10px !important;
            border: 0px;
        }

        .gp-tabs .active {
            color: #E1232B !important;
            border-radius: 0px;
            border: 0px;
            border-right: 2px solid #000000 !important;
        }

        .gp-tabs .nav-item .nav-link {
            font-size: 18px;
            font-weight: bold;
            color: #000000;
            padding: 0rem 1rem !important;
        }

        .gp-tabs .nav-item .nav-link {
            border-radius: 0px;
            border: 0px;
            border-right: 2px solid #000000;
        }

        .no-border {
            border-radius: 0px;
            border: 0px !important;
        }

        .gp-tabs .nav-link:hover {
            color: #E1232B
        }

        .tab-pane {
            padding: 6px 0px;
            border-top: 2px solid #000000;
            border-bottom: 2px solid #000000;
        }

        .fade:not(.show) {
            display: none;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                items: 4,
                loop: true,
                margin: 10,
                autoplay: true,
            });

        });

        new Splide('.splide', {
            autoplay: true,
            type: 'loop',
            arrows: false,
            pagination: false,
        }).mount();

        function hideAndShow(hide, show) {
            var h = document.getElementById(hide);
            h.style.display = "none";

            var s = document.getElementById(show);
            s.style.display = "block";

        }
    </script>
@endpush
