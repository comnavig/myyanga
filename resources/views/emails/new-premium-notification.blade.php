@php 
	$settings = App\Settings::where('name', 'logo')->get();
	$logo = $settings->last();
@endphp

<div style="width: 100%; max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; color: #333;">
	<!-- Header Section -->
	<div style="padding: 20px; text-align: center; background-color: #f4f4f4;">
		<img src="{{$logo->value}}" alt="Company Logo" width="180" style="display: block; margin: 0 auto;">
	</div>

	<!-- Greeting Section -->
	<div style="padding: 20px;">
		<h2 style="color: #555;">Dear {{$user->name}},</h2>
		<p>Listed below are the latest premium items you might be interested in:</p>
	</div>

	<!-- View All Button Section -->
	<div style="width: 100%; text-align: center; padding: 20px;">
		<a href="{{route('login', ['redirect' => route('user.notifications.single', ['id' => $user->newNotificationId])])}}" 
			style="display: inline-block; padding: 10px 20px; color: white; background-color: #4CAF50; text-decoration: none; font-weight: bold; border-radius: 5px;">
			Click Here to View More
		</a>
	</div>

	<!-- Footer Section -->
	<div style="text-align: center; padding: 10px; background-color: #f4f4f4; color: #777;">
		<p>Thank you,</p>
		<p>Myyanga Team</p>
	</div>
</div>
