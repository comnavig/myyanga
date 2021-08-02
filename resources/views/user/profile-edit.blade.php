@extends('layouts.user')
@section('title', 'Edit Profile')
@section('page.title', 'Edit Profile')
@section('content')
<div class="container mt-2">
	<div class="col-12 p-0 mb-3 ">
		<form class="col-12" method="post" action="{{route('user.profile.update')}}"  enctype="multipart/form-data" >
			@csrf
			<div class="row">
				<div class="col-md-6 col-sm-12 mt-2 p-0">
					
					<div class="form-group">
						<label>Avatar<sup class='red'>*</sup> </label>
						<div class="row p-3">
							<div class="" style="width: 250px; min-height: 250px; overflow: hidden;">
								<label for="picture">
									<div>
										<img id="photo_img" src="{{$user->avatar}}" width="200px" />
									</div>
									<strong>Click to change avatar</strong>
								</label>
								<input type="file" name="picture" class="form-control" id="picture" accept="image/jpeg, image/png" style="display: none;" onchange="loadFile(event, 'photo_img')"  aria-describedby="picturesHelp"/>
								<small id="picturesHelp" class="form-text text-muted red">Photo size should be less than 2mb</small>
								
								@error('picture')
									<small id="picturesHelp" class="form-text text-muted red">{{ $message }}</small>
								@enderror
								
							</div>
							
						</div>
					</div>
					
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" aria-describedby="nameHelp" required />
		<!--
						<small id="nameHelp" class="form-text text-muted">We'll never share your name with anyone else.</small>
		-->
						@error('name')
							<small id="nameHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
						
					</div>
					
					<div class="form-group">
						<label for="mobile">Mobile</label>
						<input type="text" name="mobile" class="form-control" id="mobile" value="{{ $user->mobile }}" aria-describedby="mobileHelp" required />
		<!--
						<small id="mobileHelp" class="form-text text-muted">We'll never share your mobile with anyone else.</small>
		-->
						@error('mobile')
							<small id="mobileHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
						
					</div>
				</div>
				
				<div class="col-12" style="padding:1em 0 0 0; border-top: 2px solid #dddddd;">
					<button type="submit" class="btn main-btn-bg">Save</button>
				</div>
			</div>
		</form>
	</div>
	<div class="col-12 p-0 mt-4">
		<strong class="m-0 p-0 main-color">Change Password</strong>
		<form class="col-12" method="post" action="{{route('user.profile.update.password')}}"  enctype="multipart/form-data" >
			@csrf
			
			<div class="row">
				<div class="col-md-6 col-sm-12 mt-2 p-0">
					
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelp" required />
		<!--
						<small id="passwordHelp" class="form-text text-muted">We'll never share your password with anyone else.</small>
		-->
						@error('password')
							<small id="passwordHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
						
					</div>
					
				</div>
				
				<div class="col-12" style="padding:1em 0 0 0; border-top: 2px solid #dddddd;">
					<button type="submit" class="btn main-btn-bg">Save</button>
				</div>
			</div>
		</form>
		</div>
	
	
</div>
@endsection

@push('styles')
    
@endpush
@push('scripts')
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
		  CKEDITOR.replace( 'description' );
		  
	var loadFile = function(event, image_id) {
		var image = document.getElementById(image_id);
		image.src = URL.createObjectURL(event.target.files[0]);
	};
</script>
@endpush
