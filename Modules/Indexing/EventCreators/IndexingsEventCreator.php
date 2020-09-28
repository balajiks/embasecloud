<?php

namespace Modules\Indexing\EventCreators;

use App\Contracts\EventCreatorInterface;

class IndexingEventCreator implements EventCreatorInterface
{
    public function logEvent($model)
    {
        $model->schedules()->updateOrCreate(
            [
            'calendar_id' => get_option('default_calendar'),
            'user_id' => \Auth::id(),
            'event_name' => 'Indexing ['.$model->name.']',
            ], [
            'start_date' => $model->due_date,
            'end_date' => $model->due_date,
            'color' => '#ffac00',
            'location' => get_option('company_city'),
            'description' => 'Indexing '.$model->name.' expiry date',
            'url' => 'calendar/view/'.$model->id.'/indexing'
            ]
        );
    }
}
