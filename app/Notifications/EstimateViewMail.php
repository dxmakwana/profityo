<?php 
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EstimateViewMail extends Mailable
{
    use Queueable, SerializesModels;

    public $estimateViewUrl;

    /**
     * Create a new message instance.
     *
     * @param string $estimateViewUrl
     */
    public function __construct($estimateViewUrl)
    {
        $this->estimateViewUrl = $estimateViewUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('View Your Estimate')
                    ->view('masteradmin.emails.estimate_view') 
                    ->with([
                        'estimateViewUrl' => $this->estimateViewUrl
                    ]);
    }
}
