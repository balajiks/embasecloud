<?php

namespace Modules\Indexing\Console;

use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Search\Flag\Unseen;
use Ddeboer\Imap\Server;
use Illuminate\Console\Command;
use Modules\Indexing\Entities\Indexing;
use Storage;

class IndexingEmails extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'indexing:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for emails from indexing.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (settingEnabled('indexing_mail_imap') && config('system.imap_enabled') === true) {
            $server = new Server(
                get_option('indexing_mail_host'),
                get_option('indexing_mail_port'),
                get_option('indexing_mail_flags')
            );
            $connection = $server->authenticate(get_option('indexing_mail_username'), get_option('indexing_mail_password'));
            $mailbox    = $connection->getMailbox(get_option('indexing_mailbox'));

            $search = new SearchExpression();
            $search->addCondition(new Unseen());

            $messages = $mailbox->getMessages($search);

            foreach ($messages as $message) {
                $subject = $message->getSubject();
                $from    = $message->getFrom();
                $body    = is_null($message->getBodyHtml()) ? $message->getBodyText() : $message->getBodyHtml();

                if (!is_null($from)) {
                    $indexing = Indexing::where('email', $from->getAddress())->first();

                    if (isset($indexing->id)) {
                        // Save email to database
                        $email = $indexing->emails()->create([
                            'to'          => 0,
                            'from'        => $indexing->id,
                            'subject'     => $subject,
                            'message'     => $body,
                            'mail_folder' => get_option('indexing_mailbox'),
                            'meta'        => [
                                'sender' => $from->getAddress(),
                            ],
                        ]);
                        $uploadDir = 'uploads/emails';
                        foreach ($message->getAttachments() as $file) {
                            $fileName = genUnique() . '_' . $file->getFilename();
                            Storage::put($uploadDir . '/' . $fileName, $file->getDecodedContent());
                            $email->files()->create(
                                [
                                    'filename'    => $fileName, 'title' => $email->subject,
                                    'path'        => $uploadDir, 'ext'  => strtolower($file->getType() . '/' . $file->getSubtype()),
                                    'size'        => round($file->getBytes() / 1024, 2),
                                    'adapter'     => config('filesystems.default'),
                                    'description' => $email->subject . ' file uploaded via email',
                                    'user_id'     => $indexing->id,
                                ]
                            );
                        }
                        $indexing->unsetEventDispatcher();
                        $indexing->compute();
                    } else {
                        Indexing::create(['email' => $from->getAddress(), 'name' => $from->getName()]);
                    }
                }
                $message->markAsSeen();
            }
        }
        $this->info('Indexing emails synced successfully');
    }
}
