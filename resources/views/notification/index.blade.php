@extends('layouts.user')
@section('title', 'Notification List')
@section('page.title', 'Notification List')
@section('content')
<div class="container mt-2 ">
	<div class="row mt-4 p-0">
		
		<table class="table">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Message</th>
                    <th>Created On</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($notifications as $notification)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>
                            <a href="./notification/{{ $notification->id }}">
                              Click Here to view the notification for this day  
                            </a>
                        </td>
                        <td>{{ $notification->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
		
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
