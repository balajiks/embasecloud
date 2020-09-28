<?php

namespace Modules\Indexing\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Messages\Entities\Emailing;

class IndexingBulkEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $mail;
    public $signature;
    public $module;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Emailing $mail, $signature)
    {
        $this->mail      = $mail;
        $this->signature = $signature;
        $this->module    = 'indexing';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->mail->files->count() > 0) {
            foreach ($this->mail->files as $f) {
                $this->attach(storage_path('app/' . $f->path . '/' . $f->filename));
            }
        }
        return $this->subject($this->mail->subject)
            ->from(indexingEmail()['email'], indexingEmail()['name'])
            ->markdown('emails.indexing.bulkemail');
    }
}
