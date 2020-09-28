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

class IndexingAssignedAlert extends Notification implements ShouldQueue
{
    use Queueable;

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
        $this->type = 'indexing_assigned_alert';
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
            return $notifiable->notifyOn($this->type, ['mail']);
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
                ->greeting(langmail('indexing.assigned.greeting', ['name' => $notifiable->name]))
                ->line(
                    langmail(
                        'indexing.assigned.body',
                        [
                            'name' => $this->indexing->name,
                        ]
                    )
                )
                ->line(route('indexing.view', $this->indexing->id));
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        if ($notifiable->channelActive('slack', $this->type)) {
            return (new SlackMessage())
                ->success()
                ->content(langmail('indexing.assigned.body', ['name' => $this->indexing->name]))
                ->attachment(
                    function ($attachment) {
                        $attachment->title($this->indexing->name, route('indexing.view', $this->indexing->id))
                            ->fields(
                                [
                                    langapp('company')    => $this->indexing->company,
                                    langapp('source')     => $this->indexing->AsSource->name,
                                    langapp('stage')      => $this->indexing->status->name,
                                    langapp('indexing_value') => $this->indexing->computed_value,
                                ]
                            );
                    }
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
                'subject'  => langmail('indexing.assigned.subject'),
                'icon'     => 'headset',
                'activity' => langmail('indexing.assigned.body', ['name' => $this->indexing->name]),
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
                ->content(langmail('indexing.assigned.body', ['name' => $this->indexing->name]));
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
                ->message(langmail('indexing.assigned.body', ['name' => $this->indexing->name]));
        }
    }
}
