@extends('layouts.admin')
@section('title', 'New Ad')
@section('page.title', 'Add New Ad')
@section('content')
<div class="container mt-2">
	<div class="col-lg-5 col-sm-12 mt-2">
		<form method="post" action="{{route('admin.ad.add')}}" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" aria-describedby="nameHelp">
<!--
				<small id="nameHelp" class="form-text text-muted">We'll never share your name with anyone else.</small>
-->
				@error('name')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
				
			</div>
			
			<div class="form-group">
				<label for="url">URL</label>
				<input type="text" name="url" class="form-control" id="url" value="{{ old('url') }}" aria-describedby="urlHelp">
<!--
				<small id="urlHelp" class="form-text text-muted">We'll never share your url with anyone else.</small>
-->
				@error('url')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			
			<div class="form-group">
				<label for="youtube">Youtube Video URL</label>
				<input type="text" name="youtube" class="form-control" id="youtube" value="{{ old('youtube') }}" aria-describedby="youtubeHelp">
<!--
				<small id="youtubeHelp" class="form-text text-muted">We'll never share your youtube with anyone else.</small>
-->
				@error('youtube')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			
			<div class="form-group">
				<label for="photo_desktop">Ad Photo (Desktop)</label>
				<input type="file" name="photo_desktop" class="form-control" id="photo_desktop" value="{{ old('photo_desktop') }}" aria-describedby="photo_desktopHelp" accept="image/*" required >
				<small id="photo_desktopHelp" class="form-text text-muted">Size: 1200px × 300px</small>
				@error('photo_desktop')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			
			<div class="form-group">
				<label for="photo_mobile">Ad Photo (Mobile)</label>
				<input type="file" name="photo_mobile" class="form-control" id="photo_mobile" value="{{ old('photo_mobile') }}" aria-describedby="photo_mobileHelp" accept="image/*" required >
				<small id="photo_mobileHelp" class="form-text text-muted">Size: 300px × 300px</small>
				@error('photo_mobile')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			
			<div class="form-group">
				<label for="expired_at">Expiring Date</label>
				<input type="text" name="expired_at" class="form-control datepicker" id="expired_at" value="{{ old('expired_at') }}" aria-describedby="expired_atHelp" required />
<!--
				<small id="expired_atHelp" class="form-text text-muted">We'll never share your expired_at with anyone else.</small>
-->
				@error('expired_at')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			
			<button type="submit" class="btn main-color-bg">Add</button>
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
