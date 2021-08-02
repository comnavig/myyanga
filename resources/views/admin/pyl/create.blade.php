@extends('layouts.admin')
@section('title', 'Create Post Your Look')
@section('page.title', 'Create Post Your Look')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Form
			<a class="btn btn-sm main-btn-bg float-right" href="{{route('admin.pyls')}}">back to Post Your Look</a>
		</h3>
	</div>
	<div class="col-12">
		<form method="post" action="{{route('admin.pyl.add')}}"  enctype="multipart/form-data" >
			@csrf
			<div class="row">
				<div class="col-md-12 col-sm-12 mt-2">
					
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" aria-describedby="nameHelp" required />
		<!--
						<small id="nameHelp" class="form-text text-muted">We'll never share your name with anyone else.</small>
		-->
						@error('name')
							<small id="nameHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
						
					</div>
				</div>
				
				<div class="col-md-12 col-sm-12 mt-2">
					<div class="form-group">
						<label for="description">Content</label>
						<textarea name="description" class="form-control" id="description" aria-describedby="descriptionHelp" rows="12" required >{{ old('description') }}</textarea>
						<small id="descriptionHelp" class="form-text text-muted">Please write post content.</small>
						@error('description')
							<small id="descriptionHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
					</div>
				
				</div>
				
				<div class="col-md-12 col-sm-12 mt-2">
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
				</div>			
			
				<div class="col-12 pt-2" style="border-top: 2px solid #dddddd;">
					<button type="submit" class="btn main-btn-bg">Save</button>
				</div>
			</div>
		</form>
		</div>
	
	
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{url('assets/css/bootstrap-datepicker3.css')}}"/>
@endpush
@push('scripts')
	<script src="{{url('assets/js/bootstrap-datepicker.js')}}" ></script>
    <script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>
    <script>
		  CKEDITOR.replace( 'description' );
		  
	var loadFile = function(event, image_id) {
		var image = document.getElementById(image_id);
		image.src = URL.createObjectURL(event.target.files[0]);
	};
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',
	});
</script>
@endpush
