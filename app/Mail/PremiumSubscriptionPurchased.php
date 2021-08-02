<?php

namespace App\Mail;

use App\PremiumSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PremiumSubscriptionPurchased extends Mailable
{
    use Queueable, SerializesModels;
    
	public $premiumsubscription;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PremiumSubscription $premiumsubscription)
    {
        //
        $this->premiumsubscription = $premiumsubscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->view('emails.premium-subscription-purchased');
    }
}
