@extends('layouts.app')
@section('title', "Vote for ".$entry->user->name)

@section('content')

<div class="col-lg-7 col-md-12 col-sm-12" style="margin-top: 3%;">
	<h3 class="main-color "><span class="font-weight-bolder">{{$entry->user->name}}&apos;s entry</span> <i> for <a class="main-color" href="{{route('pyls.competition', ['slug' => $pyl->slug])}}"> {{$pyl->name}}</a></i> </h3>
</div>
<div class="white-bg" style="width:100%; float: left; margin-bottom: 60px;">
	<div style="margin-top: 2%;">
		<div class="row m-0 p-0">
			<div class="col-lg-7 col-md-12 col-sm-12 float-left">
				<div class="col-12 p-0">
					@if(Session::has('message'))
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<div class="container">
								{{ Session::get('message') }}
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						</div>
					@endif
					@if($errors->any())
					<div class="alert alert-danger">
						<div class="container">
							 <ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
					@endif
					
				</div>
				<div class="product-image">
					<img src="{{$entry->photo}}" class="d-block m-auto" alt="{{$entry->user->name}}">
				</div>
			</div>
			<div class="col-lg-5 col-md-12 col-sm-12 p-2 float-left">
				
				<div class="col-12 m-0 py-2 my-3">
					<div class="sharethis-inline-share-buttons"></div>
					@include('components.share-button')
				</div>
				<div class="col-12">
					@include('components.pyl-votes', ['votes' => $entry->votes, 'upyl_id' => $entry->id, 'expired' => $pyl->expired()])
				</div>
			</div>
		</div>
	
	</div>
</div>
	
@endsection

@push('styles')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<style>
		button.fas {
		  padding: 20px;
		  font-size: 30px;
		  width: 50px;
		  text-align: center;
		  text-decoration: none;
		  margin: 5px 2px;
		}
		
		button.fas:hover {
			opacity: 0.7;
		}
		
		button.fas-facebook {
		  background: #3B5998;
		  color: white;
		}
		
		button.fas-twitter {
		  background: #55ACEE;
		  color: white;
		}
		
		button.fas-google {
		  background: #dd4b39;
		  color: white;
		}
		
		button.fas-linkedin {
		  background: #007bb5;
		  color: white;
		}
		
		button.fas-youtube {
		  background: #bb0000;
		  color: white;
		}
		
		button.fas-instagram {
		  background: #125688;
		  color: white;
		}
		
		button.fas-pinterest {
		  background: #cb2027;
		  color: white;
		}
		
		button.fas-snapchat-ghost {
		  background: #fffc00;
		  color: white;
		  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
		}
		
		button.fas-skype {
		  background: #00aff0;
		  color: white;
		}
		
		button.fas-whatsapp {
		  background: #a4c639;
		  color: white;
		}
		
		button.fas-dribbble {
		  background: #ea4c89;
		  color: white;
		}
		
		button.fas-vimeo {
		  background: #45bbff;
		  color: white;
		}
		
		button.fas-tumblr {
		  background: #2c4762;
		  color: white;
		}
		
		button.fas-vine {
		  background: #00b489;
		  color: white;
		}
		
		button.fas-foursquare {
		  background: #45bbff;
		  color: white;
		}
		
		button.fas-stumbleupon {
		  background: #eb4924;
		  color: white;
		}
		
		button.fas-flickr {
		  background: #f40083;
		  color: white;
		}
		
		button.fas-yahoo {
		  background: #430297;
		  color: white;
		}
		
		button.fas-soundcloud {
		  background: #ff5500;
		  color: white;
		}
		
		button.fas-reddit {
		  background: #ff5700;
		  color: white;
		}
		
		button.fas-rss {
		  background: #ff6600;
		  color: white;
		}
	</style>
@endpush

@push('scripts')
    <script async src="https://static.addtoany.com/menu/page.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/all.min.js" integrity="sha512-8pHNiqTlsrRjVD4A/3va++W1sMbUHwWxxRPWNyVlql3T+Hgfd81Qc6FC5WMXDC+tSauxxzp1tgiAvSKFu1qIlA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script type="text/javascript">
		$(document).ready(function(e){
			const socialmedia = ['facebook', 'twitter', 'whatsapp'];
			const socialmediaurls = GetSocialMediaSiteLinks_WithShareLinks({
				'url': window.location.href,
				'title': '{{$entry->user->name}}',
				'image':'{{$entry->photo}}',
				'desc':'',
				'appid':'',
				'redirecturl':'',
				'via':'',
				'hashtags':'',
				'provider':'',
				'language':'',
				'userid':'',
				'category':'',
				'phonenumber':'',
				'emailaddress':'',
				'ccemailaddress':'',
				'bccemailaddress':'',
			});
			
			var children = [];
			
			for(var i = 0; i < socialmedia.length; i++) {
				const socialmedium = socialmedia[i];
				
				children.push(
					'<button type="button" class="btn fas-'+socialmedium+'" onclick="location.href=\''+socialmediaurls[socialmedium]+'\'"><i class="fa-brands fa-'+socialmedium+'"></i></button>'
				);
			}
			
			$('#output-table').empty();
			$('#output-table').append(children.join());
			
			return true;	// success
		});
	</script>
@endpush
