@extends('layouts.admin')
@section('title', $page_title)
@section('page.title', $page_title)
@section('content')
<div class="container mt-2">
	<div class="col-lg-5 col-sm-12 mt-2">
		<form method="post" action="{{$update_url}}">
			@csrf
			<input type="hidden" name="id" value="{{$data->id}}" />
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" class="form-control" id="name" value="{{ $data->name }}" aria-describedby="nameHelp">
<!--
				<small id="nameHelp" class="form-text text-muted">We'll never share your name with anyone else.</small>
-->
				@error('name')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
				
			</div>
			
			<button type="submit" class="btn main-color-bg">Save</button>
		</form>
	</div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{url('assets/css/bootstrap-datepicker3.css')}}"/>
@endpush
@push('scripts')
    <script src="{{url('assets/js/bootstrap-datepicker.js')}}" ></script>
    <script>
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',
		});
    </script>
@endpush
