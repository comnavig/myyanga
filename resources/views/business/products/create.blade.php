@extends('layouts.business')
@section('title', 'Create Product \ Service')
@section('page.title', 'Create Product \ Service')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Form
			<a class="btn btn-sm main-btn-bg float-right" href="{{route('listings.products', ['id' => $listing->id ])}}">back to products</a>
		</h3>
	</div>
	<div class="col-12">
		<form method="post" action="{{route('listings.add.product', ['id' => $listing->id ])}}"  enctype="multipart/form-data" >
			@csrf
			<input type="hidden" name="listing_id" value="{{$listing->id}}" />
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
								@foreach($categories->where('parent_id',0) as $category)
								<optgroup label="{{$category->name}}">
									@foreach($categories->where('parent_id', $category->id) as $sub)
										<option value="{{$sub->id}}" {{ (old('categories.'.$i) == $sub->id ? "selected" : "" )}}>{{$sub->name}}</option>
									@endforeach
								</optgroup>
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
						<label for="description">Description</label>
						<textarea name="description" class="form-control" id="description" aria-describedby="descriptionHelp" rows="12" required >{{ old('description') }}</textarea>
						<small id="descriptionHelp" class="form-text text-muted">Please write about your business.</small>
						@error('description')
							<small id="descriptionHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
					</div>
				
				</div>
				
				<div class="col-md-12 col-sm-12 mt-2">
					<div class="form-group">
						<label for="tips">Tips</label>
						<textarea name="tips" class="form-control" id="tips" aria-describedby="tipsHelp" rows="12" required >{{ old('tips') }}</textarea>
						<small id="tipsHelp" class="form-text text-muted">Please write about your business.</small>
						@error('tips')
							<small id="tipsHelp" class="form-text text-muted red">{{ $message }}</small>
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
				
				<div class="col-md-12 col-sm-12">
					<div class="row mt-2">
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label for="price">Price</label>
								<input type="number" name="price" class="form-control" id="price" value="{{ old('price') ?? 0 }}" aria-describedby="priceHelp" required />
								<small id="priceHelp" class="form-text text-muted">Please type in the price, if this product is available for sale.</small>
								@error('price')
									<small id="priceHelp" class="form-text text-muted red">{{ $message }}</small>
								@enderror
								
							</div>
							
							<div class="form-group">
								<label for="deliveryfee">Delivery Fee</label>
								<input type="number" name="deliveryfee" class="form-control" id="deliveryfee" value="{{ old('deliveryfee') ?? 0 }}" aria-describedby="deliveryfeeHelp" required />
								<small id="deliveryfeeHelp" class="form-text text-muted">Please type in the delivery fee.</small>
								@error('deliveryfee')
									<small id="deliveryfeeHelp" class="form-text text-muted red">{{ $message }}</small>
								@enderror
								
							</div>
						</div>
						
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label for="quantity">Quantity</label>
								<input type="number" name="quantity" class="form-control" id="quantity" value="{{ old('quantity') ?? 0 }}" aria-describedby="quantityHelp" required />
								<small id="quantityHelp" class="form-text text-muted">Please type in the delivery fee.</small>
								@error('quantity')
									<small id="quantityHelp" class="form-text text-muted red">{{ $message }}</small>
								@enderror
								
							</div>
						</div>
						
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label for="returnpolicy">Return Policy</label>
								<textarea name="returnpolicy" class="form-control" id="returnpolicy" aria-describedby="returnpolicyHelp" >{{ old('returnpolicy') }}</textarea>
								<small id="returnpolicyHelp" class="form-text text-muted">Please write about your return policy.</small>
								@error('returnpolicy')
									<small id="returnpolicyHelp" class="form-text text-muted red">{{ $message }}</small>
								@enderror
							</div>
							
							<div class="form-group">
								<label for="deliveryinfo">Delivery Information</label>
								<textarea name="deliveryinfo" class="form-control" id="deliveryinfo" aria-describedby="deliveryinfoHelp" >{{ old('deliveryinfo') }}</textarea>
								<small id="deliveryinfoHelp" class="form-text text-muted">Please write about your delivery information.</small>
								@error('deliveryinfo')
									<small id="deliveryinfoHelp" class="form-text text-muted red">{{ $message }}</small>
								@enderror
							</div>
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
		  //~ CKEDITOR.replace( 'description' );
	var loadFile = function(event, image_id) {
		var image = document.getElementById(image_id);
		image.src = URL.createObjectURL(event.target.files[0]);
	};
</script>
@endpush
