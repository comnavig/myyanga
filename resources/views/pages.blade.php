@extends('layouts.app')
@section('title', $page[0]['name'])

@section('content')
<div class="white-bg" style="width:100%; min-height: calc(100vh - 300px); padding: 20px;">
	<div class="container">
		{!!$page[0]['description']!!}
	</div>
</div>
	
@endsection

@push('styles')

@endpush
@push('scripts')
    
@endpush
