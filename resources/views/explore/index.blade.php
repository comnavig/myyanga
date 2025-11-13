<div class="collapse" id="exploreMenu">
    <div class="position-fixed dark-grey-bg"
        style="width: 100%; height: 100vh; top: 0; overflow-y: auto; z-index: 99999999999;">
        <div class="container-fluid">
            <div class="row align-items-center py-3">
                <div class="col-6">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/img/logo.svg') }}" width="180px" alt="Logo" />
                    </a>
                </div>
                <div class="col-6 text-right">
                    <a class="btn btn-sm gold" data-toggle="collapse" href="#exploreMenu" role="button"
                        aria-expanded="false" aria-controls="exploreMenu">Close</a>
                </div>
            </div>

            @php
                $categories = App\Category::all();
                $premium_page = App\Page::where('slug', 'premium')->first();
            @endphp

            <div class="row">
                <div class="col-12">
                    <div class="container explore">
                        <div class="row" id="eCategory">
                            @foreach ($categories->where('parent', 0) as $category)
                                <div class="col-lg-3 col-md-4 col-sm-6 gold-border p-0 mb-3">
                                    <div class="d-flex align-items-end" style="height: 50px; padding-bottom: 10px;">
                                        <h6 class="text-uppercase py-0 m-0">
                                            <a class="gold" data-toggle="collapse" href="#ec{{ $category->id }}"
                                                role="button" aria-expanded="false"
                                                aria-controls="ec{{ $category->id }}">
                                                {{ $category->name }}
                                            </a>
                                        </h6>
                                    </div>
                                    <div class="collapse" id="ec{{ $category->id }}" data-parent="#eCategory">
                                        @foreach ($category->subcategories as $subcategory)
                                            <div class="brand d-flex align-items-center py-1">
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
            </div>

            <div class="row my-4">
                <div class="col-12">
                    <div class="container py-2 gold">
                        <div class="col-12 p-0">
                            @if ($premium_page)
                                {!! $premium_page->description !!}
                                @auth
                                    <a class="btn btn-sm main-color-bg rounded-0" href="{{ route('premiums') }}">View
                                        Premium</a>
                                @endauth
                                @guest
                                    <a class="btn btn-sm main-color-bg rounded-0"
                                        href="{{ route('login', ['redirect' => route('premiums')]) }}">View Premium</a>
                                @endguest
                            @else
                                <a class="btn btn-sm main-color-bg rounded-0"
                                    href="{{ route('login', ['redirect' => route('premiums')]) }}">View Premium</a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-4">
                <div class="col-12">
                    <div class="container">
                        <div id="adCarousel" class="owl-carousel owl-theme">
                            @foreach ($ads as $ad)
                                @php
                                    $photo = json_decode($ad->photo, true);
                                @endphp
                                <div class="item">
                                    <a href="{{ $ad['url'] }}">
                                        <img class="d-none d-lg-block img-fluid"
                                            src="{{ str_replace('https://myyanga.fra1.digitaloceanspaces.com/', 'https://myyanga.com/storage/', $photo['desktop']) }}"
                                            alt="{{ $ad['name'] }}" />
                                        <img class="d-block d-lg-none img-fluid"
                                            src="{{ str_replace('https://myyanga.fra1.digitaloceanspaces.com/', 'https://myyanga.com/storage/', $photo['mobile']) }}"
                                            alt="{{ $ad['name'] }}" />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-4">
                <div class="col-12">
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
            </div>

            <footer class="col-12 d-block d-sm-block d-lg-none text-center py-4" style="font-size: 14px;">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <p class="white">
                                Powered by <a class="gold btn-link" href="http://www.zonicme.com"
                                    target="_blank">ZonicMe</a>
                                | <a class="gold btn-link" href="{{ route('pages', ['slug' => 'about']) }}">About
                                    us</a>
                                | <a class="gold btn-link"
                                    href="{{ route('pages', ['slug' => 'privacy_policy']) }}">Privacy Policy</a>
                                | <a class="gold btn-link" href="{{ route('pages', ['slug' => 'terms']) }}">Terms</a>
                                | <a class="gold btn-link" href="{{ route('pages', ['slug' => 'contact']) }}">Contact
                                    us</a>
                            </p>
                        </div>
                        <div class="col-12">
                            <a class="btn btn-md gold"
                                href="https://www.facebook.com/MyYangaAfrica/?ref=pages_you_manage"><i
                                    class="bi bi-facebook"></i></a>
                            <a class="btn btn-md gold" href="https://www.instagram.com/officialmyyanga_/"><i
                                    class="bi bi-instagram"></i></a>
                            <a class="btn btn-md gold" href="https://www.linkedin.com/in/myyanga-africa-1083a012b/"><i
                                    class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .dark-grey-bg {
        background-color: #343a40;
        color: #fff;
    }

    .gold-border {
        border-bottom: 1px solid #ffc107;
    }

    .gold {
        color: #ffc107;
    }

    .main-color-bg {
        background-color: #007bff;
        color: #fff;
    }

    .main-color-bg:hover {
        background-color: #0056b3;
        color: #fff;
    }

    .container.explore .row {
        margin: 0;
        padding: 0;
    }

    .container.explore .row .col-lg-3 {
        padding: 15px;
    }

    .brand a {
        color: #ffc107;
        font-size: 0.9rem;
    }

    .brand a:hover {
        text-decoration: underline;
    }

    .other-section .box a {
        display: block;
        color: #ffc107;
        font-size: 1rem;
    }

    .other-section .box a:hover {
        text-decoration: none;
        color: #fff;
    }

    .owl-carousel .item {
        padding: 15px;
    }

    .owl-carousel .item img {
        width: 100%;
        height: auto;
    }

    footer p {
        margin: 0;
    }
</style>
