<?php

namespace Modules\Indexing\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Comments\Transformers\CommentsResource;
use Modules\Extras\Transformers\CallsResource;
use Modules\Indexing\Entities\Indexing;
use Modules\Indexing\Events\IndexingConverted;
use Modules\Indexing\Http\Requests\IndexingRequest;
use Modules\Indexing\Http\Requests\CreateSectionRequest;
use Modules\Indexing\Transformers\IndexingResource;
use Modules\Indexing\Transformers\IndexingResource;
use Modules\Todos\Transformers\TodosResource;
use DB;
class IndexingApiController extends Controller
{
    /**
     * Indexing Model
     *
     * @var \Modules\Indexing\Entities\Indexing
     */
    protected $indexing;
    /**
     * Request instance
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->middleware('localize');
        $this->request = $request;
        $this->indexing    = new Indexing;
    }
    /**
     * Return JSON Indexing
     */
    public function index()
    {
        $indexing = new IndexingResource(
            $this->indexing->whereNull('archived_at')->whereNull('converted_at')
                ->with(['AsSource:id,name', 'status:id,name', 'agent:id,email,name,username'])
                ->orderByDesc('id')
                ->paginate(50)
        );

        return response($indexing, Response::HTTP_OK);
    }
    /**
     * Show Indexing
     */
    public function show($id = null)
    {
        $indexing = $this->indexing->findOrFail($id);
        return response(new IndexingResource($indexing), Response::HTTP_OK);
    }
	
	
	
	
	/**
     * Save new indexing
     */
    public function savesection(CreateSectionRequest $request)
    {
		print '<pre>';
		print_r($_POST);
		exit;
	
		/*	print $request->orderid;*/
		if($request->jobdatayestoall == '1'){
			$sectionid =  $request->indexer_section[0];
			$matchThese 		= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid, 'sectionid' => $sectionid, 'pubchoice' => $request->indexer_publication, 'classid' => $request->indexer_classification];
			$repositoryname 	= DB::table('datasections')->where($matchThese)->get()->toArray();
			/*print'<pre>';
			print_r($repositoryname);
			exit;*/
			
			if(empty($repositoryname)){
				$conditionValues	= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid];
				$repositoryname 	= DB::table('datasections')->where($conditionValues)->get()->toArray();
			
				//print count($repositoryname);
				//exit;
				
				if(count($repositoryname) ==3){
					return ajaxResponse(
						[
							'count'      => count($repositoryname)+1,
							'message' => 'Maximum 6 allowed',
						],
					false,
					Response::HTTP_OK
					);
				
				} else {
					$InsertedID = DB::table('datasections')->insertGetId(
						[
							'jobid' 		=> $request->jobid, 
							'orderid' 		=> $request->orderid,
							'pui' 			=> $request->pui, 
							'user_id' 		=> \Auth::id(),
							'sectionid' 	=> $sectionid, 
							'pubchoice' 	=> $request->indexer_publication,
							'classid' 		=> $request->indexer_classification, 
							'status' 		=> '1', 
							'created_at' 	=> date('Y-m-d H:i:s'),
						]
					);
					return ajaxResponse(
						[
							'count'      	=> count($repositoryname)+1,
							'message' 		=> langapp('saved_successfully'),
						],
					true,
					Response::HTTP_OK
					);
			  }
			} else {
				
			}
			
		} else if($request->jobdatayestoall == '0'){

			//print_r($_POST);
			$indexersection 		= implode(',',$request->indexer_section);
			$WherematchThese 		= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid];
			$findsectiondata 		= DB::table('datasections')->select('sectionid')->whereIn('sectionid',$request->indexer_section)->where($WherematchThese)->get()->toArray();
			$totalsectiondata 		= DB::table('datasections')->where($WherematchThese)->get()->toArray();
			
			if(count($totalsectiondata) != langapp('sectioncnt')){
				if(!empty($findsectiondata)){
					return ajaxResponse(
							[
								'count'      => count($findsectiondata),
								'message' 	 => langapp('sectionexists'),
							],
						false,
						Response::HTTP_OK
						);
				} else {
					$data = array();
				 	foreach($request->indexer_section as $key => $sectionid){
					  $data[] =[
								'jobid' 		=> $request->jobid, 
								'orderid' 		=> $request->orderid,
								'pui' 			=> $request->pui,
								'user_id' 		=> \Auth::id(),
								'sectionid' 	=> $sectionid, 							
								'status' 		=> '1',
								'created_at' 	=> date('Y-m-d H:i:s'),
							   ];                 
				    }
					$InsertedID = DB::table('datasections')->insert($data);
					return ajaxResponse(
						[
							'count'      	=> count($totalsectiondata)+count($request->indexer_section),
							'message' 		=> langapp('saved_successfully'),
						],
					true,
					Response::HTTP_OK
					);
				}
			} else {
				return ajaxResponse(
						[
							'count'      => count($findsectiondata),
							'message'    => langapp('sectionallow'),
						],
					false,
					Response::HTTP_OK
					);
			}
		}
    }
	
    /**
     * Save new indexing
     */
    public function save(IndexingRequest $request)
    {
        $indexing = $this->indexing->firstOrCreate(['email' => $request->email], $request->except(['custom', 'tags']));

        return ajaxResponse(
            [
                'id'       => $indexing->id,
                'message'  => langapp('saved_successfully'),
                'redirect' => route('indexing.view', $indexing->id),
            ],
            true,
            Response::HTTP_CREATED
        );
    }
    /**
     * Update indexing
     */
    public function update(IndexingRequest $request, $id = null)
    {
        $request->validate(['email' => 'unique:indexing,email,'.$id]);
        $indexing = $this->indexing->findOrFail($id);
        $indexing->update($request->except(['custom', 'tags']));
        return ajaxResponse(
            [
                'id'       => $indexing->id,
                'message'  => langapp('changes_saved_successful'),
                'redirect' => route('indexing.view', $indexing->id),
            ],
            true,
            Response::HTTP_OK
        );
    }
    /**
     * Convert indexing to opportunity
     */
    public function convert($id)
    {
        $this->request->validate(['deal_title' => 'required', 'id' => 'required']);
        $indexing = $this->indexing->findOrFail($id);
        $data = $indexing->toCustomer();
        event(new IndexingConverted($indexing, \Auth::id()));

        return ajaxResponse($data);
    }
    /**
     * Move indexing to next stage
     */
    public function nextStage($id = null)
    {
        $this->request->validate(['stage' => 'required']);
        $indexing = $this->indexing->findOrFail($id);
        $indexing->update(['stage_id' => $this->request->stage]);
        return ajaxResponse(
            [
                'id'       => $indexing->id,
                'message'  => langapp('saved_successfully'),
                'redirect' => $this->request->url,
            ],
            true,
            Response::HTTP_OK
        );
    }
    /**
     * Move indexing to specified stage
     */
    public function moveStage()
    {
        $target_id = \App\Entities\Category::whereName(humanize($this->request->target))->first()->id;
        $indexing      = $this->indexing->findOrFail($this->request->id);
        $indexing->update(['stage_id' => $target_id]);
        return ajaxResponse(
            [
                'id'      => $indexing->id,
                'message' => langapp('indexing_stage_changed', ['name' => $indexing->name, 'stage' => humanize($this->request->target)]),
            ],
            true,
            Response::HTTP_OK
        );
    }
	
	 public function getsections($id = null)
    {
        
		
		
		$WherematchThese 		= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid];
		$findsectiondata 		= DB::table('datasections')->select('sectionid')->whereIn('sectionid',$request->indexer_section)->where($WherematchThese)->get()->toArray();
			
			
	   
	   // $indexing  = $this->indexing->findOrFail($id);
       // $calls = new CallsResource($indexing->calls()->orderBy('id', 'desc')->paginate(50));
        return response($findsectiondata, Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function calls($id = null)
    {
        $indexing  = $this->indexing->findOrFail($id);
        $calls = new CallsResource($indexing->calls()->orderBy('id', 'desc')->paginate(50));
        return response($calls, Response::HTTP_OK);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function todos($id = null)
    {
        $indexing  = $this->indexing->findOrFail($id);
        $todos = new TodosResource($indexing->todos()->with(['agent:id,username,name'])->orderBy('id', 'desc')->paginate(50));
        return response($todos, Response::HTTP_OK);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comments($id = null)
    {
        $indexing     = $this->indexing->findOrFail($id);
        $comments = new CommentsResource($indexing->comments()->orderBy('id', 'desc')->paginate(50));
        return response($comments, Response::HTTP_OK);
    }
    /**
     * Delete a indexing
     */
    public function delete($id = null)
    {
        $indexing = $this->indexing->findOrFail($id);
        $indexing->delete();
        return ajaxResponse(
            [
                'message'  => langapp('deleted_successfully'),
                'redirect' => route('indexing.index'),
            ],
            true,
            Response::HTTP_OK
        );
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function classification()
    {
		$output = '<option selected="true" disabled="disabled">Select Classification</option>';
		if($this->request->id!=''){
			$classification = DB::table('embaseindex_classifications')->where('section_id', $this->request->id)->get();
			foreach($classification as $classval){
				$output .=	'<option value="'.$classval->id.'">'.$classval->classvalue.'</option>';
			}
		}
		
        /*$indexing     = $this->indexing->findOrFail($id);
        $comments = new CommentsResource($indexing->comments()->orderBy('id', 'desc')->paginate(50));
        return response($comments, Response::HTTP_OK);*/
		return response($output, Response::HTTP_OK);
    }
}
