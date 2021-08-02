@extends('layouts.user')
@section('title', 'Activities')
@section('page.title', 'Activities')
@section('content')
<div class="container mt-2 ">
	<div class="col-12">
		<div class="row dashboard">
			<div class="col-sm-12 my-4">
				<h4 class="main-color">Your activities</h4>
				@foreach( $activities->sortByDesc('date') as $activity)
					<div class="col-12 py-2"  style="border-bottom: 2px solid #dddddd;">
						<p><i class="fas fa-flag"></i> {{$activity['activity']}} on {{$activity['date']->format('jS M Y h:iA')}}</p>
					</div>
				@endforeach
				
			</div>
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
