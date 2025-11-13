@extends('layouts.app-others')
@section('title', 'Shop')

@section('content')

<section class="container py-5">
    <h4 class="page-title py-3">Shop</h4>
    <div class="products d-flex flex-wrap justify-content-evenly" id="product-Layout" data-aos="fade-up" data-aos-duration="3000">
       @foreach($products->sortByDesc('updated_at') as $product)
       <div class="products-card p-3">
            <a href="{{route('shop.product', ['id' =>$product->id] )}}" class="text-decoration-none text-dark" onClick="product(${e.id})">
            <!--<img src="{{$product->picture[0]->url }}">-->
            <img 
                                src="{{ str_replace('https://myyanga.fra1.digitaloceanspaces.com/', 'https://myyanga.com/storage/', $product->picture[0]['url']) }}" 
                                width="100%" 
                                alt="Product Image"
                            />
            <div class="py-3">
                <h6 class="product-title">{{ ( strlen($product->name) > 20 ? substr($product->name, 0, 15)."..." : $product->name ) }}</h6>
                <p class="product-price">₦{{number_format($product->price) }}</p>
            </div>
            </a>
        </div>
        @endforeach
    </div>
</section>

@endsection
