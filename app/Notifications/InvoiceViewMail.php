<?php 
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceViewMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoiceViewUrl;

    /**
     * Create a new message instance.
     *
     * @param string $invoiceViewUrl
     */
    public function __construct($invoiceViewUrl)
    {
        $this->invoiceViewUrl = $invoiceViewUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('View Your Invoice')
                    ->view('masteradmin.emails.invoices_view') 
                    ->with([
                        'invoiceViewUrl' => $this->invoiceViewUrl
                    ]);
    }
}
