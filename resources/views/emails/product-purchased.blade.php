@php 
	$settings = App\Settings::where('name', 'logo')->get();
	$logo = $settings->last();
@endphp

<img src="{{$logo->value}}" width="180px"/>
<h2>Dear {{$productsold->product->user->name}} </h2> 
<br />
<p>Listed below are product(s) that needs to be delivered to:. </p>
<p>
	<strong>Name:</strong> {{$productsold->order->user->name}}<br/>
	<strong>Phone:</strong> {{$productsold->order->user->mobile}}<br/>
	<strong>Address:</strong> {{$productsold->order->address->address}}
</p>
<br/>

<table style='width: 100%; text-align: left; border: 1px solid #000;'>
	<tr>
		<th>Product Image</th>
		<th>Product</th>
		<th>Quantity</th>
		<th>Amount</th>
	</tr>
	<tr>
		<td><img src="{{$productsold->product->picture[0]->url}} " width='150px' /></td>
		<td>{{$productsold->product->name}} </td>
		<td>{{$productsold->quantity}}</td>
		<td>₦{{number_format($productsold->amount)}}</td>
	</tr>
</table>

<br/>

<p>Thank you</p>
