<?php

namespace Modules\Creditnotes\Observers;

use Modules\Clients\Jobs\ClientBalance;
use Modules\Creditnotes\Entities\CreditNote;
use Modules\Creditnotes\Entities\Credited;
use Modules\Creditnotes\Jobs\CalculateCredits;

class CreditNoteObserver
{

    /**
     * Listen to the CreditNote creating event.
     *
     * @param \Modules\Creditnotes\Entities\CreditNote $creditnote
     */
    public function creating(CreditNote $creditnote)
    {
        $creditnote->reference_no = generateCode('credits');
    }

    /**
     * Listen to the Credit Note saving event.
     *
     * @param \Modules\Creditnotes\Entities\CreditNote $creditnote
     */
    public function saving(CreditNote $creditnote)
    {
        $creditnote->exchange_rate = xchangeRate($creditnote->currency);
    }

    /**
     * Listen to the CreditNote saved event.
     *
     * @param \Modules\Creditnotes\Entities\CreditNote $creditnote
     */
    public function saved(CreditNote $creditnote)
    {
        if (request()->has('tags')) {
            $creditnote->retag(collect(request('tags'))->implode(','));
        }
        CalculateCredits::dispatch($creditnote)->onQueue('high');
        ClientBalance::dispatch($creditnote->company)->onQueue('high');
    }

    /**
     * Listen to the Credit Note deleting event.
     *
     * @param \Modules\Creditnotes\Entities\CreditNote $creditnote
     */
    public function deleting(CreditNote $creditnote)
    {
        foreach ($creditnote->items as $item) {
            $item->delete();
        }
        foreach ($creditnote->activities as $activity) {
            $activity->delete();
        }
        foreach ($creditnote->comments as $comment) {
            $comment->delete();
        }
        foreach ($creditnote->files as $file) {
            $file->delete();
        }
        $creditnote->detag();
        
        Credited::where('creditnote_id', $creditnote->id)->delete();
    }
}
