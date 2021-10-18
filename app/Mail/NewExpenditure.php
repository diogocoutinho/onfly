<?php

namespace App\Mail;

use App\Models\Expenditure;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewExpenditure extends Mailable
{
    use Queueable, SerializesModels;
    protected $expenditure;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Expenditure $expenditure)
    {
        $this->expenditure = $expenditure;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('vendor.notifications.email')
                    ->with([
                        'expenditure' => $this->expenditure,
                        'level'       => 'success'
                    ]);
    }
}
