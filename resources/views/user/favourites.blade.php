@extends('layouts.user')
@section('title', 'Favourites')
@section('page.title', 'Favourites')
@section('content')
<div class="container mt-2 ">
	<div class="row mt-4 p-0">
		@foreach($favourites->sortDesc() as $favourite)
			<div class="col-md-4 col-sm-12 mt-2 float-left">
				<div style="width: 100px; height: 100px; float: left; overflow: hidden; margin: 10px 10px 10px 0px;">
					<img src="{{$favourite->product->picture[0]->url ?? ''}}" width="100%" />
				</div>
				<div style="margin: 10px 10px 10px 0px;">
					<p><a class="main-color" href="{{route('brand.product',['slug' =>$favourite->product->listing->slug, 'product_slug' => $favourite->product->slug ]) ?? ''}}"><strong>{{$favourite->product->name ?? ''}}</strong></a></p>
					<p class="main-color">{{$favourite->product->listing->name ?? ''}}<br/><small>{{$favourite->created_at->format('dS M Y h:i a') ?? ''}}</small></p>
				</div>
			</div>
			
		@endforeach
		<div class="col-12">
			{{ $favourites->links() }}
		</div>
		
	</div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
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
