@extends('layouts.app')
@section('title', $page[0]['name'])

@section('content')
<div class="white-bg" style="width:100%; min-height: 250px; float: left; padding: 20px;">
	<div class="container">
		{!!$page[0]['description']!!}
	</div>
</div>
	
@endsection

@push('styles')

@endpush
@push('scripts')
    
@endpush
