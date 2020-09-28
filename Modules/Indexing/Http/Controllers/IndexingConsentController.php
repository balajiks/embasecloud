<?php

namespace Modules\Indexing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Indexing\Entities\Indexing;

class IndexingConsentController extends Controller
{
    /**
     * Indexing model
     *
     * @var \Modules\Indexing\Entities\Indexing
     */
    protected $indexing;
   
    public function __construct()
    {
		$this->indexing = new Indexing;
    }

    public function accept($token = null)
    {
        $indexing =$this->indexing->whereToken($token)->first();
        if (isset($indexing->id)) {
            $indexing->update(['unsubscribed_at' => null]);
            $data['page'] = $this->getPage();
            $data['indexing'] = $indexing;
            return view('indexing::accepted')->with($data);
        }
        abort(404);
    }
    public function decline($token = null)
    {
        $indexing =$this->indexing->whereToken($token)->first();
        if (isset($indexing->id)) {
            $indexing->update(['unsubscribed_at' => now()->toDateTimeString()]);
            $data['page'] = $this->getPage();
            $data['indexing'] = $indexing;
            return view('indexing::declined')->with($data);
        }
        abort(404);
    }

    private function getPage()
    {
        return langapp('indexing');
    }
}
