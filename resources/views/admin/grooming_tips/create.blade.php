@extends('layouts.admin')
@section('title', 'Create Grooming Tip')
@section('page.title', 'Create Grooming Tip')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Form
			<a class="btn btn-sm main-btn-bg float-right" href="{{route('admin.groomingtips')}}">back to grooming tips</a>
		</h3>
	</div>
	<div class="col-12">
		<form method="post" action="{{route('admin.groomingtip.add')}}"  enctype="multipart/form-data" >
			@csrf
			<div class="row">
				<div class="col-md-6 col-sm-12 mt-2">
					
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
				
				<div class="col-md-6 col-sm-12 mt-2">
					
					@for ($i = 0; $i < 1; $i++)
						<div class="form-group">
							<label for="categories[{{$i}}]">Category </label>
							<select name="categories[{{$i}}]" class="form-control" id="categories[{{$i}}]" aria-describedby="categoriesHelp" required >
								<option value="">Please Select Category</option>
								@foreach($categories as $category)
									<option value="{{$category->id}}" {{ (old('categories.'.$i) == $category->id ? "selected" : "" )}}>{{$category->name}}</option>
								@endforeach	
							</select>
							<!--
							<small id="catgeoriesHelp" class="form-text text-muted">We'll never share your catgeories with anyone else.</small>
							-->
							@error('categories.'.$i)
								<small id="catgeoriesHelp" class="form-text text-muted red">{{ $message }}</small>
							@enderror
							
						</div>
					@endfor
					
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
				
				
				<div class="col-md-12 col-sm-12 m-0">
					<div class="col-12 m-0 p-0 mt-2">
						<label>Picture<sup class='red'>*</sup> </label>
						<div class="row">
							
							@for ($i = 0; $i < 1; $i++)
								<div class="" style="width: 250px; height: 250px; overflow: hidden; padding: 20px; margin: 10px;">
									<label for="pictures[{{$i}}]">
										<div>
											<img id="photo_img_{{$i}}" src="{{asset('assets/img/image.svg')}}" width="200px" />
										</div>
									</label>
									<input type="file" name="pictures[{{$i}}]" class="form-control" id="pictures[{{$i}}]" accept="image/jpeg, image/png" style="display: none;" onchange="loadFile(event, 'photo_img_{{$i}}')"  aria-describedby="picturesHelp"/>
									
									
									@error('pictures.'.$i)
										<small id="picturesHelp" class="form-text text-muted red">{{ $message }}</small>
									@enderror
									
								</div>
							@endfor
						</div>
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
