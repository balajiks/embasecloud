<?php

namespace Modules\Indexing\Observers;

use App\Entities\Category;
use Modules\Indexing\Entities\Indexing;

class IndexingObserver
{
    /**
     * Listen to the Indexing saving event.
     *
     * @param Indexing $indexing
     */
    public function saving(Indexing $indexing)
    {
        if (empty($indexing->name) || $indexing->name == '') {
            $indexing->name = $indexing->email;
        }
        $indexing->stage_id = empty($indexing->stage_id) ? get_option('default_indexing_stage') : $indexing->stage_id;
        if (!is_numeric($indexing->stage_id)) {
            $stage          = Category::whereName($indexing->stage)->whereModule('indexing')->first();
            $indexing->stage_id = $stage->id;
        }
        if (!is_numeric($indexing->source)) {
            $source       = Category::firstOrCreate(['name' => $indexing->source, 'module' => 'source'], ['color' => 'info']);
            $indexing->source = $source->id;
        }
        $indexing->sales_rep      = $indexing->sales_rep <= 0 ? get_option('default_sales_rep') : $indexing->sales_rep;
        $indexing->computed_value = formatCurrency(get_option('default_currency'), parseCurrency($indexing->indexing_value));
    }

    public function creating(indexing $indexing)
    {
        $indexing->token         = genToken();
        $indexing->next_followup = now()->addDays(get_option('indexing_followup_days'));
        $indexing->due_date      = empty($indexing->due_date) ? now()->addDays(get_option('indexing_expire_days')) : $indexing->due_date;
        if (settingEnabled('indexing_opt_in')) {
            $indexing->unsubscribed_at = now()->toDateTimeString();
        }
    }

    /**
     * Listen to the indexing updated event.
     *
     * @param indexing $indexing
     */
    public function saved(Indexing $indexing)
    {
        if (request()->has('tags')) {
            $indexing->retag(collect(request('tags'))->implode(','));
        }
        \Artisan::queue('indexing:calcstage');
        $indexing->saveCustom(request('custom'));
    }

    /**
     * Listen to Indexing deleting event.
     *
     * @param Indexing $indexing
     */
    public function deleting(Indexing $indexing)
    {
        foreach ($indexing->comments as $comment) {
            $comment->delete();
        }
        foreach ($indexing->custom as $field) {
            $field->delete();
        }
        foreach ($indexing->emails as $email) {
            $email->delete();
        }
        foreach ($indexing->calls as $call) {
            $call->delete();
        }
        foreach ($indexing->activities as $activity) {
            $activity->delete();
        }
        foreach ($indexing->notes as $note) {
            $note->delete();
        }
        foreach ($indexing->schedules as $event) {
            $event->delete();
        }
        foreach ($indexing->files as $file) {
            $file->delete();
        }
        foreach ($indexing->todos as $todo) {
            $todo->delete();
        }

        $indexing->detag();
    }
}
