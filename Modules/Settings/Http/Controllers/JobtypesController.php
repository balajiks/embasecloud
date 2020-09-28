<?php

namespace Modules\Settings\Http\Controllers;

use App\Entities\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class JobtypesController extends Controller
{
    public $page;
    public $category;
    public $request;
    /**
     * Create a new controller instance.
     */
    public function __construct(Category $category, Request $request)
    {
        $this->middleware(['auth', 'verified', '2fa']);
        $this->request  = $request;
        $this->category = $category;
    }

   

    public function jobtypes($module = null)
    {
        $data['module'] = $module;

        return view('settings::modal.jobtypes')->with($data);
    }


}