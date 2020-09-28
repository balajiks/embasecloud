<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebIndexingRequest;
use Illuminate\Http\Request;
use Modules\Indexing\Entities\Indexing;

class WebToIndexingController extends Controller
{
    public $indexing;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->indexing = new Indexing;
    }

    public function form()
    {
        return view('indexing::webindexing');
    }

    public function capture(WebIndexingRequest $request)
    {
        $rules                    = [];
        if (settingEnabled('indexing_recaptcha')) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }
        $this->validate($request, $rules);

        $this->indexing->firstOrCreate(['email' => $request->email], $request->except(['agree_terms']));

        toastr()->success(langapp('indexing_contact_success'), langapp('response_status'));
        return redirect(url()->previous())->with('message', langapp('indexing_contact_success'));
    }
}
