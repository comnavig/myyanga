@extends('layouts.user')
@section('title', 'Following')
@section('page.title', 'Following')
@section('content')
<div class="container mt-2 ">
	<div class="row mt-4 p-0">
		@foreach($follows->sortDesc() as $follow)
			<div class="col-md-4 col-sm-12 mt-2 float-left">
				<div style="width: 100px; height: 100px; float: left; overflow: hidden; margin: 10px 10px 10px 0px;">
					<img src="{{$follow->listing->logo ?? ''}}" width="100%" />
				</div>
				<div style="margin: 10px 10px 10px 0px;">
					<p><a class="main-color" href="{{route('pages',['slug' =>$follow->listing->slug ]) ?? ''}}"><strong>{{$follow->listing->name ?? ''}}</strong></a></p>
					<p class="main-color"><small>{{$follow->created_at->format('jS M Y h:i a') ?? ''}}</small></p>
				</div>
			</div>
			
		@endforeach
		<div class="col-12">
			{{ $follows->links() }}
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
