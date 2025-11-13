@extends('layouts.admin')
@section('title', 'System Settings')
@section('page.title', 'System Settings')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			System Settings
		</h3>
	</div>
	<div class="col-12">
		<table class="table">
			<tr>
				<th>Logo</th>
				<td><img src="{{$settings['logo'] ?? ''}}" /></td>
				<td><a class="btn btn-sm main-color-bg" href="{{route('admin.settings.edit.image', ['name' => 'logo'])}}">edit</a></td>
			</tr>
			<tr>
				<th>Background 1</th>
				<td><img src="{{$settings['background_1'] ?? ''}}" width="100%" /></td>
				<td><a class="btn btn-sm main-color-bg" href="{{route('admin.settings.edit.image', ['name' => 'background_1'])}}">edit</a></td>
			</tr>
			<tr>
				<th>Premium Subscription Fee</th>
				<td>{{$settings['premium_subscription_fee'] ?? ''}}</td>
				<td><a class="btn btn-sm main-color-bg" href="{{route('admin.settings.edit', ['name' => 'premium_subscription_fee'])}}">edit</a></td>
			</tr>
			<tr>
				<th>Premium Subscription Duration <br><i>(in days)</i></th>
				<td>{{$settings['premium_subscription_duration'] ?? ''}}</td>
				<td><a class="btn btn-sm main-color-bg" href="{{route('admin.settings.edit', ['name' => 'premium_subscription_duration'])}}">edit</a></td>
			</tr>
			<tr>
				<th>Nigeria VAT</th>
				<td>{{$settings['ng_vat'] ?? ''}}</td>
				<td><a class="btn btn-sm main-color-bg" href="{{route('admin.settings.edit', ['name' => 'ng_vat'])}}">edit</a></td>
			</tr>
			<tr>
				<th>Subscription Notification Text</th>
				<td>{{$settings['subscription_notification_text'] ?? ''}}</td>
				<td><a class="btn btn-sm main-color-bg" href="{{route('admin.settings.edit', ['name' => 'subscription_notification_text'])}}">edit</a></td>
			</tr>
			<tr>
				<th>Number of contents to be sent in Notification</th>
				<td>{{$settings['content_number'] ?? ''}}</td>
				<td><a class="btn btn-sm main-color-bg" href="{{route('admin.settings.edit', ['name' => 'content_number'])}}">edit</a></td>
			</tr>
		</table>
	</div>
</div>
@endsection
