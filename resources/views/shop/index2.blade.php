@extends('layouts.app-others')
@section('title', 'Shop')

@section('content')

<section class="container py-5">
    <h4 class="page-title py-3">Shop</h4>
    <div class="products d-flex flex-wrap justify-content-evenly" id="product-Layout" data-aos="fade-up" data-aos-duration="3000">
       @foreach($products as $product)
       <div class="card product-card shadow-sm mb-4">
            <a href="{{ route('shop.product', ['id' => $product->id]) }}" class="text-decoration-none text-dark">
                @if(isset($product->picture[0]))
                    <img src="{{ $product->picture[0]->url }}" class="card-img-top" alt="{{ $product->name }}">
                @else
                    <img src="/path/to/default/image.jpg" class="card-img-top" alt="{{ $product->name }}">
                @endif
                <div class="card-body">
                    <h6 class="product-title">{{ strlen($product->name) > 20 ? substr($product->name, 0, 15) . '...' : $product->name }}</h6>
                    <p class="product-price">₦{{ number_format($product->price) }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</section>

@endsection

@push('styles')
    <style>
        .product-card {
            width: 18rem;
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-card img {
            height: 200px;
            object-fit: cover;
        }

        .product-title {
            font-size: 1rem;
            font-weight: 600;
        }

        .product-price {
            font-size: 1.2rem;
            color: #850713;
        }
        
        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #850713;
            border-color: #850713;
        }
        .page-link {
            color: #850713;
        }
    </style>
@endpush
