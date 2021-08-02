@extends('layouts.business')
@section('title', 'Create Brand LIsting')
@section('page.title', 'Create Brand LIsting')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Form
			<a class="btn btn-sm main-btn-bg float-right" href="{{route('listings')}}">back to listings</a>
		</h3>
	</div>
	<div class="col-12 m-0 p-0">
		<form method="post" action="{{route('listings.add')}}"  enctype="multipart/form-data" >
			@csrf
			<div class="row">
				<div class="col-lg-7 col-md-7 col-sm-12 mt-2">
					<div class="form-group">
						<label for="logo">
							Logo<br/>
							<div style="width: 250px; height: 250px; overflow: hidden;">
								<img id="logo" src="https://via.placeholder.com/250?text=Click+Upload+Logo" width="100%" />
							</div>
						</label>
						<input type="file" name="logo" class="form-control" id="logo" accept="image/jpeg, image/png" onchange="loadFile(event, 'logo')" aria-describedby="logoHelp" required />
		<!--
						<small id="logoHelp" class="form-text text-muted">We'll never share your logo with anyone else.</small>
		-->
						@error('logo')
							<small id="logoHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
						
					</div>
					
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
					
					<div class="form-group">
						<label for="slug">Slug</label>
						<input type="text" name="slug" class="form-control" id="slug" value="{{ old('slug') }}" aria-describedby="slugHelp" required />
						<small id="slugHelp" class="form-text text-muted">Please a unique userslug for your brand.</small>
						@error('slug')
							<small id="slugHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
						
					</div>
					
					<div class="form-group">
						<label for="description">Description</label>
						<textarea name="description" class="form-control" id="description" aria-describedby="descriptionHelp" required >{{ old('description') }}</textarea>
						<small id="descriptionHelp" class="form-text text-muted">Please write about your business.</small>
						@error('description')
							<small id="descriptionHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
					</div>
					
					<div class="form-group">
						<label for="address">Address</label>
						<textarea name="address" class="form-control" id="address" aria-describedby="addressHelp" required >{{ old('address') }}</textarea>
						<small id="addressHelp" class="form-text text-muted">Please type in your business address</small>
						@error('address')
							<small id="addressHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
					</div>
					
					<div class="form-group">
						<label for="location">City</label>
						<select class="form-control" id="location" name="location" aria-describedby="locationHelp">
							<option value="">Please Select City</option>
							@foreach($locations->where('parent_id',0) as $location)
							<optgroup label="{{$location->name}}">
								@foreach($locations->where('parent_id', $location->id) as $area)
									<option value="{{$area->id}}" {{ (old('location') == $area->id ? "selected" : "" )}}>{{$area->name}}</option>
								@endforeach
							</optgroup>
							@endforeach	
						</select>
						<small id="locationHelp" class="form-text text-muted"></small>
						@error('location')
							<small id="locationHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
					</div>
					
					<div class="form-group">
						<label for="cac">CAC Registered?</label>
						<select class="form-control" id="cac" name="cac" aria-describedby="cacHelp">
							<option value="">Are you registered with CAC</option>
							<option value="Yes" {{ (old('cac') == "Yes" ? "selected" : "" )}}>Yes</option>
							<option value="No" {{ (old('cac') == "No" ? "selected" : "" )}}>No</option>
						</select>
						<small id="cacHelp" class="form-text text-muted"></small>
						@error('cac')
							<small id="cacHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
					</div>
					
					<div class="form-group">
						<label for="cac_no">CAC Registration Number</label>
						<input type="text" name="cac_no" class="form-control" id="cac_no" value="{{ old('cac_no') }}" aria-describedby="cac_noHelp" />
						<small id="cac_noHelp" class="form-text text-muted">Please type in your CAC Registration Number, Your business is registered with CAC.</small>
						@error('cac_no')
							<small id="cac_noHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
						
					</div>
					
					
				</div>
				
				<div class="col-md-5 col-sm-12 mt-2">
					
					@for ($i = 0; $i < 1; $i++)
							<div class="form-group">
<!--
								<label for="emails[{{$i}}]">#{{$i+1}} Business Email </label>
-->
								<label for="emails[{{$i}}]">Business Email </label>
								<input type="email" name="emails[{{$i}}]" class="form-control" id="emails[{{$i}}]" value="{{ old('emails.'.$i) }}" aria-describedby="emailsHelp" placeholder="example@business.com" />
								<!--
								<small id="emailsHelp" class="form-text text-muted">We'll never share your emails with anyone else.</small>
								-->
								@error('emails.'.$i)
									<small id="linksHelp" class="form-text text-muted red">{{ $message }}</small>
								@enderror
								
							</div>
						@endfor
						
						@for ($i = 0; $i < 1; $i++)
							<div class="form-group">
<!--
								<label for="phones[{{$i}}]">#{{$i+1}} Business Phone </label>
-->
								<label for="phones[{{$i}}]">Business Phone </label>
								<input type="text" name="phones[{{$i}}]" class="form-control" id="phones[{{$i}}]" value="{{ old('phones.'.$i) }}" aria-describedby="phonesHelp" placeholder="e.g 08012345678" />
								<!--
								<small id="phonesHelp" class="form-text text-muted">We'll never share your phones with anyone else.</small>
								-->
								@error('phones.'.$i)
									<small id="phonesHelp" class="form-text text-muted red">{{ $message }}</small>
								@enderror
								
							</div>
						@endfor
						
						@for ($i = 0; $i < 1; $i++)
							<div class="form-group">
<!--
								<label for="url[{{$i}}]">#{{$i+1}} Business Phone </label>
-->
								<label for="url[{{$i}}]">Business Website </label>
								<input type="text" name="url[{{$i}}]" class="form-control" id="url[{{$i}}]" value="{{ old('url.'.$i) }}" aria-describedby="urlHelp" placeholder="e.g http://website.com/" />
								<!--
								<small id="urlHelp" class="form-text text-muted">We'll never share your url with anyone else.</small>
								-->
								@error('url.'.$i)
									<small id="urlHelp" class="form-text text-muted red">{{ $message }}</small>
								@enderror
								
							</div>
						@endfor
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
