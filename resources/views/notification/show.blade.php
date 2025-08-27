@extends('layouts.user')
@section('title', 'Notification List')
@section('page.title', 'Notification List')
@section('content')

    <div class="container">
        <div class="notification-details">
            <h2 class="text-center">Premium Reel for {{ $notification->user->name }}</h2>
            <div class="reel-container">
                @foreach($premiumMedia as $media)
                <div class="reel-item">
                    @if($media['label'] == 'video')
                        <div class="media-content">
                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/{{ $media['value'] }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>

                    @else
                    <div class="media-content">
                        <a href="/premiums/{{ $media['id'] }}">
                            <img src="{{ $media['value'] }}" alt="Document" class="img-fluid" style="border-radius: 10px; max-width: 100%;">
                        </a>
                        <!-- Display Premium Name below the image -->
                        <p class="premium-name">{{ $media['name'] }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
@endpush
<!-- Styles for the Reel Layout -->
@push('styles')
<style>
    .notification-details {
        margin: 20px 0;
    }

    .reel-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        justify-content: center;
        align-items: center;
    }

    .reel-item {
        width: 100%;
        max-width: 500px;
        background-color: #fff;
        padding: 15px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        text-align: center;
    }

    .media-content {
        margin-bottom: 15px;
    }

    .premium-name {
        color: #000;
        font-size: 16px;
        font-weight: bold;
        margin-top: 10px;
    }

    /* For smaller screens */
    @media (max-width: 600px) {
        .reel-container {
            flex-direction: column;
        }

        .reel-item {
            width: 100%;
        }
    }
</style>
@endpush
@push('scripts')
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
    <script>
		$(document).ready( function () {
			$('.dt').DataTable();
			
			new Splide( '.splide', {
				autoplay : true,
				type : 'loop',
				arrows : false,
				pagination : false,
			}).mount();
			
		} );
    </script>
@endpush
