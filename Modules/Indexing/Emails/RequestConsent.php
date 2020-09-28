<?php

namespace Modules\Indexing\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Indexing\Entities\Indexing;

class RequestConsent extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $indexing;
    /**
     * Create a new message instance.
     */
    public function __construct(Indexing $indexing)
    {
        $this->indexing = $indexing;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Indexing Consent Email')
            ->from(indexingEmail()['email'], indexingEmail()['name'])
            ->markdown('emails.indexing.consent');
    }
}
