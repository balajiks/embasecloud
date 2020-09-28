<?php

namespace Modules\Indexing\Notifications;

use App\Services\WhatsappMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Modules\Indexing\Entities\Indexing;

class IndexingCommented extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * Indexing Model
     *
     * @var \Modules\Indexing\Entities\Indexing
     */
    public $indexing;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Indexing $indexing)
    {
        $this->indexing = $indexing;
        $this->type = 'indexing_commented';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->notificationActive($this->type)) {
            return $notifiable->notifyOn($this->type, ['slack', 'database']);
        }
        return [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($notifiable->channelActive('mail', $this->type)) {
            return (new MailMessage)
                ->subject(langmail('indexing.commented.subject'))
                ->greeting(langmail('indexing.commented.greeting', ['name' => $notifiable->name]))
                ->line(langmail('indexing.commented.body', ['name' => $this->indexing->name]))
                ->line(route('indexing.view', $this->indexing->id));
        }
    }

    /*
    Send slack notification
     */
    public function toSlack($notifiable)
    {
        if ($notifiable->channelActive('slack', $this->type)) {
            return (new SlackMessage)
                ->content(
                    langmail(
                        'indexing.commented.body',
                        [
                            'name' => $this->indexing->name,
                        ]
                    )
                );
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if ($notifiable->channelActive('database', $this->type)) {
            return [
                'subject'  => langmail('indexing.commented.subject'),
                'icon'     => 'comments',
                'activity' => langmail(
                    'indexing.commented.body',
                    [
                        'name' => $this->indexing->name,
                    ]
                ),
            ];
        }
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        if ($notifiable->channelActive('nexmo', $this->type)) {
            return (new NexmoMessage)
                ->content(langmail(
                    'indexing.commented.body',
                    [
                        'name' => $this->indexing->name,
                    ]
                ));
        }
    }

    /**
    * Send message via WhatsApp
    */
    public function toWhatsapp($notifiable)
    {
        if ($notifiable->channelActive('whatsapp', $this->type)) {
            return WhatsappMessage::create()
                ->to($notifiable->mobile)
                ->custom($this->indexing->id)
                ->message(langmail(
                    'indexing.commented.body',
                    [
                        'name' => $this->indexing->name,
                    ]
                ));
        }
    }
}
