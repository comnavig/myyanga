<?php

namespace App\Mail;

use App\ProductSold;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductPurchased extends Mailable
{
    use Queueable, SerializesModels;
    
	public $productsold;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ProductSold $productsold)
    {
        //
        $this->productsold = $productsold;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->view('emails.product-purchased');
    }
}
