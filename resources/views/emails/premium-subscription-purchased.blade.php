@php 
	$settings = App\Settings::where('name', 'logo')->get();
	$logo = $settings->last();
@endphp

<img src="{{$logo->value}}" width="180px"/>
<h2>Dear {{$premiumsubscription->user->name}} </h2> 
<br />
<p>Listed below is your subscription summary: </p>

<table style='width: 100%; text-align: left; border: 1px solid #000;'>
	<thead>
		<tr>
			<th>Transaction Date</th>
			<th>Expiry Date</th>
			<th>Amount</th>
			<th>VAT</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{$premiumsubscription->created_at->format('D dS, M Y')}}</td>
			<td>{{date_format(date_create($premiumsubscription->expiry), 'D dS, M Y')}}</td>
			<td>₦{{$premiumsubscription->amount}}</td>
			<td>₦{{$premiumsubscription->vat}}</td>
			<th>₦{{$premiumsubscription->amount + $premiumsubscription->vat}}</th>
		</tr>
		<tr>
			<td colspan="4"></td>
			<th>{{$premiumsubscription->status}}</th>
		</tr>
	</tbody>
</table>


<br/>

<p>Thank you</p>
