@php 
	$settings = App\Settings::where('name', 'logo')->get();
	$logo = $settings->last();
	$data = json_decode($order->data, true);
@endphp

<img src="{{$logo->value}}" width="180px"/>
<h2>Dear {{$order->user->name}} </h2> 
<br />
<p>Thank you for shopping on My Yanga! Your order #{{$order->id}} has been successfully confirmed. </p>

<br/>

<table style='width: 100%; text-align: left; border: 1px solid #000;' >
<tr>
	<th>Product Image </th>
	<th>Product</th>
	<th>Quantity</th>
	<th>Amount</th>
</tr>
@foreach($data as $datum)
<tr style='border-bottom: 1px solid #000;' >
	<td><img src="{{$datum['picture'][0]['url']}}" width="100px"/></td>
	<td>{{$datum['product']['name']}}</td>
	<td>{{$datum['quantity']}}</td>
	<td>₦{{number_format($datum['quantity']*$datum['product']['price'])}}</td>
</tr>
@endforeach

	<tr>
		<th colspan='3' style="text-align: right;">Total</th>
		<td>₦{{number_format($order->amount)}}</td>
	</tr>
</table>
<br>
<table style='text-align: left;'>
	<tr><th>Delivery Address</th></tr>
	<tr><td>{{$order->address->address}}</td></tr>
</table>
