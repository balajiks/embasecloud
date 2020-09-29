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
use Modules\Indexing\Http\Requests\CreateMedicalRequest;
use Modules\Indexing\Http\Requests\CreateDruglinksRequest;
use Modules\Indexing\Http\Requests\CreateCtnRequest;

use Modules\Indexing\Transformers\IndexingResource;
use Modules\Indexing\Transformers\IndexingsResource;
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
        $indexing = new IndexingsResource(
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
	
	
	public function apicompletejob(CreateMedicalRequest $request){
			DB::table('projects')->where('id', $request->jobid)->update(['jobstatus' => 'completed']);
			
			$data['message']  	= langapp('mark_as_jobcomplete_info');
       		$data['redirect'] 	= get_option('site_url').'indexing';
	        return ajaxResponse($data, true, Response::HTTP_OK);
	}
	
	
	
	public function getsectiondata($id = null){
			$getSectiondata		=	DB::table('datasections')->where('id', $id)->get()->toArray();
			return ajaxResponse($getSectiondata, true, Response::HTTP_OK);
	}
	
	public function getmedicaldata($id = null){
			$getMedicaldata		=	DB::table('index_medical_term')->where('id', $id)->get()->toArray();
			return ajaxResponse($getMedicaldata, true, Response::HTTP_OK);
	}

	public function getdrugdata($id = null){
			$getDrugdata		=	DB::table('index_drug')->where('id', $id)->get()->toArray();
			return ajaxResponse($getDrugdata, true, Response::HTTP_OK);
	}
	
	/**
     * Save new indexing
     */
    public function savesection(CreateSectionRequest $request)
    {
		/*	print $request->orderid;*/
		if($request->jobdatayestoall == '1'){
			if($request->sectionid == '0'){
				$sectionval =  $request->indexer_section;
				$matchThese 		= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'pui' => $request->pui, 'orderid' => $request->orderid, 'sectionval' => $sectionval];
				$repositoryname 	= DB::table('datasections')->where($matchThese)->get()->toArray();
				// Check Sectionval 
				if(empty($repositoryname)){
					$conditionValues	= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'pui' => $request->pui, 'orderid' => $request->orderid];
					$repositoryname 	= DB::table('datasections')->where($conditionValues)->get()->toArray();
					
					if(count($repositoryname) <= langapp('sectioncnt')){
						if($request->indexer_publication == '+'){
						  $conditionValues	= ['user_id' => \Auth::id(), 'pubchoice' => '+', 'pui' => $request->pui, 'jobid' => $request->jobid, 'orderid' => $request->orderid];
						  $pubchoicecount 	= DB::table('datasections')->where($conditionValues)->count();
							if($pubchoicecount <= '1'){
								if($request->indexer_classification !=''){
									$classficationval	= implode ( '|||', $request->indexer_classification );
								} else {
									$classficationval	= '';
								}
								$InsertedID = DB::table('datasections')->insertGetId(
									[
										'jobid' 			=> $request->jobid, 
										'orderid' 			=> $request->orderid,
										'pui' 				=> $request->pui, 
										'user_id' 			=> \Auth::id(),
										'sectionval' 		=> $sectionval, 
										'pubchoice' 		=> $request->indexer_publication,
										'classificationval' => $classficationval, 
										'status' 			=> '1', 
										'created_at' 		=> date('Y-m-d H:i:s'),
									]
								);
								$last_id 	= DB::getPDO()->lastInsertId();	 
								$secdata 	= DB::table('datasections')->where('id', $last_id)->get()->toArray();
							
								if ($this->request->has('json')) {
									$html= view('indexing::newSectionClassificationHtml', compact('secdata'))->render();
								}  
							
								$conditionValues = ['user_id' => \Auth::id(), 'pui' => $request->pui, 'jobid' => $request->jobid, 'orderid' => $request->orderid];
								$sectioncount 	 = DB::table('datasections')->where($conditionValues)->count();
								$conditionValues = ['user_id' => \Auth::id(), 'pubchoice' => '+', 'pui' => $request->pui, 'jobid' => $request->jobid, 'orderid' => $request->orderid];
								$pubchoicecount  = DB::table('datasections')->where($conditionValues)->count();
								if ($this->request->has('json')) {
									return ajaxResponse(['status' => 'success', 'count' => $sectioncount,'pubchoicecount'  => $pubchoicecount, 'html' => $html, 'message' => langapp('saved_successfully')],true,Response::HTTP_OK
									);
								}
							return ajaxResponse(['count' => count($repositoryname)+1, 'pubchoicecount' => $pubchoicecount, 'message' => langapp('saved_successfully')],true,Response::HTTP_OK);
							} else {
								return ajaxResponse(['count' => $pubchoicecount+1,'message' => 'Publication Choice (+) Maximum 2 allowed'],false,Response::HTTP_OK);
							}
						 } else {
								if($request->indexer_classification !=''){
									$classficationval	= implode ( '|||', $request->indexer_classification );
								} else {
									$classficationval	= '';
								}
								$InsertedID = DB::table('datasections')->insertGetId(
									[
										'jobid' 			=> $request->jobid, 
										'orderid' 			=> $request->orderid,
										'pui' 				=> $request->pui, 
										'user_id' 			=> \Auth::id(),
										'sectionval' 		=> $sectionval, 
										'pubchoice' 		=> $request->indexer_publication,
										'classificationval' => $classficationval, 
										'status' 			=> '1', 
										'created_at' 		=> date('Y-m-d H:i:s'),
									]
								);
								$last_id 	= DB::getPDO()->lastInsertId();	 
								$secdata 	= DB::table('datasections')->where('id', $last_id)->get()->toArray();
							
								if ($this->request->has('json')) {
									$html= view('indexing::newSectionClassificationHtml', compact('secdata'))->render();
								}  
							
								$conditionValues = ['user_id' => \Auth::id(), 'pui' => $request->pui, 'jobid' => $request->jobid, 'orderid' => $request->orderid];
								$sectioncount 	 = DB::table('datasections')->where($conditionValues)->count();
								$conditionValues = ['user_id' => \Auth::id(), 'pubchoice' => '+', 'pui' => $request->pui, 'jobid' => $request->jobid, 'orderid' => $request->orderid];
								$pubchoicecount  = DB::table('datasections')->where($conditionValues)->count();
								if ($this->request->has('json')) {
									return ajaxResponse(['status' => 'success', 'count' => $sectioncount,'pubchoicecount'  => $pubchoicecount, 'html' => $html, 'message' => langapp('saved_successfully')],true,Response::HTTP_OK
									);
								}
							return ajaxResponse(['count' => count($repositoryname)+1, 'pubchoicecount' => $pubchoicecount, 'message' => langapp('saved_successfully')],true,Response::HTTP_OK);
						 }
						} else {
						return ajaxResponse(
								[
									'count'      => count($repositoryname)+1,
									'message' => 'Maximum 6 allowed',
								],
							false,
							Response::HTTP_OK
							);
						}
					} else {
						return ajaxResponse(
							[
								'count'      => count($repositoryname),
								'message' 	 => $sectionval.' '.langapp('sectionexists'),
							],
						false,
						Response::HTTP_OK
						);
					}
				} else {
					if($request->indexer_classification !=''){
						$classficationval	= implode ( '|||', $request->indexer_classification );
					} else {
						$classficationval	= '';
					}
					
					//DB::table('projects')->where('id', $request->sectionid)->update(['sectionval' => $request->indexer_section, 'pubchoice' => $request->indexer_publication, 'classificationval' => $classficationval]);
					
					
					$values=array('sectionval' => $request->indexer_section, 'pubchoice' => $request->indexer_publication, 'classificationval' => $classficationval);
					DB::table('datasections')->where('id',$request->sectionid)->update($values);
					
					$conditionValues	= ['user_id' => \Auth::id(), 'pui' => $request->pui, 'jobid' => $request->jobid, 'orderid' => $request->orderid];
					$sectioncount 		= DB::table('datasections')->where($conditionValues)->count();
				
					$conditionValues	= ['user_id' => \Auth::id(), 'pubchoice' => '+', 'pui' => $request->pui, 'jobid' => $request->jobid, 'orderid' => $request->orderid];
					$pubchoicecount 	= DB::table('datasections')->where($conditionValues)->count();	
					
					//$secdata 	= DB::table('datasections')->where('id', $request->sectionid)->get()->toArray();
					//$html		= view('indexing::newSectionClassificationHtml', compact('secdata'))->render();				
					return ajaxResponse(
						[
							'status'			=>'success',
							'count'      		=> $sectioncount,
							'pubchoicecount'    => $pubchoicecount,
							
							'message' 			=> langapp('saved_successfully'),
						],
						true,
						Response::HTTP_OK
					);		
				}
			
		} else if($request->jobdatayestoall == '0'){

			//print_r($_POST);
			$indexersection 		= implode(',',$request->indexer_section);
			$WherematchThese 		= ['user_id' => \Auth::id(), 'pui' => $request->pui, 'jobid' => $request->jobid, 'orderid' => $request->orderid];
			$findsectiondata 		= DB::table('datasections')->select('sectionval')->whereIn('sectionval',$request->indexer_section)->where($WherematchThese)->get()->toArray();
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
					$html = '';
				 	foreach($request->indexer_section as $key => $sectionval){
					  $data =[
								'jobid' 		=> $request->jobid, 
								'orderid' 		=> $request->orderid,
								'pui' 			=> $request->pui,
								'user_id' 		=> \Auth::id(),
								'sectionval' 	=> $sectionval, 							
								'status' 		=> '1',
								'created_at' 	=> date('Y-m-d H:i:s'),
							   ];   
						
						$InsertedID = DB::table('datasections')->insert($data);
						$last_id 	= DB::getPDO()->lastInsertId();	 
						$secdata 	= DB::table('datasections')->where('id', $last_id)->get()->toArray();
						//DB::enableQueryLog();
						//$secdata 	= DB::table('datasections')->join('embaseindex_sections', 'datasections.sectionid', '=', 'embaseindex_sections.id')
						//->select('datasections.*', 'embaseindex_sections.sectionvalue')->where('datasections.user_id', \Auth::id())->where('datasections.jobid', $request->jobid)->where('datasections.orderid', $request->orderid)->where('datasections.pui', $request->pui)->where('datasections.id', $last_id)->get()->toArray();
						//dd(DB::getQueryLog());
						
						
						
						
						if ($this->request->has('json')) {
							$html.= view('indexing::newSectionHtml', compact('secdata'))->render();
						}  
				    }
					
					$conditionValues	= ['user_id' => \Auth::id(), 'pui' => $request->pui, 'jobid' => $request->jobid, 'orderid' => $request->orderid];
					$sectioncount 		= DB::table('datasections')->where($conditionValues)->count();
					
					
					//$InsertedID = DB::table('datasections')->insert($data);
					//$last_id 	= DB::getPDO()->lastInsertId();
					
					if ($this->request->has('json')) {
						return ajaxResponse(
							[
								'status'		=>'success',
								'count'      	=> $sectioncount,
								'html' 			=> $html,
								'message' 		=> langapp('saved_successfully'),
							],
							true,
							Response::HTTP_OK
						);
					
					}
					
					
					
					return ajaxResponse(
						[
							'count'      	=> $sectioncount,
							'message' 		=> langapp('saved_successfully'),
						],
					true,
					Response::HTTP_OK
					);
				}
			} else {
					return ajaxResponse(
						[
							'count'      => count($totalsectiondata),
							'message'    => langapp('sectionallow'),
						],
					false,
					Response::HTTP_OK
					);
			}
		}
    }
	
	
	/**
     * Save new Medical Term
     */
    public function savemedical(CreateMedicalRequest $request){
		
	

		if($request->medicaltermindexing !=''){
			$matchThese 	= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'pui' => $request->pui, 'orderid' => $request->orderid];
			if($request->medicalid == '0'){	
				$medicaldata	= DB::table('index_medical_term')->select('medicalterm as term')->where($matchThese)->get()->toArray();
			} else {
				$medicaldata	= DB::table('index_medical_term')->select('medicalterm as term')->where($matchThese)->where('id', '!=', $request->medicalid)->get()->toArray();
			}
			
			$checktagdata	= DB::table('index_medical_checktag')->select('checktag as term')->where($matchThese)->get()->toArray();
			
			//$arraycheck		= array_merge($medicaldata,$checktagdata);
			$arraycheck =  (array) array_merge((array) $medicaldata, (array) $checktagdata); 
			$json  = json_encode($arraycheck);
			$arraycheck = json_decode($json, true);
			$arraycheck = array_column($arraycheck, 'term');
		
			$matchThese 		= ['user_id' => \Auth::id(), 'type' => 'major', 'jobid' => $request->jobid, 'pui' => $request->pui, 'orderid' => $request->orderid];
			$medicalmajorcount	= DB::table('index_medical_term')->where($matchThese)->count();
			
			switch ($request->medicaltermindexing) {
			  case "1":
					if($medicalmajorcount < 6 ){
						if (in_array($request->txtmedicalterm, $arraycheck)) {
							return ajaxResponse(
								[
									'count'      => $medicalmajorcount,
									'message' 	 => '"'.$request->txtmedicalterm.'" already assigned to medical term',
								],
							false,
							Response::HTTP_OK
							);
						} else {
							if(!empty($request->indexer_diseaseslink) && $request->txtmedicaltermtype !='MED'){
								$diseaseslink = implode(',',@$request->indexer_diseaseslink);
							} else {
								$diseaseslink = 'Null';
							}
							$data =[
									'jobid' 		=> $request->jobid, 
									'orderid' 		=> $request->orderid,
									'pui' 			=> $request->pui,
									'user_id' 		=> \Auth::id(),
									'type' 			=> 'major',
									'termcategory' 	=> 'medicalterm',
									'termtype' 		=> $request->txtmedicaltermtype,		
									'medicalterm' 	=> $request->txtmedicalterm,
									'diseaseslink' 	=> $diseaseslink,
									'status' 		=> '1', 		
									'modified_at' 	=> date('Y-m-d H:i:s'),
								   ];  
								   
						if($request->medicalid == '0'){	   
							$InsertedID = DB::table('index_medical_term')->insert($data);
							$last_id 	= DB::getPDO()->lastInsertId();
							
						} else {
							DB::table('index_medical_term')->where('id',$request->medicalid)->update($data);
							$last_id 	= $request->medicalid;
						}
					  }
					} else {
						return ajaxResponse(
							[
								'count'      => $medicalmajorcount,
								'message'    => 'Maximum 6 major medical terms allowed!!',
							],
						false,
						Response::HTTP_OK
						);
					}
				break;
			  case "2":
					if (in_array($request->txtmedicalterm, $arraycheck)) {
						return ajaxResponse(
							[
								'count'      => $medicalmajorcount,
								'message' 	 => '"'.$request->txtmedicalterm.'" already assigned to medical term',
							],
						false,
						Response::HTTP_OK
						);
					} else {
						if(!empty($request->indexer_diseaseslink) && $request->txtmedicaltermtype !='MED'){
							$diseaseslink = implode(',',@$request->indexer_diseaseslink);
						} else {
							$diseaseslink = 'Null';
						}
						$data =[
								'jobid' 		=> $request->jobid, 
								'orderid' 		=> $request->orderid,
								'pui' 			=> $request->pui,
								'user_id' 		=> \Auth::id(),
								'type' 			=> 'minor',
								'termcategory' 	=> 'medicalterm',
								'termtype' 		=> $request->txtmedicaltermtype,		
								'medicalterm' 	=> $request->txtmedicalterm,
								'diseaseslink' 	=> $diseaseslink,
								'status' 		=> '1', 		
								'created_at' 	=> date('Y-m-d H:i:s'),
							   ];   
						if($request->medicalid == '0'){	   
							$InsertedID = DB::table('index_medical_term')->insert($data);
							$last_id 	= DB::getPDO()->lastInsertId();
							
						} else {
							DB::table('index_medical_term')->where('id',$request->medicalid)->update($data);
							$last_id 	= $request->medicalid;
						}
					}
				break;
			  case "3":
				if($medicalmajorcount < 6 ){
						if (in_array($request->txtmedicalterm, $arraycheck)) {
							return ajaxResponse(
								[
									'count'      => $medicalmajorcount,
									'message' 	 => '"'.$request->txtmedicalterm.'" already assigned to medical term',
								],
							false,
							Response::HTTP_OK
							);
						} else {
							if(!empty($request->indexer_diseaseslink) && $request->txtmedicaltermtype !='MED'){
								$diseaseslink = implode(',',@$request->indexer_diseaseslink);
							} else {
								$diseaseslink = 'Null';
							}
							$data =[
									'jobid' 		=> $request->jobid, 
									'orderid' 		=> $request->orderid,
									'pui' 			=> $request->pui,
									'user_id' 		=> \Auth::id(),
									'type' 			=> 'major',
									'termcategory' 	=> 'candidateterm',
									'termtype' 		=> 'CAN',		
									'medicalterm' 	=> $request->txtmedicalterm,
									'diseaseslink' 	=> $diseaseslink,
									'status' 		=> '1', 		
									'created_at' 	=> date('Y-m-d H:i:s'),
								   ];   
							if($request->medicalid == '0'){	   
								$InsertedID = DB::table('index_medical_term')->insert($data);
								$last_id 	= DB::getPDO()->lastInsertId();
								
							} else {
								DB::table('index_medical_term')->where('id',$request->medicalid)->update($data);
								$last_id 	= $request->medicalid;
							}
							
							
						}
					} else {
						return ajaxResponse(
							[
								'count'      => $medicalmajorcount,
								'message'    => 'Maximum 6 major medical terms allowed!!',
							],
						false,
						Response::HTTP_OK
						);
					}
				break;
			  case "4":
					if (in_array($request->txtmedicalterm, $arraycheck)) {
						return ajaxResponse(
							[
								'count'      => $medicalmajorcount,
								'message' 	 => '"'.$request->txtmedicalterm.'" already assigned to medical term',
							],
						false,
						Response::HTTP_OK
						);
					} else {
						if(!empty($request->indexer_diseaseslink) && $request->txtmedicaltermtype !='MED'){
							$diseaseslink = implode(',',@$request->indexer_diseaseslink);
						} else {
							$diseaseslink = 'Null';
						}
						$data =[
								'jobid' 		=> $request->jobid, 
								'orderid' 		=> $request->orderid,
								'pui' 			=> $request->pui,
								'user_id' 		=> \Auth::id(),
								'type' 			=> 'minor',
								'termcategory' 	=> 'candidateterm',
								'termtype' 		=> 'CAN',		
								'medicalterm' 	=> $request->txtmedicalterm,
								'diseaseslink' 	=> $diseaseslink,
								'status' 		=> '1', 		
								'created_at' 	=> date('Y-m-d H:i:s'),
							   ];   
						if($request->medicalid == '0'){	   
							$InsertedID = DB::table('index_medical_term')->insert($data);
							$last_id 	= DB::getPDO()->lastInsertId();
							
						} else {
							DB::table('index_medical_term')->where('id',$request->medicalid)->update($data);
							$last_id 	= $request->medicalid;
						}
						
						
					}
				break;
			  case "5":
				if($medicalmajorcount < 6 ){
						if (in_array($request->txtmedicalterm, $arraycheck)) {
							return ajaxResponse(
								[
									'count'      => $medicalmajorcount,
									'message' 	 => '"'.$request->txtmedicalterm.'" already assigned to medical term',
								],
							false,
							Response::HTTP_OK
							);
						} else {
							if(!empty($request->indexer_diseaseslink) && $request->txtmedicaltermtype !='MED'){
								$diseaseslink = implode(',',@$request->indexer_diseaseslink);
							} else {
								$diseaseslink = 'Null';
							}
							$data =[
									'jobid' 		=> $request->jobid, 
									'orderid' 		=> $request->orderid,
									'pui' 			=> $request->pui,
									'user_id' 		=> \Auth::id(),
									'type' 			=> 'major',
									'termcategory' 	=> 'diseaseterm',
									'termtype' 		=> 'CAN',		
									'medicalterm' 	=> $request->txtmedicalterm,
									'diseaseslink' 	=> $diseaseslink,
									'status' 		=> '1', 		
									'created_at' 	=> date('Y-m-d H:i:s'),
								   ];   
							if($request->medicalid == '0'){	   
								$InsertedID = DB::table('index_medical_term')->insert($data);
								$last_id 	= DB::getPDO()->lastInsertId();
								
							} else {
								DB::table('index_medical_term')->where('id',$request->medicalid)->update($data);
								$last_id 	= $request->medicalid;
							}
							
							
							
							
						}
					} else {
						return ajaxResponse(
							[
								'count'      => $medicalmajorcount,
								'message'    => 'Maximum 6 major medical terms allowed!!',
							],
						false,
						Response::HTTP_OK
						);
					}
				break;
			  case "6":
				if (in_array($request->txtmedicalterm, $arraycheck)) {
					return ajaxResponse(
						[
							'count'      => $medicalmajorcount,
							'message' 	 => '"'.$request->txtmedicalterm.'" already assigned to medical term',
						],
					false,
					Response::HTTP_OK
					);
				} else {
					if(!empty($request->indexer_diseaseslink) && $request->txtmedicaltermtype !='MED'){
						$diseaseslink = implode(',',@$request->indexer_diseaseslink);
					} else {
						$diseaseslink = 'Null';
					}
					$data =[
							'jobid' 		=> $request->jobid, 
							'orderid' 		=> $request->orderid,
							'pui' 			=> $request->pui,
							'user_id' 		=> \Auth::id(),
							'type' 			=> 'minor',
							'termcategory' 	=> 'diseaseterm',
							'termtype' 		=> 'CAN',		
							'medicalterm' 	=> $request->txtmedicalterm,
							'diseaseslink' 	=> $diseaseslink,
							'status' 		=> '1', 		
							'created_at' 	=> date('Y-m-d H:i:s'),
						   ];   
					if($request->medicalid == '0'){	   
						$InsertedID = DB::table('index_medical_term')->insert($data);
						$last_id 	= DB::getPDO()->lastInsertId();
						
					} else {
						DB::table('index_medical_term')->where('id',$request->medicalid)->update($data);
						$last_id 	= $request->medicalid;
					}
				}
				break;
			}
		}
		
		
			if($request->hide_mmtct == 'TRUE'){
				foreach($request->medicalchecktags as $key => $checktags){
						$data =[
								'jobid' 		=> $request->jobid, 
								'orderid' 		=> $request->orderid,
								'pui' 			=> $request->pui,
								'user_id' 		=> \Auth::id(),
								'checktag' 		=> $checktags, 							
								'status' 		=> '1',
								'created_at' 	=> date('Y-m-d H:i:s'),
							   ];   
				
				
				
						if($request->medicalid == '0'){	   
							$checktags_last_id 	=	DB::table('index_medical_checktag')->insert($data);
							$last_id 			= 	DB::getPDO()->lastInsertId();	
							$checktagdata[]		= 	DB::table('index_medical_checktag')->where('id', $last_id)->get()->toArray();
							
						} else {
							DB::table('index_medical_checktag')->where('id',$request->medicalid)->update($data);
							$last_id 	= $request->medicalid;
							$checktagdata[]		= 	DB::table('index_medical_checktag')->where('id', $last_id)->get()->toArray();
						}

				
				
				}
			}
		
		
			
			$matchThese 		= ['user_id' => \Auth::id(), 'type' => 'major', 'jobid' => $request->jobid, 'pui' => $request->pui, 'orderid' => $request->orderid];
			$medicalmajorcount	= DB::table('index_medical_term')->where($matchThese)->count();
			
			
			//Last Inserted Data
			$medicaltermdata 		= DB::table('index_medical_term')->where('id', $last_id)->get()->toArray();
			
			//Total count of data
			$matchThese 			= ['user_id' => \Auth::id(), 'pui' => $request->pui, 'jobid' => $request->jobid, 'orderid' => $request->orderid];
			$medicaltermtypecount 	= DB::table('index_medical_term')->select('type', DB::raw('count(*) as total'))->where($matchThese)->groupBy('type')->pluck('total','type')->all();
			
			
			$checktagdata 			= DB::table('index_medical_checktag')->where($matchThese)->get()->toArray();
			
			$diseasescount 			= DB::table('index_medical_term')->select(DB::raw("(CHAR_LENGTH(diseaseslink) - CHAR_LENGTH(REPLACE(diseaseslink, ',', '')) + 1) as TotalValue"))->where($matchThese)->where('diseaseslink', '<>', 'Null')->get()->toArray();
			
			$totaldiseasescnt = 0;
			foreach($diseasescount as $cntval){
			   $totaldiseasescnt = $totaldiseasescnt + $cntval->TotalValue;
			}
	
			$medicaldata = array();
			foreach($medicaltermdata as $termgroup){
			   $medicaldata[$termgroup->type][] = $termgroup;
			}
			
			$data['checktagdata']   		= @$checktagdata;
			$data['medicaltermdata']   		= $medicaltermdata;
			$data['type']   				= $request->medicaltermindexing;	
			
		
				
			$majorcount 					= @$medicaltermtypecount['major'];	
			$minorcount 					= @$medicaltermtypecount['minor'];
			$checktagscount 				= count($checktagdata);
			$totalmedcountterm				= @$medicaltermtypecount['major'] + @$medicaltermtypecount['minor'] + @$checktagscount;
			
			
			
			if ($this->request->has('json')) {
			
				$htmlmedicalterm	= view('indexing::indexmedial.newMedicalHtml', compact('data'))->render();
				$htmldiseases		= view('indexing::indexmedial.newMedicaldiseasesHtml', compact('data'))->render();
				$htmlchecktag		= view('indexing::indexmedial.newMedicalchecktagHtml', compact('data'))->render();
				
				if($request->medicalid == '0'){	   
					$recordstatus = 'insert';
				} else {
					$recordstatus = 'update';
				}
				
				return ajaxResponse(
							['status' =>'success', 'recordstatus' =>$recordstatus, 'type' => $request->medicaltermindexing,  'totalmedcountterm' => $totalmedcountterm, 'diseasescount' => $totaldiseasescnt, 'minorcount' => $minorcount,'majorcount' => $majorcount,'checktagcount' => $checktagscount, 'htmlchecktag' =>$htmlchecktag, 'htmlmedicalterm' =>$htmlmedicalterm, 'htmldiseases' =>$htmldiseases, 'message' => langapp('saved_successfully')],
						true,
						Response::HTTP_OK
						);
				
			}
	}
	
	/**
     * Save new indexing
    */
	public function savectn(CreateCtnRequest $request)
    {
		$data =[
				'jobid' 		=> $request->jobid, 
				'orderid' 		=> $request->orderid,
				'pui' 			=> $request->pui,
				'user_id' 		=> \Auth::id(),
				'registryname' 	=> $request->registryname,		
				'trailnumber' 	=> $request->clinicaltrailnumber,
				'status' 		=> '1', 		
				'created_at' 	=> date('Y-m-d H:i:s'),
			   ];   
		$InsertedID = DB::table('ctn')->insert($data);
		$last_id 	= DB::getPDO()->lastInsertId();	
		
		
		//Last Inserted Data 			
		$data['ctntermdata'] 		= DB::table('ctn')->where('id', $last_id)->get()->toArray();
			
			
		if ($this->request->has('json')) {
				$htmlctnterm	= view('indexing::indexctn.newTrailnumberHtml', compact('data'))->render();
				return response()->json(['status' =>'success',  'htmlctnterm' =>$htmlctnterm, 'message' => langapp('saved_successfully')], Response::HTTP_OK);
		} 
		
		 return ajaxResponse(
            [
                'id'       => $last_id,
                'message'  => langapp('saved_successfully'),
            ],
            true,
            Response::HTTP_CREATED
        );
			
	
	}
	
	/**
     * Delete a indexing
     */
    public function deletectn($id = null)
    {
		DB::table('ctn')->where('id', $id)->delete();
		
		
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
     * Delete a indexing
     */
    public function drugtrademanufacture($id = null)
    {
		DB::table('drugtradename')->where('id', $id)->delete();
		
		
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
     * Delete a indexing
     */
    public function deletemedicaldevicetradename($id = null)
    {
		DB::table('devicetradename')->where('id', $id)->delete();
		
		
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
     * Delete a indexing
     */
    public function deletedrugtradename($id = null, $value = null)
    {
		
		$tradelist 		= 	DB::table('drugtradename')->where('id', $id)->get()->toArray();
		$explodedata 	=  	explode(',',$tradelist[0]->tradename);
		$to_remove[] = $value;
		$result = array_diff($explodedata, $to_remove);
		$tradenamedata = implode(',',$result);
		DB::table('drugtradename')->where('id', $id)->update(['tradename' => $tradenamedata]);
		
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
	public function terms()
	{
		$term		=	$this->request->searchterm;
		
		if($this->request->searchtype == 'medical'){
		$termdata 	= 	DB::table('terms')->whereIn('term_type', array('MED','DIS'))->where('term_name', 'like', ''.$term.'%')->take(10)->get();
		}
		$output 	= 	'<ul id="termList">'; 	
		foreach($termdata as $termval){
			$output .=	'<li onClick="selectedTerms(\''.$termval->term_name.'\',\''.$termval->term_type.'\')">'.$termval->term_name.' <span class="btn-warning btn-xs pull-right">['.$termval->term_type.']</span></li>';
			
			
		}
		$output .= '</ul>';  
		return response($output, Response::HTTP_OK);	
	}
	
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function termemtree()
	{
		$term		=	$this->request->searchterm;
		//$termdata 	= 	DB::table('terms')->where('term_name', 'like', ''.$term.'%')->take(25)->get();
		
		
		//SELECT A.synonym_name, B.term_name FROM `tbl_synonyms` A, tbl_terms b WHERE A. `synonym_name` LIKE 'fever%' And A. mainterm_id = B.term_id
		
		//print "SELECT A.synonym_name, B.term_name, B.term_type FROM `tbl_synonyms` A, tbl_terms b WHERE A. `synonym_name` LIKE '".$term."%' And A. mainterm_id = B.term_id";
		//print '<br />';
		$termdata_level_1 = DB::select("SELECT A.synonym_name, B.term_name, B.term_type FROM `tbl_synonyms` A, tbl_terms b WHERE A. `synonym_name` LIKE '".$term."%' And A. mainterm_id = B.term_id limit 10");
		
		$termdata_level_2 = DB::select("SELECT term_name, term_type FROM tbl_terms WHERE `term_name` LIKE '".$term."%' limit 10");
		
		$termdata = array_merge($termdata_level_2, $termdata_level_1);
		
		
		
		
		$output 	= 	'<ul id="termList">'; 	
		foreach($termdata as $termval){
		
		if(@$termval->synonym_name !=''){
			$output .=	'<li onClick="selectedTerms(\''.$termval->term_name.'\',\''.$termval->term_type.'\')"><em><div>'.$termval->synonym_name.'</div> </em>use: '.$termval->term_name.'</li>';
			} else {
			$output .=	'<li onClick="selectedTerms(\''.$termval->term_name.'\',\''.$termval->term_type.'\')"><div>'.$termval->term_name.'</li>';
			
			}
			
			
			
			
		}
		$output .= '</ul>';  
		return response($output, Response::HTTP_OK);	
	}
	
	
	
	
	public function emtreefindterm(CreateMedicalRequest $request){
			
			if($request->selectterm !='null'){
			 $selectedterms =  $request->selectterm;
				
			$termdata_level_1 = DB::select("SELECT A.synonym_name, B.term_name, B.term_type FROM `tbl_synonyms` A, tbl_terms b WHERE A. `synonym_name` LIKE '%".$selectedterms."%' And A. mainterm_id = B.term_id");
		
		$termdata_level_2 = DB::select("SELECT term_name, term_type FROM tbl_terms WHERE `term_name` LIKE '%".$selectedterms."%' ");
		
		$termdata = array_merge($termdata_level_1, $termdata_level_2);	
		array_multisort(array_column($termdata, 'term_name'), SORT_ASC, $termdata);
		
		$output = '<ul class="list-group">';
		foreach($termdata as $termval){
			if(@$termval->synonym_name !=''){
				$output .= '<li class="list-group-item">'.$termval->synonym_name.'<div><em> use preferred term:  </em><a href="#" style="text-decoration:underline; color:#166ada;" onClick="selectedTerms(\''.$termval->term_name.'\',\''.$termval->term_type.'\')">'.$termval->term_name.'</a></div></li>';
			} else {
				$output .= '<li class="list-group-item"><a href="#" style="text-decoration:underline; color:#166ada;" onClick="selectedTerms(\''.$termval->term_name.'\',\''.$termval->term_type.'\')">'.$termval->term_name.'</a></li>';
			}
		}
		$output .= '</ul>';
	}
			
		return ajaxResponse(
            [
                'message'  			=> $output,
            ],
            true,
            Response::HTTP_OK
        );
	
	}
	
	
	
	
	
	public function buildMarkupListTree($aData)
	{
	
	
		if (false === is_array($aData))
		{
			return '';
		}
		$sMarkup = '<ul>';
		foreach ($aData['Nodes'] as $sKey => $mValue)
		{
			
			switch ($mValue['TermType']) {
			  case "DRG":
				$lbl	=	"label-danger";
				$icon			= 	getAsset('images/drug.png');
				break;
			  case "MED":
				$lbl	=	"label-primary";
				$icon			= 	getAsset('images/medicine.png');
				break;
			  case "DIS":
				$lbl	=	"label-danger";
				$icon			= 	getAsset('images/disease.png');
				break;
			  case "MDV":
				$lbl	=	"label-info";
				$icon			= 	getAsset('images/medicine.png');
				break;
			  default:
				$lbl	=	"label-warning";
				$icon			= 	getAsset('images/checktag.png');
			}
		
		
			$sMarkup.= '<li data-jstree={"icon":"'.$icon.'"} title="'.$mValue['TermType'].'"><span onClick="selectedTerms(\''.trim($mValue['Term']).'\',\''.trim($mValue['Term']).'\')" >' . trim($mValue['Term']).'<span style="display:none;">'.$mValue['Term'].'</span></span>';
			if (is_array($mValue))
			{
				$sMarkup.= $this->buildMarkupListTree($mValue);
			}
			else
			{
				$sMarkup.= $mValue;
			}
			$sMarkup.= '</li>';
		}
		$sMarkup.= '</ul>';
		return $sMarkup;
	}
	
	public function callapiemtree(){
		$term			=	rawurlencode($this->request->selectterm);
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://localhost:5000/api/emtreegeneration/generateemtree?SearchTerm=".$term,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_HTTPHEADER => array(
									'Content-Type: application/json',
									'Connection: Keep-Alive',
									'Accept: application/json',
									'Content-Length: 0',
									),
		));
		$output = curl_exec($curl);
		curl_close($curl);
		
		$jsondecoded['Nodes'] = json_decode($output,true);
		
		
		
		$output = $this->buildMarkupListTree($jsondecoded);
		return ajaxResponse(
				[
					'message' => $output,
				],
			false,
			Response::HTTP_OK
			);
		
		
		
	
	}
	
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function termdrug()
	{
		$term		=	$this->request->searchterm;
		
		//DB::enableQueryLog();
						
						
		$termdata 	= 	DB::table('terms')->where('term_type','=','DRG')->where('term_name', 'like', ''.$term.'%')->take(10)->get();
		//dd(DB::getQueryLog());
		$output 	= 	'<ul id="termList">'; 	
		foreach($termdata as $termval){
			$output .=	'<li onClick="selectedTerms(\''.$termval->term_name.'\',\''.$termval->term_type.'\')">'.$termval->term_name.' <span class="btn-warning btn-xs pull-right">['.$termval->term_type.']</span></li>';
			
			
		}
		$output .= '</ul>';  
		return response($output, Response::HTTP_OK);	
	}
	
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function termdevice()
	{
		$term		=	$this->request->searchterm;
		$termdata 	= 	DB::table('terms')->where('term_type','=','MDV')->where('term_name', 'like', ''.$term.'%')->take(10)->get();
		$output 	= 	'<ul id="termList">'; 	
		foreach($termdata as $termval){
			$output .=	'<li onClick="selectedTerms(\''.$termval->term_name.'\',\''.$termval->term_type.'\')">'.$termval->term_name.' <span class="btn-warning btn-xs pull-right">['.$termval->term_type.']</span></li>';
		}
		$output .= '</ul>';  
		return response($output, Response::HTTP_OK);	
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function termemmans()
	{
		$term		=	$this->request->searchterm;
		$termdata 	= 	DB::table('manufacturer')->where('manufacturer', 'like', ''.$term.'%')->take(10)->get();
		$output 	= 	'<ul id="termList">'; 	
		foreach($termdata as $termval){
			if($termval->synonym_IDs!=''){
			   $output .=	'<label class="btn-info" style="width:100%; margin:0px!important;padding:5px;">'.$termval->manufacturer.'</label>';
			   $synonymterms = 	$results = DB::select('select * from tbl_manufacturer_synonym where id IN ('.$termval->synonym_IDs.') ');
				foreach($synonymterms as $synonyms){
					$output .=	'<li onClick="selectedemmansTerms(\''.$synonyms->synonym.'\')">'.$synonyms->type.' : '.$synonyms->synonym.'</li>';
				}
			} else {
				$output .=	'<label class="btn-info" style="width:100%; margin:0px!important; padding:5px;">'.$termval->manufacturer.'</label>';
				$output .=	'<li onClick="selectedemmansTerms(\''.$termval->manufacturer.'\')">'.$termval->manufacturer.'</li>';
			}
			
		}
		$output .= '</ul>'; 
		return response($output, Response::HTTP_OK);
	}
	
		/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function termcountry()
	{
		$term		=	$this->request->searchterm;
		
		$termdata 	= 	DB::table('countries')->where('name', 'like', ''.$term.'%')->take(20)->get();
		//dd(DB::getQueryLog());
		$output 	= 	'<ul id="termList">'; 	
		foreach($termdata as $termval){
			$name 	 = $termval->name.'|'.$termval->code;
			$output .=	'<li onClick="selectedCountry(\''.$name.'\')">'.$termval->name.'</li>';
			
			
		}
		$output .= '</ul>';  
		return response($output, Response::HTTP_OK);
	}

	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function classification()
    {
		$output = '';
		if($this->request->id!=''){
			$classification = DB::table('embaseindex_classifications')->where('section_id', $this->request->id)->get();
			foreach($classification as $classval){
				$output .=	'<option value="'.$classval->classvalue.'">'.$classval->classvalue.'</option>';
			}
		}
		
        /*$indexing     = $this->indexing->findOrFail($id);
        $comments = new CommentsResource($indexing->comments()->orderBy('id', 'desc')->paginate(50));
        return response($comments, Response::HTTP_OK);*/
		return response($output, Response::HTTP_OK);
    }
	
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getclassificationdetails()
    {
		$output = '';
		if($this->request->id!=''){
			$classification = DB::table('datasections')->where('id', $this->request->id)->get();
			$html			= view('indexing::ajaxClassificationHtml', compact('classification'))->render();
			return response()->json(['status' =>'success', 'html' =>$html,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
		}
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getmedicaldiseasesdetails()
    {
		$output = '';
		if($this->request->id!=''){
			$diseases = DB::table('index_medical_term')->where('id', $this->request->id)->get();
			$html	  = view('indexing::indexmedial.ajaxMedicalHtml', compact('diseases'))->render();
			return response()->json(['status' =>'success', 'html' =>$html,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
		}
    }
	
	
	
	
	 /**
	 * Delete a indexing
	 */
	public function sectiondeleteall()
	{
			$id =  $this->request->id;
			DB::table('datasections')->whereIn('id', $id)->delete();
	
	
			$conditionValues	= ['user_id' => \Auth::id(), 'pui' => $this->request->pui, 'jobid' => $this->request->jobid, 'orderid' => $this->request->orderid];
			$sectioncount 		= DB::table('datasections')->where($conditionValues)->count();
			
			$conditionValues	= ['user_id' => \Auth::id(), 'pubchoice' => '+', 'pui' => $this->request->pui, 'jobid' => $this->request->jobid, 'orderid' => $this->request->orderid];
			$pubchoicecount 	= DB::table('datasections')->where($conditionValues)->count();
			return ajaxResponse(
			[
				'status'			=>'success',
				'count'      		=> $sectioncount,
				'pubchoicecount'    => $pubchoicecount,
				'message' 			=> langapp('deleted_successfully'),
			],
			true,
			Response::HTTP_OK
			);
	}

	
	 /**
	 * Delete a indexing
	 */
	public function deletesection($id = null)
	{
		$getsection 		= DB::table('datasections')->where('id', $id)->get();
		DB::table('datasections')->where('id', $id)->delete();
		
	
	
	
	
			$conditionValues	= ['user_id' => \Auth::id(), 'pui' => $getsection[0]->pui, 'jobid' => $getsection[0]->jobid, 'orderid' => $getsection[0]->orderid];
			$sectioncount 		= DB::table('datasections')->where($conditionValues)->count();
			
			$conditionValues	= ['user_id' => \Auth::id(), 'pubchoice' => '+', 'pui' => $getsection[0]->pui, 'jobid' => $getsection[0]->jobid, 'orderid' => $getsection[0]->orderid];
			$pubchoicecount 	= DB::table('datasections')->where($conditionValues)->count();
			
			//$InsertedID = DB::table('datasections')->insert($data);
			//$last_id 	= DB::getPDO()->lastInsertId();
			
			
			return ajaxResponse(
			[
				'status'			=>'success',
				'count'      		=> $sectioncount,
				'pubchoicecount'    => $pubchoicecount,
				'message' 			=> langapp('deleted_successfully'),
			],
			true,
			Response::HTTP_OK
			);
	}
	
	
	 /**
     * Delete a indexing
     */
    public function deleteClassification(CreateMedicalRequest $request)
    {
		$classification = DB::table('datasections')->where('id', $this->request->id)->get();
		$classval = explode('|||',$classification[0]->classificationval);
		
		if (($key = array_search($this->request->data, $classval)) !== false) {
			unset($classval[$key]);
		}
		$classval = implode('|||',$classval);
		DB::table('datasections')->where('id', $request->id)->update(['classificationval' => $classval]);
		
		$classification = DB::table('datasections')->where('id', $this->request->id)->get();
		$html			= view('indexing::ajaxClassificationHtml', compact('classification'))->render();
		return response()->json(['status' =>'success', 'html' =>$html,  'message' => langapp('deleted_successfully')], Response::HTTP_OK);

    }
	
	/**
     * Delete a indexing
     */
    public function deletediseases(CreateMedicalRequest $request)
    {
		$medical = DB::table('index_medical_term')->where('id', $this->request->id)->get();
		$diseaseval = explode(',',$medical[0]->diseaseslink);
		
		if (($key = array_search($this->request->data, $diseaseval)) !== false) {
			unset($diseaseval[$key]);
		}
		$diseaseval = implode(',',$diseaseval);
		DB::table('index_medical_term')->where('id', $request->id)->update(['diseaseslink' => $diseaseval]);
		
		$diseases = DB::table('index_medical_term')->where('id', $this->request->id)->get();
		$html	  = view('indexing::indexmedial.ajaxMedicalHtml', compact('diseases'))->render();
		return response()->json(['status' =>'success', 'html' =>$html,  'message' => langapp('deleted_successfully')], Response::HTTP_OK);

    }
	
	
	 /**
     * Delete a indexing
     */
    public function deletemedical($id = null,$jobid = null,$orderid = null)
    {
		$getmedical	= DB::table('index_medical_term')->where('id', $id)->get();
		DB::table('index_medical_term')->where('id', $id)->delete();
		
		//Total count of data
		
		$matchThese 			= ['user_id' => \Auth::id(), 'pui' => $getmedical[0]->pui, 'jobid' => $getmedical[0]->jobid, 'orderid' => $getmedical[0]->orderid];
		$medicaltermtypecount 	= DB::table('index_medical_term')->select('type', DB::raw('count(*) as total'))->where($matchThese)->groupBy('type')->pluck('total','type')->all();
		
		$checktagcount 			= DB::table('index_medical_checktag')->where($matchThese)->get()->toArray();
		
		$diseasescount 			= DB::table('index_medical_term')->select(DB::raw("(CHAR_LENGTH(diseaseslink) - CHAR_LENGTH(REPLACE(diseaseslink, ',', '')) + 1) as TotalValue"))->where($matchThese)->where('diseaseslink', '<>', 'Null')->get()->toArray();
		$totaldiseasescnt = 0;
		foreach($diseasescount as $cntval){
		   $totaldiseasescnt = $totaldiseasescnt + $cntval->TotalValue;
		}

		$majorcount 					= @$medicaltermtypecount['major'];	
		$minorcount 					= @$medicaltermtypecount['minor'];
		$checktagscount 				= count($checktagcount);
		$totalmedcountterm				= @$medicaltermtypecount['major'] + @$medicaltermtypecount['minor'] + @$checktagscount;
		
        return ajaxResponse(
            [
                'message'  			=> langapp('deleted_successfully'),
				'majorcount' 		=> $majorcount,
				'minorcount'  		=> $minorcount,
				'checktagscount'  	=> $checktagscount,
				'totalmedcountterm' => $totalmedcountterm,
				'totaldiseasecount' => $totaldiseasescnt,
                'redirect' 			=> route('indexing.index'),
            ],
            true,
            Response::HTTP_OK
        );
    }
	
	 /**
     * Delete a indexing
     */
    public function deletemedicalchecktag($id = null,$jobid = null,$orderid = null)
    {
		
		$getchecktag		=	DB::table('index_medical_checktag')->where('id', $id)->get();
		DB::table('index_medical_checktag')->where('id', $id)->delete();
		
		//Total count of data
		$matchThese	= ['user_id' => \Auth::id(), 'pui' => $getchecktag[0]->pui, 'jobid' => $getchecktag[0]->jobid, 'orderid' => $getchecktag[0]->orderid];
		$medicaltermtypecount 	= DB::table('index_medical_term')->select('type', DB::raw('count(*) as total'))->where($matchThese)->groupBy('type')->pluck('total','type')->all();
		$checktagcount 			= DB::table('index_medical_checktag')->where($matchThese)->get()->toArray();
		
		$diseasescount 			= DB::table('index_medical_term')->select(DB::raw("(CHAR_LENGTH(diseaseslink) - CHAR_LENGTH(REPLACE(diseaseslink, ',', '')) + 1) as TotalValue"))->where($matchThese)->where('diseaseslink', '<>', 'Null')->get()->toArray();
		$totaldiseasescnt = 0;
		foreach($diseasescount as $cntval){
		   $totaldiseasescnt = $totaldiseasescnt + $cntval->TotalValue;
		}

		$majorcount 					= @$medicaltermtypecount['major'];	
		$minorcount 					= @$medicaltermtypecount['minor'];
		$checktagscount 				= count($checktagcount);
		$totalmedcountterm				= @$medicaltermtypecount['major'] + @$medicaltermtypecount['minor'] + @$checktagscount;
		
        return ajaxResponse(
            [
                'message'  			=> langapp('deleted_successfully'),
				'majorcount' 		=> $majorcount,
				'minorcount'  		=> $minorcount,
				'checktagscount'  	=> $checktagscount,
				'totalmedcountterm' => $totalmedcountterm,
				'totaldiseasecount' => $totaldiseasescnt,
                'redirect' 			=> route('indexing.index'),
            ],
            true,
            Response::HTTP_OK
        );
    }
	
	
	
	/**
     * Save new Medical Term
     */
    public function savedrug(CreateMedicalRequest $request){
	
	
	
			if($request->txtdrugterm !=''){
				$matchThese 	= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'pui' => $request->pui, 'orderid' => $request->orderid];
				$arraycheck     = array();
				if($request->drugid == '0'){	
					$drugdata	= DB::table('index_drug')->select('drugterm as term')->where($matchThese)->get()->toArray();
				} else {
					$drugdata	= DB::table('index_drug')->select('drugterm as term')->where($matchThese)->where('id', '!=', $request->drugid)->get()->toArray();
				}
				
				$arraycheck = array_column(@$drugdata, 'term');
				$matchdataThese 	= ['user_id' => \Auth::id(), 'type' => 'major', 'jobid' => $request->jobid, 'pui' => $request->pui, 'orderid' => $request->orderid];
				$drugmajorcount	= DB::table('index_drug')->where($matchdataThese)->count();
				
				
				switch ($request->drugtermindexing) {
				  case "1":
						if($drugmajorcount < 6 ){
							if (in_array($request->txtdrugterm, $arraycheck)) {
								return ajaxResponse(
									[
										'count'      => $drugmajorcount,
										'message' 	 => '"'.$request->txtdrugterm.'" already assigned to drug term',
									],
								false,
								Response::HTTP_OK
								);
							} else {
								$data =[
										'jobid' 		=> $request->jobid, 
										'orderid' 		=> $request->orderid,
										'pui' 			=> $request->pui,
										'user_id' 		=> \Auth::id(),
										'type' 			=> 'major',
										'termcategory' 	=> 'drugterm',
										'termtype' 		=> $request->txtdrugtermtype,		
										'drugterm' 		=> $request->txtdrugterm,
										'status' 		=> '1', 		
										'modified_at' 	=> date('Y-m-d H:i:s'),
									   ]; 
									   
								if($request->drugid == '0'){	   
									$InsertedID = DB::table('index_drug')->insert($data);
									$last_id 	= DB::getPDO()->lastInsertId();
								
								} else {
									DB::table('index_drug')->where('id',$request->drugid)->update($data);
									$last_id 	= $request->drugid;
								}
						  }
						} else {
							return ajaxResponse(
								[
									'count'      => $drugmajorcount,
									'message'    => 'Maximum 6 major drug terms allowed!!',
								],
							false,
							Response::HTTP_OK
							);
						}
					break;
				  case "2":
						if (in_array($request->txtdrugterm, $arraycheck)) {
							return ajaxResponse(
								[
									'count'      => $drugmajorcount,
									'message' 	 => '"'.$request->txtdrugterm.'" already assigned to drug term',
								],
							false,
							Response::HTTP_OK
							);
						} else {
							$data =[
									'jobid' 		=> $request->jobid, 
									'orderid' 		=> $request->orderid,
									'pui' 			=> $request->pui,
									'user_id' 		=> \Auth::id(),
									'type' 			=> 'minor',
									'termcategory' 	=> 'drugterm',
									'termtype' 		=> $request->txtdrugtermtype,		
									'drugterm' 		=> $request->txtdrugterm,
									'status' 		=> '1', 		
									'modified_at' 	=> date('Y-m-d H:i:s'),
								   ]; 
								   
							if($request->drugid == '0'){	   
								$InsertedID = DB::table('index_drug')->insert($data);
								$last_id 	= DB::getPDO()->lastInsertId();
							
							} else {
								DB::table('index_drug')->where('id',$request->drugid)->update($data);
								$last_id 	= $request->drugid;
							}
						}
					break;
				  case "3":
						if($drugmajorcount < 6 ){
							if (in_array($request->txtdrugterm, $arraycheck)) {
								return ajaxResponse(
									[
										'count'      => $drugmajorcount,
										'message' 	 => '"'.$request->txtdrugterm.'" already assigned to drug term',
									],
								false,
								Response::HTTP_OK
								);
							} else {
								$data =[
										'jobid' 		=> $request->jobid, 
										'orderid' 		=> $request->orderid,
										'pui' 			=> $request->pui,
										'user_id' 		=> \Auth::id(),
										'type' 			=> 'major',
										'termcategory' 	=> 'candidateterm',
										'termtype' 		=> 'CAN',		
										'drugterm' 		=> $request->txtdrugterm,
										'status' 		=> '1', 		
										'modified_at' 	=> date('Y-m-d H:i:s'),
									   ]; 
									   
								if($request->drugid == '0'){	   
									$InsertedID = DB::table('index_drug')->insert($data);
									$last_id 	= DB::getPDO()->lastInsertId();
								
								} else {
									DB::table('index_drug')->where('id',$request->drugid)->update($data);
									$last_id 	= $request->drugid;
								}
						  }
						} else {
							return ajaxResponse(
								[
									'count'      => $drugmajorcount,
									'message'    => 'Maximum 6 major drug terms allowed!!',
								],
							false,
							Response::HTTP_OK
							);
						}
					break;
				  case "4":
						if (in_array($request->txtdrugterm, $arraycheck)) {
								return ajaxResponse(
									[
										'count'      => $drugmajorcount,
										'message' 	 => '"'.$request->txtdrugterm.'" already assigned to drug term',
									],
								false,
								Response::HTTP_OK
								);
							} else {
								$data =[
										'jobid' 		=> $request->jobid, 
										'orderid' 		=> $request->orderid,
										'pui' 			=> $request->pui,
										'user_id' 		=> \Auth::id(),
										'type' 			=> 'minor',
										'termcategory' 	=> 'candidateterm',
										'termtype' 		=> 'CAN',		
										'drugterm' 		=> $request->txtdrugterm,
										'status' 		=> '1', 		
										'modified_at' 	=> date('Y-m-d H:i:s'),
									   ]; 
									   
								if($request->drugid == '0'){	   
									$InsertedID = DB::table('index_drug')->insert($data);
									$last_id 	= DB::getPDO()->lastInsertId();
								
								} else {
									DB::table('index_drug')->where('id',$request->drugid)->update($data);
									$last_id 	= $request->drugid;
								}
						}
					break;
				}
			}				
			
			
			
			
				
			//Last Inserted Data 			
			$drugtermdata 		= DB::table('index_drug')->where('id', $last_id)->get()->toArray();
			//Total count of data
			$matchThese 			= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'pui' => $request->pui, 'orderid' => $request->orderid];
			$drugtermtypecount 	= DB::table('index_drug')->select('type', DB::raw('count(*) as total'))->where($matchThese)->groupBy('type')->pluck('total','type')->all();
	
			$drugdata = array();
			foreach($drugtermdata as $termgroup){
			   $drugdata[$termgroup->type][] = $termgroup;
			}
			$data['drugtermdata']   		= $drugtermdata;
			$data['type']   				= $request->drugtermindexing;	
			$majorcount 					= @$drugtermtypecount['major'];	
			$minorcount 					= @$drugtermtypecount['minor'];
			$totaldrugcountterm				= @$drugtermtypecount['major'] + @$drugtermtypecount['minor'];
			
			
				$htmldrugterm	= view('indexing::indexdrug.newDrugHtml', compact('data'))->render();
				if($request->drugid == '0'){	   
					$recordstatus = 'insert';
				} else {
					$recordstatus = 'update';
				}
				
				return ajaxResponse(
					['status' =>'success', 'recordstatus' =>$recordstatus, 'type' => $request->drugtermindexing,  'totaldrugcountterm' => $totaldrugcountterm, 'minorcount' => $minorcount, 'majorcount' => $majorcount,'htmldrugterm' => $htmldrugterm, 'message' => langapp('saved_successfully')],
				true,
				Response::HTTP_OK
				);
				
	}
	
	
	 /**
     * Delete a indexing
     */
    public function deletedrug($id = null,$jobid = null,$orderid = null)
    {
		$getdrug	= DB::table('index_drug')->where('id', $id)->get();
		DB::table('index_drug')->where('id', $id)->delete();

		//Total count of data
		$matchThese 		= ['user_id' => \Auth::id(), 'pui' => $getdrug[0]->pui, 'jobid' => $getdrug[0]->jobid, 'orderid' => $getdrug[0]->orderid];
		$drugtermtypecount 	= DB::table('index_drug')->select('type', DB::raw('count(*) as total'))->where($matchThese)->groupBy('type')->pluck('total','type')->all();
	
		$drugdata = array();
		
		$majorcount 					= @$drugtermtypecount['major'];	
		$minorcount 					= @$drugtermtypecount['minor'];
		$totaldrugcountterm				= @$drugtermtypecount['major'] + @$drugtermtypecount['minor'];
		
        return ajaxResponse(
            [
                'message'  			=> langapp('deleted_successfully'),
				'majorcount' 		=> $majorcount,
				'minorcount'  		=> $minorcount,
				'totaldrug'  		=> $totaldrugcountterm,
                'redirect' 			=> route('indexing.index'),
            ],
            true,
            Response::HTTP_OK
        );
    }
	
	
	 public function savedrugtradename(CreateMedicalRequest $request){
	 
			if($request->termDTNindexing == '1' && $request->id =='0'){
					$data =[
						'jobid' 			=> $request->jobid, 
						'orderid' 			=> $request->orderid,
						'pui' 				=> $request->pui,
						'user_id' 			=> \Auth::id(),
						'type' 				=> 'ma',
						'countrycode' 		=> $request->txtcountrycode,		
						'manufacturename' 	=> $request->txtdrugmanufacturename,
						'tradename' 		=> implode(',',@$request->txtdrugtradename),
						'status' 			=> '1', 		
						'created_at' 		=> date('Y-m-d H:i:s'),
					   ];   
					$InsertedID = DB::table('drugtradename')->insert($data);
					$last_id 	= DB::getPDO()->lastInsertId();	
					$action		= 'insert';
				
				} else if($request->id =='0'){
					$data =[
						'jobid' 			=> $request->jobid, 
						'orderid' 			=> $request->orderid,
						'pui' 				=> $request->pui,
						'user_id' 			=> \Auth::id(),
						'type' 				=> 'tr',
						'tradename' 		=> implode(',',@$request->txtdrugtradename),
						'status' 			=> '1', 		
						'created_at' 		=> date('Y-m-d H:i:s'),
					   ];   
					$InsertedID = DB::table('drugtradename')->insert($data);
					$last_id 	= DB::getPDO()->lastInsertId();
					$action		= 'insert';	
				} else if($request->id !='0'){
					$tbl_drugtradename	= DB::table('drugtradename')->where('id', $request->id)->get()->toArray();
					$explodedata		= explode(',',@$tbl_drugtradename[0]->tradename);
					$result 			= array_merge($explodedata,@$request->txtdrugtradename);
					$tradenamedata 		= implode(',',$result);
					DB::table('drugtradename')->where('id', $request->id)->update(['tradename' => $tradenamedata]);
					$last_id 			= $request->id;
					$action				= 'update';
				}
				
				$tbl_drugtradename	= DB::table('drugtradename')->where('id', $last_id)->get()->toArray();
				$explodedata		= explode(',',@$tbl_drugtradename[0]->tradename);
				$indexedtradename	= '"' . implode ( '", "', $explodedata ) . '"';
				
				$data['drugtradename']	= $tbl_drugtradename;
				$data['tblindex_tradename']		= $indexedtradename;	
				
				
				$htmldrugterm	= view('indexing::indexdrug.newdrugtradenameHtml', compact('data'))->render();
				return response()->json(['status' =>'success', 'action' =>$action, 'id' => $last_id, 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);	
	
	}
	
	public function tradenamedata(CreateMedicalRequest $request)
	{
		
		$tbl_drugtradename	= DB::table('drugtradename')->where('id', $request->selectedterm)->get()->toArray();
		$explodedata		= explode(',',@$tbl_drugtradename[0]->tradename);
		
		$data['drugtradename']	= $explodedata;
		$data['selectedid']		= $request->selectedterm;
		$data['type']			= $tbl_drugtradename[0]->type;
		$data['manufacturename']= $tbl_drugtradename[0]->manufacturename;
		$data['countrycode']	= $tbl_drugtradename[0]->countrycode;
		
		$htmldrugterm	= view('indexing::indexdrug.ajaxtradenamelistHtml', compact('data'))->render();
		return response()->json(['status' =>'success', 'type' => $data['type'], 'manufacturename' => $data['manufacturename'], 'countrycode' => $data['countrycode'], 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);	

	}
	
	 public function savedruglinks(CreateDruglinksRequest $request){
	 	
		$druglinks = $request->field;
		
		switch ($druglinks) {
		  case "drugotherfield":
				$drugotherfield = implode(',',$request->drugotherfield);
				DB::table('index_drug')->where('id', $request->selecteddrugid)->update(['drugotherfields' => $drugotherfield]);

				$tbldrugotherfields		= DB::table('drug_otherfield')->where('status', 1)->get()->toArray();
				
				$data['tbldrugotherfields']	= $tbldrugotherfields;	
				$data['drugindextermtype']	= $request->drugindextermtype;
				$data['drugindexterm']		= $request->drugindexterm;
				$data['field']				= $request->field;
				$data['drugotherfield'][]	= $drugotherfield;
				$data['selecteddrugid']		= $request->selecteddrugid;
				$data['tblindex_drug']		= $request->drugotherfield;
				$htmldrugterm	= view('indexing::indexdrug.newDrugOtherfieldHtml', compact('data'))->render();
				return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
			break;
		  case "drugtherapy":
		  		
		  		$drugtherapy =	array();
				if(@$request->txtdrugtherapy !=''){
					array_push($drugtherapy,$request->txtdrugtherapy);
				}
				$seldrugtherapy = implode(',',$drugtherapy);
				DB::table('index_drug')->where('id', $request->selecteddrugid)->update(['drugtherapy' => $seldrugtherapy]);
				
				$matchThese 			= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid,'pui' => $request->pui, 'termtype' => 'DIS'];
				$termtype 				= ['MED','DIS'];
				$tblindex_medical_term	= DB::table('index_medical_term')->select('medicalterm')->where($matchThese)->get()->toArray();
				
				$tblindex_drug			= DB::table('index_drug')->select('drugtherapy')->where('id', $request->selecteddrugid)->get()->toArray();
				$explodedata			= explode(',',@$tblindex_drug[0]->drugtherapy);
				$indexeddrugterm		= '"' . implode ( '", "', $explodedata ) . '"';
				
				$data['field']					= $request->field;
				$data['selecteddrugid']			= $request->selecteddrugid;
				$data['indexed_medical_term']	= $tblindex_medical_term;
				$data['drugtherapy']			= $seldrugtherapy;
				$data['tblindex_drug']			= $indexeddrugterm;
				
				$htmldrugterm	= view('indexing::indexdrug.newDrugTherapyHtml', compact('data'))->render();
				return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
			
			break;
		  case "drugdoseinfo":
		  		$routeofdrug =	$request->routeofdrug;
				$selrouteofdrug = implode(',',$routeofdrug);
				DB::table('index_drug')->where('id', $request->selecteddrugid)->update(['routeofdrug' => $selrouteofdrug]);
					
				$tblroutedrugadmins		= DB::table('routedrugadmins')->where('status', 'Active')->get()->toArray();
			
				$tblindex_drug			= DB::table('index_drug')->select('routeofdrug')->where('id', $request->selecteddrugid)->get()->toArray();
				$explodedata			= explode(',',@$tblindex_drug[0]->routeofdrug);
				$indexedrouteofdrug		= '"' . implode ( '", "', $explodedata ) . '"';
				
				$data['field']			= $request->field;
				$data['selecteddrugid']	= $request->selecteddrugid;
				$data['drugtermtype']	= $request->drugtermtype;
				$data['drugterm']		= $request->drugterm;
				$data['routedrugadmin']	= $tblroutedrugadmins;
				$data['tblindex_drug']	= $indexedrouteofdrug;
			
				$htmldrugterm	= view('indexing::indexdrug.newRouteDrugHtml', compact('data'))->render();
				return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
			break;
			
		  case "dosefreq":
		  		$dosefreq =	$request->dosefrequency;
				$seldosefreq = implode(',',$dosefreq);
				
				DB::table('index_drug')->where('id', $request->selecteddrugid)->update(['dosefreq' => $seldosefreq]);
					
				$tbldosefrequencys		= DB::table('dosefrequencys')->where('status', 'Active')->get()->toArray();
			
				$tblindex_drug			= DB::table('index_drug')->select('dosefreq')->where('id', $request->selecteddrugid)->get()->toArray();
				$explodedata			= explode(',',@$tblindex_drug[0]->dosefreq);
				$indexeddosefrequency		= '"' . implode ( '", "', $explodedata ) . '"';
				
				$data['field']			= $request->field;
				$data['selecteddrugid']	= $request->selecteddrugid;
				$data['drugtermtype']	= $request->drugtermtype;
				$data['drugterm']		= $request->drugterm;
				$data['dosefrequency']	= $tbldosefrequencys;
				$data['tblindex_drug']	= $indexeddosefrequency;
			
				$htmldrugterm	= view('indexing::indexdrug.newDoseFrequencyHtml', compact('data'))->render();
				return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
			break;

		  case "drugcombination":
		  		$drugcombination 	=	$request->drugcombination;
				$seldrugcombination = implode(',',$drugcombination);
				
				DB::table('index_drug')->where('id', $request->selecteddrugid)->update(['drugcomb' => $seldrugcombination]);
					
				
				
				$matchThese 			= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid,'pui' => $request->pui];	
				$tblindex_drug			= DB::table('index_drug')->select('drugterm')->where('drugterm', '!=', $request->drugterm)->where($matchThese)->get()->toArray();
				
				$tbl_drugcombination	= DB::table('index_drug')->select('drugcomb')->where('id', $request->selecteddrugid)->get()->toArray();
				$explodedata			= explode(',',@$tbl_drugcombination[0]->drugcomb);
				$indexeddrugcombination	= '"' . implode ( '", "', $explodedata ) . '"';
				
				$data['field']			= 'drugcombination';
				$data['selecteddrugid']	= $request->selecteddrugid;
				$data['drugtermtype']	= $request->drugtermtype;
				$data['drugterm']		= $request->drugterm;
				$data['drugcombination']= $tblindex_drug;
				$data['tblindex_drug']	= $indexeddrugcombination;
				
				$htmldrugterm	= view('indexing::indexdrug.newDrugCombinationHtml', compact('data'))->render();
				return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
				break;
				
		  case "advdrug":
		  		$adversedrug =	array();
				if(@$request->txtadversedrug !=''){
					array_push($adversedrug,$request->txtadversedrug);
				}
				$seladversedrug = implode(',',$adversedrug);
				DB::table('index_drug')->where('id', $request->selecteddrugid)->update(['advdrug' => $seladversedrug]);
				
				$matchThese 			= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid,'pui' => $request->pui, 'termtype' => 'DIS'];
				$termtype 				= ['MED','DIS'];
				$tblindex_medical_term	= DB::table('index_medical_term')->select('medicalterm')->where($matchThese)->get()->toArray();
				
				$tblindex_drug			= DB::table('index_drug')->select('advdrug')->where('id', $request->selecteddrugid)->get()->toArray();
				$explodedata			= explode(',',@$tblindex_drug[0]->advdrug);
				$indexeddrugterm		= '"' . implode ( '", "', $explodedata ) . '"';
				
				$data['field']					= $request->field;
				$data['selecteddrugid']			= $request->selecteddrugid;
				$data['indexed_medical_term']	= $tblindex_medical_term;
				$data['drugtherapy']			= $seladversedrug;
				$data['tblindex_drug']			= $indexeddrugterm;
				
				$htmldrugterm	= view('indexing::indexdrug.newadvdrugHtml', compact('data'))->render();
				return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
			
			break;
				
		  case "drugcomparison":
		  		$drugcomparison 	=	$request->drugcomparison;
				$seldrugcomparison 	= implode(',',$drugcomparison);
				
				DB::table('index_drug')->where('id', $request->selecteddrugid)->update(['drugcomp' => $seldrugcomparison]);
				$matchThese 			= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid,'pui' => $request->pui];	
				$tblindex_drug			= DB::table('index_drug')->select('drugterm')->where('drugterm', '!=', $request->drugterm)->where($matchThese)->get()->toArray();
				
				$tbl_drugcomparison		= DB::table('index_drug')->select('drugcomp')->where('id', $request->selecteddrugid)->get()->toArray();
				$explodedata			= explode(',',@$tbl_drugcomparison[0]->drugcomp);
				$indexeddrugcomparison	= '"' . implode ( '", "', $explodedata ) . '"';
				
				$data['field']			= $request->field;
				$data['selecteddrugid']	= $request->selecteddrugid;
				$data['drugtermtype']	= $request->drugindextermtype;
				$data['drugterm']		= $request->drugterm;
				$data['drugcomparison']	= $tblindex_drug;
				$data['tblindex_drug']	= $indexeddrugcomparison;
				
				$htmldrugterm	= view('indexing::indexdrug.newDrugComparisonHtml', compact('data'))->render();
				return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
				break;
				
		  case "drugdosageschedule":
		  		$drugdosescheduleterm 	=	$request->drugdosescheduleterm;
				$drugdosescheduleterm 	= implode(',',$drugdosescheduleterm);
				
				DB::table('index_drug')->where('id', $request->selecteddrugid)->update(['drugdosage' => $drugdosescheduleterm]);
				$matchThese 			= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid,'pui' => $request->pui];	
				
				$tblindex_drug			= DB::table('index_drug')->select('drugterm')->where('drugterm', '!=', $request->drugterm)->where($matchThese)->get()->toArray();
				
				$tbl_drugdosage			= DB::table('index_drug')->select('drugdosage')->where('id', $request->selecteddrugid)->get()->toArray();
				$explodedata			= explode(',',@$tbl_drugdosage[0]->drugdosage);
				$indexeddrugdosage		= '"' . implode ( '", "', $explodedata ) . '"';
				
				$tbldrugdosescheduleterms	= DB::table('drugdosescheduleterms')->where('status', 'Active')->get()->toArray();
			
				$data['field']			= 'drugdosageschedule';
				$data['selecteddrugid']	= $request->selecteddrugid;
				$data['drugtermtype']	= $request->drugindextermtype;
				$data['drugterm']		= $request->drugindexterm;
				$data['dosescheduleterms']	= $tbldrugdosescheduleterms;
				$data['tblindex_drug']	= $indexeddrugdosage;
				$htmldrugterm	= view('indexing::indexdrug.newdrugdosagescheduleHtml', compact('data'))->render();
				return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
				break;
		
		  case "druginteraction":
		  		$druginteraction =	array();
				if(@$request->txtdruginteraction !=''){
					array_push($druginteraction,$request->txtdruginteraction);
				}
				$seldruginteraction = implode(',',$druginteraction);
				
				DB::table('index_drug')->where('id', $request->selecteddrugid)->update(['druginteraction' => $seldruginteraction]);
				$matchThese 			= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid,'pui' => $request->pui];	
				
				$tblindex_drug			= DB::table('index_drug')->select('drugterm')->where('drugterm', '!=', $request->drugterm)->where($matchThese)->get()->toArray();
				
				$tbl_druginteraction	= DB::table('index_drug')->select('druginteraction')->where('id', $request->selecteddrugid)->get()->toArray();
				$explodedata			= explode(',',@$tbl_druginteraction[0]->druginteraction);
				$indexeddruginteraction		= '"' . implode ( '", "', $explodedata ) . '"';
				
			
				$data['field']			= 'druginteraction';
				$data['selecteddrugid']	= $request->selecteddrugid;
				$data['drugtermtype']	= $request->drugindextermtype;
				$data['drugterm']		= $request->drugindexterm;
				$data['druginteraction']	= $tblindex_drug;
				$data['tblindex_drug']	= $indexeddruginteraction;
				$htmldrugterm	= view('indexing::indexdrug.newdruginteractionHtml', compact('data'))->render();
				return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
				break;
		
		  case "drugpharma":
		  		
				$selspecialsitutation = implode(',',$request->specialsitutation);				
				DB::table('index_drug')->where('id', $request->selecteddrugid)->update(['specialpharma' => $selspecialsitutation]);
				
				$selunexpectedoutcome = implode(',',$request->unexpectedoutcome);				
				DB::table('index_drug')->where('id', $request->selecteddrugid)->update(['unexpecteddrugtreatment' => $selunexpectedoutcome]);
				
				$tblspecialsituations	= DB::table('specialsituations')->where('status', 'Active')->get()->toArray();
				$tblunexpectedoutcomes	= DB::table('unexpectedoutcomes')->where('status', 'Active')->get()->toArray();
				
				
				$tbl_specialpharma		= DB::table('index_drug')->select('specialpharma')->where('id', $request->selecteddrugid)->get()->toArray();
				$explodedata			= explode(',',@$tbl_specialpharma[0]->specialpharma);
				$indexedspecialpharma	= '"' . implode ( '", "', $explodedata ) . '"';
				
				
				$tbl_drugtreatment				= DB::table('index_drug')->select('unexpecteddrugtreatment')->where('id', $request->selecteddrugid)->get()->toArray();
				$explodedata_drugtreatment		= explode(',',@$tbl_drugtreatment[0]->unexpecteddrugtreatment);
				$indexedunexpecteddrugtreatment	= '"' . implode ( '", "', $explodedata_drugtreatment ) . '"';
				
				
				$data['field']			= 'drugpharma';
				$data['selecteddrugid']	= $request->selecteddrugid;
				$data['drugtermtype']	= $request->drugtermtype;
				$data['drugterm']		= $request->drugterm;
				
				$data['specialpharma']	= $tblspecialsituations;
				$data['drugtreatment']	= $tblunexpectedoutcomes;
				
				
				$data['tblindex_drugspecialpharma']				= $indexedspecialpharma;		
				$data['tblindex_drugunexpecteddrugtreatment']	= $indexedunexpecteddrugtreatment;
				
				$htmldrugterm	= view('indexing::indexdrug.newdrugpharmaHtml', compact('data'))->render();
				return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
				break;
		
		
		 case "drugtradename":
		 
				if($request->termDTNindexing == '1' && $request->id =='0'){
					$data =[
						'jobid' 			=> $request->jobid, 
						'orderid' 			=> $request->orderid,
						'pui' 				=> $request->pui,
						'user_id' 			=> \Auth::id(),
						'drugtermid' 		=> $request->selecteddrugid,
						'type' 				=> 'ma',
						'countrycode' 		=> $request->txtcountrycode,		
						'manufacturename' 	=> $request->txtdrugmanufacturename,
						'status' 			=> '1', 		
						'created_at' 		=> date('Y-m-d H:i:s'),
					   ];   
					$InsertedID = DB::table('drugtradename')->insert($data);
					$last_id 	= DB::getPDO()->lastInsertId();	
				
				} else if($request->id =='0'){
					$data =[
						'jobid' 			=> $request->jobid, 
						'orderid' 			=> $request->orderid,
						'pui' 				=> $request->pui,
						'user_id' 			=> \Auth::id(),
						'drugtermid' 		=> $request->selecteddrugid,
						'type' 				=> 'tr',
						'tradename' 		=> $request->txtdrugtradename,
						'status' 			=> '1', 		
						'created_at' 		=> date('Y-m-d H:i:s'),
					   ];   
					$InsertedID = DB::table('drugtradename')->insert($data);
					$last_id 	= DB::getPDO()->lastInsertId();	
				}
		  		
				$tbl_drugtradename	= DB::table('drugtradename')->where('drugtermid', $request->selecteddrugid)->get()->toArray();
				$explodedata		= explode(',',@$tbl_drugtradename[0]->tradename);
				$indexedtradename	= '"' . implode ( '", "', $explodedata ) . '"';
				
				$data['field']			= $request->field;
				$data['id']				= $last_id;
				$data['selecteddrugid']	= $request->selecteddrugid;
				$data['drugtermtype']	= $request->drugtermtype;
				$data['drugterm']		= $request->drugterm;
				$data['drugtradename']	= $tbl_drugtradename;
				$data['tblindex_tradename']		= $indexedtradename;	
				
				
				$htmldrugterm	= view('indexing::indexdrug.newdrugtradenameHtml', compact('data'))->render();
				return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
				break;
		}

		return ajaxResponse(
            [
                'message'  => langapp('saved_successfully')
            ],
            true,
            Response::HTTP_CREATED
        );
		
	 }
	
	
	public function frmdrugotherfield(CreateMedicalRequest $request){
		$tbldrugotherfields		= DB::table('drug_otherfield')->where('status', 1)->get()->toArray();
		$tblindex_drug			= DB::table('index_drug')->select('drugotherfields')->where('id', $request->drugid)->get()->toArray();
		
		$data['tbldrugotherfields']	= $tbldrugotherfields;	
		$data['tblindex_drug']		= explode(',',@$tblindex_drug[0]->drugotherfields);
		
		$data['drugtermtype']	= $request->drugtermtype;
		$data['drugterm']		= $request->drugterm;
		$data['field']			= 'drugotherfield';
		$data['selecteddrugid']	= $request->drugid;
		$data['drugotherfield']	= array();
		
		$htmldrugterm	= view('indexing::indexdrug.newDrugOtherfieldHtml', compact('data'))->render();
		return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
	}

	public function frmdrugtherapy(CreateMedicalRequest $request){
		$tblindex_drug			= DB::table('index_drug')->select('drugtherapy')->where('id', $request->drugid)->get()->toArray();
		$matchThese 			= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid,'pui' => $request->pui,'termtype' => 'DIS'];
		$termtype 				= ['MED','DIS'];
		$tblindex_medical_term	= DB::table('index_medical_term')->select('medicalterm')->where($matchThese)->get()->toArray();
		$explodedata			= explode(',',@$tblindex_drug[0]->drugtherapy);
		$indexeddrugterm		= '"' . implode ( '", "', $explodedata ) . '"';
		
		$data['field']			= 'drugtherapy';
		$data['selecteddrugid']	= $request->drugid;
		$data['drugtermtype']	= $request->drugtermtype;
		$data['drugterm']		= $request->drugterm;
		$data['indexed_medical_term']		= $tblindex_medical_term;
		$data['tblindex_drug']		= $indexeddrugterm;
		
		$htmldrugterm	= view('indexing::indexdrug.newDrugTherapyHtml', compact('data'))->render();
		return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
	}

	public function frmdrugdoseinfo(CreateMedicalRequest $request){
	
	}

	public function frmrouteofdrug(CreateMedicalRequest $request){
		$tblroutedrugadmins		= DB::table('routedrugadmins')->where('status', 'Active')->get()->toArray();
		
		$tblindex_drug			= DB::table('index_drug')->select('routeofdrug')->where('id', $request->drugid)->get()->toArray();
		$explodedata			= explode(',',@$tblindex_drug[0]->routeofdrug);
		$indexedrouteofdrug		= '"' . implode ( '", "', $explodedata ) . '"';
		
		$data['field']			= 'drugdoseinfo';
		$data['selecteddrugid']	= $request->drugid;
		$data['drugtermtype']	= $request->drugtermtype;
		$data['drugterm']		= $request->drugterm;
		$data['routedrugadmin']	= $tblroutedrugadmins;
		$data['tblindex_drug']	= $indexedrouteofdrug;
		
		$htmldrugterm	= view('indexing::indexdrug.newRouteDrugHtml', compact('data'))->render();
		return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
	
	}

	public function frmdosefrequency(CreateMedicalRequest $request){
	
		$tbldosefrequencys		= DB::table('dosefrequencys')->where('status', 'Active')->get()->toArray();
		
		$tblindex_drug			= DB::table('index_drug')->select('dosefreq')->where('id', $request->drugid)->get()->toArray();
		$explodedata			= explode(',',@$tblindex_drug[0]->dosefreq);
		$indexeddosefrequency	= '"' . implode ( '", "', $explodedata ) . '"';
		
		$data['field']			= 'dosefreq';
		$data['selecteddrugid']	= $request->drugid;
		$data['drugtermtype']	= $request->drugtermtype;
		$data['drugterm']		= $request->drugterm;
		$data['dosefrequency']	= $tbldosefrequencys;
		$data['tblindex_drug']	= $indexeddosefrequency;
		
		$htmldrugterm	= view('indexing::indexdrug.newDoseFrequencyHtml', compact('data'))->render();
		return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
	
	}

	public function frmdrugcombination(CreateMedicalRequest $request){
	
		$matchThese 			= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid,'pui' => $request->pui];	
		$tblindex_drug			= DB::table('index_drug')->select('drugterm')->where('drugterm', '!=', $request->drugterm)->where($matchThese)->get()->toArray();
		
		$tbl_drugcombination	= DB::table('index_drug')->select('drugcomb')->where('id', $request->drugid)->get()->toArray();
		$explodedata			= explode(',',@$tbl_drugcombination[0]->drugcomb);
		$indexeddrugcombination	= '"' . implode ( '", "', $explodedata ) . '"';
		
		$data['field']			= 'drugcombination';
		$data['selecteddrugid']	= $request->drugid;
		$data['drugtermtype']	= $request->drugtermtype;
		$data['drugterm']		= $request->drugterm;
		$data['drugcombination']= $tblindex_drug;
		$data['tblindex_drug']	= $indexeddrugcombination;
		
		$htmldrugterm	= view('indexing::indexdrug.newDrugCombinationHtml', compact('data'))->render();
		return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
		
	}
	
	public function frmadversedrug(CreateMedicalRequest $request){
		$tblindex_drug			= DB::table('index_drug')->select('advdrug')->where('id', $request->drugid)->get()->toArray();
		$matchThese 			= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid,'pui' => $request->pui,'termtype' => 'DIS'];
		$termtype 				= ['MED','DIS'];
		$tblindex_medical_term	= DB::table('index_medical_term')->select('medicalterm')->where($matchThese)->get()->toArray();
		
		$explodedata			= explode(',',@$tblindex_drug[0]->advdrug);
		$indexeddrugterm		= '"' . implode ( '", "', $explodedata ) . '"';
		
		$data['field']			= 'advdrug';
		$data['selecteddrugid']	= $request->drugid;
		$data['drugtermtype']	= $request->drugtermtype;
		$data['drugterm']		= $request->drugterm;
		$data['indexed_medical_term']		= $tblindex_medical_term;
		$data['tblindex_drug']		= $indexeddrugterm;
		
		$htmldrugterm	= view('indexing::indexdrug.newadvdrugHtml', compact('data'))->render();
		return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
	
	}

	public function frmdrugcomparison(CreateMedicalRequest $request){
	
		$matchThese 			= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid,'pui' => $request->pui];	
		$tblindex_drug			= DB::table('index_drug')->select('drugterm')->where('drugterm', '!=', $request->drugterm)->where($matchThese)->get()->toArray();
		
		$tbl_drugcomparison		= DB::table('index_drug')->select('drugcomp')->where('id', $request->drugid)->get()->toArray();
		$explodedata			= explode(',',@$tbl_drugcomparison[0]->drugcomp);
		$indexeddrugcomparison	= '"' . implode ( '", "', $explodedata ) . '"';
		
		$data['field']			= 'drugcomparison';
		$data['selecteddrugid']	= $request->drugid;
		$data['drugtermtype']	= $request->drugtermtype;
		$data['drugterm']		= $request->drugterm;
		$data['drugcomparison']	= $tblindex_drug;
		$data['tblindex_drug']	= $indexeddrugcomparison;
		
		$htmldrugterm	= view('indexing::indexdrug.newDrugComparisonHtml', compact('data'))->render();
		return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
	
	}

	public function frmdrugdosage(CreateMedicalRequest $request){
		$tbldrugdosescheduleterms	= DB::table('drugdosescheduleterms')->where('status', 'Active')->get()->toArray();
		
		$tblindex_drug			= DB::table('index_drug')->select('drugdosage')->where('id', $request->drugid)->get()->toArray();
		$explodedata			= explode(',',@$tblindex_drug[0]->drugdosage);
		$indexeddrugdosage		= '"' . implode ( '", "', $explodedata ) . '"';
		
		$data['field']			= 'drugdosageschedule';
		$data['selecteddrugid']	= $request->drugid;
		$data['drugtermtype']	= $request->drugtermtype;
		$data['drugterm']		= $request->drugterm;
		$data['dosescheduleterms']	= $tbldrugdosescheduleterms;
		$data['tblindex_drug']	= $indexeddrugdosage;
		
		$htmldrugterm	= view('indexing::indexdrug.newdrugdosagescheduleHtml', compact('data'))->render();
		return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
	
	}

	public function frmdruginteraction(CreateMedicalRequest $request){
		$matchThese 			= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid,'pui' => $request->pui];	
		$tblindex_drug			= DB::table('index_drug')->select('drugterm')->where('drugterm', '!=', $request->drugterm)->where($matchThese)->get()->toArray();
		
		$tbl_druginteraction	= DB::table('index_drug')->select('druginteraction')->where('id', $request->drugid)->get()->toArray();
		$explodedata			= explode(',',@$tbl_druginteraction[0]->druginteraction);
		$indexeddruginteraction	= '"' . implode ( '", "', $explodedata ) . '"';
		
		$data['field']			= 'druginteraction';
		$data['selecteddrugid']	= $request->drugid;
		$data['drugtermtype']	= $request->drugtermtype;
		$data['drugterm']		= $request->drugterm;
		$data['druginteraction']	= $tblindex_drug;
		$data['tblindex_drug']	= $indexeddruginteraction;
		
		$htmldrugterm	= view('indexing::indexdrug.newdruginteractionHtml', compact('data'))->render();
		return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
	
	}

	public function frmdrugpharma(CreateMedicalRequest $request){
		$tblspecialsituations	= DB::table('specialsituations')->where('status', 'Active')->get()->toArray();
		$tblunexpectedoutcomes	= DB::table('unexpectedoutcomes')->where('status', 'Active')->get()->toArray();
		
		$tbl_specialpharma		= DB::table('index_drug')->select('specialpharma')->where('id', $request->drugid)->get()->toArray();
		$explodedata			= explode(',',@$tbl_specialpharma[0]->specialpharma);
		$indexedspecialpharma	= '"' . implode ( '", "', $explodedata ) . '"';
		
		
		$tbl_drugtreatment				= DB::table('index_drug')->select('unexpecteddrugtreatment')->where('id', $request->drugid)->get()->toArray();
		$explodedata_drugtreatment		= explode(',',@$tbl_drugtreatment[0]->unexpecteddrugtreatment);
		$indexedunexpecteddrugtreatment	= '"' . implode ( '", "', $explodedata_drugtreatment ) . '"';
		
		
		$data['field']			= 'drugpharma';
		$data['selecteddrugid']	= $request->drugid;
		$data['drugtermtype']	= $request->drugtermtype;
		$data['drugterm']		= $request->drugterm;
		
		$data['specialpharma']	= $tblspecialsituations;
		$data['drugtreatment']	= $tblunexpectedoutcomes;
		
		
		$data['tblindex_drugspecialpharma']				= $indexedspecialpharma;		
		$data['tblindex_drugunexpecteddrugtreatment']	= $indexedunexpecteddrugtreatment;
		
		$htmldrugterm	= view('indexing::indexdrug.newdrugpharmaHtml', compact('data'))->render();
		return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
		
	
	}

	public function frmdrugtradename(CreateMedicalRequest $request){
		
		$tbl_drugtradename	= DB::table('drugtradename')->where('drugtermid', $request->drugid)->get()->toArray();
		$explodedata		= explode(',',@$tbl_drugtradename[0]->tradename);
		$indexedtradename	= '"' . implode ( '", "', $explodedata ) . '"';
		
		$data['field']			= 'drugtradename';
		$data['selecteddrugid']	= $request->drugid;
		$data['drugtermtype']	= $request->drugtermtype;
		$data['drugterm']		= $request->drugterm;
		$data['drugtradename']	= $tbl_drugtradename;
		$data['tblindex_tradename']		= $indexedtradename;
		
		$data['jobid']		= $request->jobid;
		$data['orderid']	= $request->orderid;
		$data['pui']		= $request->pui;
		
		$htmldrugterm	= view('indexing::indexdrug.newdrugtradenameHtml', compact('data'))->render();
		return response()->json(['status' =>'success', 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
	
	}

	 public function savedevicetradename(CreateMedicalRequest $request){
			if($request->termDTNindexing == '1' && $request->id =='0'){
					$data =[
						'jobid' 			=> $request->jobid, 
						'orderid' 			=> $request->orderid,
						'pui' 				=> $request->pui,
						'user_id' 			=> \Auth::id(),
						'type' 				=> 'mv',
						'countrycode' 		=> $request->txtcountrycode,		
						'manufacturename' 	=> $request->txtdevicemanufacturename,
						'tradename' 		=> implode(',',@$request->txtdevicetradename),
						'status' 			=> '1', 		
						'created_at' 		=> date('Y-m-d H:i:s'),
					   ];   
					$InsertedID = DB::table('devicetradename')->insert($data);
					$last_id 	= DB::getPDO()->lastInsertId();	
					$action		= 'insert';
				
				} else if($request->id =='0'){
					$data =[
						'jobid' 			=> $request->jobid, 
						'orderid' 			=> $request->orderid,
						'pui' 				=> $request->pui,
						'user_id' 			=> \Auth::id(),
						'type' 				=> 'tv',
						'tradename' 		=> implode(',',@$request->txtdevicetradename),
						'status' 			=> '1', 		
						'created_at' 		=> date('Y-m-d H:i:s'),
					   ];   
					$InsertedID = DB::table('devicetradename')->insert($data);
					$last_id 	= DB::getPDO()->lastInsertId();
					$action		= 'insert';	
				} else if($request->id !='0'){
					$tbl_devicetradename= DB::table('devicetradename')->where('id', $request->id)->get()->toArray();
					$explodedata		= explode(',',@$tbl_devicetradename[0]->tradename);
					$result 			= array_merge($explodedata,@$request->txtdevicetradename);
					$tradenamedata 		= implode(',',$result);
					DB::table('devicetradename')->where('id', $request->id)->update(['tradename' => $tradenamedata]);
					$last_id 			= $request->id;
					$action				= 'update';
				}
		  		
				$tbl_devicetradename	= DB::table('devicetradename')->where('id', $last_id)->get()->toArray();
				$explodedata			= explode(',',@$tbl_devicetradename[0]->tradename);
				$indexedtradename		= '"' . implode ( '", "', $explodedata ) . '"';
				
				$data['devicetradename']	= $tbl_devicetradename;
				$data['tblindex_tradename']	= $indexedtradename;	
				
				
				$htmldrugterm	= view('indexing::indexdrug.newdevicetradenameHtml', compact('data'))->render();
				return response()->json(['status' =>'success', 'action' =>$action, 'id' => $last_id, 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);	
	
	}

	public function devicetradenamedata(CreateMedicalRequest $request)
	{
		$tbl_devicetradename	= DB::table('devicetradename')->where('id', $request->selectedterm)->get()->toArray();
		$explodedata			= explode(',',@$tbl_devicetradename[0]->tradename);
		
		$data['devicetradename']= $explodedata;
		$data['selectedid']		= $request->selectedterm;
		$data['type']			= $tbl_devicetradename[0]->type;
		$data['manufacturename']= $tbl_devicetradename[0]->manufacturename;
		$data['countrycode']	= $tbl_devicetradename[0]->countrycode;
		
		$htmldrugterm	= view('indexing::indexdrug.ajaxdevicetradenamelistHtml', compact('data'))->render();
		return response()->json(['status' =>'success', 'type' => $data['type'], 'manufacturename' => $data['manufacturename'], 'countrycode' => $data['countrycode'], 'htmldrugterm' =>$htmldrugterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);	

	}

	/**
     * Delete a indexing
     */
    public function deletedevicetradename($id = null, $value = null)
    {
		$tradelist 		= 	DB::table('devicetradename')->where('id', $id)->get()->toArray();
		$explodedata 	=  	explode(',',$tradelist[0]->tradename);
		$to_remove[] = $value;
		$result = array_diff($explodedata, $to_remove);
		$tradenamedata = implode(',',$result);
		DB::table('devicetradename')->where('id', $id)->update(['tradename' => $tradenamedata]);
		
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
	public function sublink()
	{
		$term		=	$this->request->searchterm;
		$WherematchThese 		= ['user_id' => \Auth::id(), 'jobid' => $this->request->jobid, 'pui' => $this->request->pui, 'orderid' => $this->request->orderid];
		$output = '';
		switch ($term) {
		  case 'Adverse device effect':
		  		$sublinks	= 	DB::table('index_medical_term')->where($WherematchThese)->where('termtype','DIS')->get()->toArray();
				foreach($sublinks as $sublink){
					$output .=	'<option value="'.$sublink->medicalterm.'">'.$sublink->medicalterm.'</option>';
				}
			break;
		  case 'Clinical trial':
			break;
		  case 'Device Comparison':
			break;
		  case 'Device economics':
			break;
		}
		return response($output, Response::HTTP_OK);	
	}
	
	
	/**
     * Save new Medical Term
     */
    public function savemedicalindexing(CreateMedicalRequest $request){
			if(!empty($request->sublink)){
				$sublink = implode(',',@$request->sublink);
			} else {
				$sublink = 'Null';
			}
			
			if($request->medicaltermindexing == '1' && $request->txtdeviceterm !=''){
				$data =[
						'jobid' 		=> $request->jobid, 
						'orderid' 		=> $request->orderid,
						'pui' 			=> $request->pui,
						'user_id' 		=> \Auth::id(),
						'type' 			=> 'major',
						'termtype' 		=> $request->txtdevicetermtype,		
						'deviceterm' 	=> $request->txtdeviceterm,
						'devicelink'	=> $request->indexer_devicelink,
						'sublink'		=> $sublink,
						'status' 		=> '1', 		
						'created_at' 	=> date('Y-m-d H:i:s'),
					   ];   
				$InsertedID = DB::table('medicaldevice')->insert($data);
				$last_id 	= DB::getPDO()->lastInsertId();	
			} elseif($request->medicaltermindexing == '0' && $request->txtdeviceterm !=''){
				$data =[
						'jobid' 		=> $request->jobid, 
						'orderid' 		=> $request->orderid,
						'pui' 			=> $request->pui,
						'user_id' 		=> \Auth::id(),
						'type' 			=> 'minor',
						'termtype' 		=> $request->txtdevicetermtype,		
						'deviceterm' 	=> $request->txtdeviceterm,
						'devicelink'	=> $request->indexer_devicelink,
						'sublink'		=> $sublink,
						'status' 		=> '1', 		
						'created_at' 	=> date('Y-m-d H:i:s'),
					   ];   
				$InsertedID = DB::table('medicaldevice')->insert($data);
				$last_id 	= DB::getPDO()->lastInsertId();	
			}
			
			
			
			//Last Inserted Data 			
			$medicaltermdata 		= DB::table('medicaldevice')->where('id', $last_id)->get()->toArray();
			
			
			
			
			
			//Total count of data
			
			$matchThese 			= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid,'pui' => $request->pui];
			
			
			$medicaltermtypecount 	= DB::table('medicaldevice')->select('type', DB::raw('count(*) as total'))->where($matchThese)->groupBy('type')->pluck('total','type')->all();
			
			$sublinkcount 			= DB::table('medicaldevice')->select(DB::raw("(CHAR_LENGTH(sublink) - CHAR_LENGTH(REPLACE(sublink, ',', '')) + 1) as TotalValue"))->where($matchThese)->where('sublink', '<>', 'Null')->get()->toArray();
			$totalsublinkcnt = 0;
			foreach($sublinkcount as $cntval){
			   $totalsublinkcnt = $totalsublinkcnt + $cntval->TotalValue;
			}
	
			$medicaldata = array();
			foreach($medicaltermdata as $termgroup){
			   $medicaldata[$termgroup->type][] = $termgroup;
			}
			
			
			$data['medicaltermdata']   		= $medicaltermdata;
			$data['type']   				= $request->medicaltermindexing;	
			
			
				
			$majorcount 					= @$medicaltermtypecount['major'];	
			$minorcount 					= @$medicaltermtypecount['minor'];
			$totalmedcountterm				= @$medicaltermtypecount['major'] + @$medicaltermtypecount['minor'];
			
			
			if ($this->request->has('json')) {
				$htmlmedicalterm	= view('indexing::indexmedial.newMedicaldeviceHtml', compact('data'))->render();
				return response()->json(['status' =>'success', 'type' => $request->medicaltermindexing,  'totalmedcountterm' => $totalmedcountterm, 'sublinkcount' => $totalsublinkcnt, 'minorcount' => $minorcount,'majorcount' => $majorcount, 'htmlmedicalterm' =>$htmlmedicalterm,  'message' => langapp('saved_successfully')], Response::HTTP_OK);
			} 
			
			
			return ajaxResponse(
            [
                'message'  => langapp('saved_successfully')
            ],
            true,
            Response::HTTP_CREATED
        );
	
	}
	
	
	 /**
     * Delete a indexing
     */
    public function deletemedicaldevice($id = null,$jobid = null,$orderid = null)
    {
		DB::table('medicaldevice')->where('id', $id)->delete();
		
		//Total count of data
			
		$matchThese 			= ['user_id' => \Auth::id(), 'jobid' => $jobid, 'orderid' => $orderid];
		$medicaltermtypecount 	= DB::table('medicaldevice')->select('type', DB::raw('count(*) as total'))->where($matchThese)->groupBy('type')->pluck('total','type')->all();
		
		
		$sublinkcount 			= DB::table('medicaldevice')->select(DB::raw("(CHAR_LENGTH(sublink) - CHAR_LENGTH(REPLACE(sublink, ',', '')) + 1) as TotalValue"))->where($matchThese)->where('sublink', '<>', 'Null')->get()->toArray();
			$totalsublinkcnt = 0;
			foreach($sublinkcount as $cntval){
			   $totalsublinkcnt = $totalsublinkcnt + $cntval->TotalValue;
			}
	
			$medicaldata = array();
			foreach($medicaltermdata as $termgroup){
			   $medicaldata[$termgroup->type][] = $termgroup;
			}
			
			
			$data['medicaltermdata']   		= $medicaltermdata;
			$data['type']   				= $request->medicaltermindexing;	
			
			
				
			$majorcount 					= @$medicaltermtypecount['major'];	
			$minorcount 					= @$medicaltermtypecount['minor'];
			$totalmedcountterm				= @$medicaltermtypecount['major'] + @$medicaltermtypecount['minor'];
			
			
			
	
        return ajaxResponse(
            [
                'message'  			=> langapp('deleted_successfully'),
				'majorcount' 		=> $majorcount,
				'minorcount'  		=> $minorcount,
				'totalmedcountterm' => $totalmedcountterm,
				'totaldiseasecount' => $totaldiseasescnt,
                'redirect' 			=> route('indexing.index'),
            ],
            true,
            Response::HTTP_OK
        );
    }
	
	public function esvsentences(CreateMedicalRequest $request){
			
			if($request->selectterm !='null'){
				$selectedterms =  base64_decode($request->selectterm);
				$selectedterms =  str_replace(array('[', ']'), array('', ''), $selectedterms);
				$termArys 	   =  explode('",',$selectedterms);
				
				$output = '<div id="preloader"><i class="fas fa-spin fa-spinner"></i> Loading...</div><div class="list-group">';
				
				$output .= '<a href="#" class="list-group-item list-group-item-action flex-column align-items-start active"><div class="d-flex w-100 justify-content-between"><h5 class="mb-1"><strong>Term :</strong> '.$request->term.'</span></h5></div><p class="mb-1"><span><strong>TermType :</strong> '.$request->termType.'</span></p><p class="mb-1"><span><strong>Score :</strong> '.$request->score.'</span></p><small><span><strong>Sentence(s) Count :</strong> '.count($termArys).'</span></small></a>';
				
					
				foreach($termArys as $termAry){
					$output .= '<a href="#" class="list-group-item">'.str_replace('"','',$termAry).'</a>';
				
				}
				$output .= '</div>';
			} else {
			$output = '<div id="preloader"><i class="fas fa-spin fa-spinner"></i> Loading...</div>';
			$output .= '<a href="#" class="list-group-item list-group-item-action flex-column align-items-start active"><div class="d-flex w-100 justify-content-between"><h5 class="mb-1"><strong>Term :</strong> '.$request->term.'</span></h5></div><p class="mb-1"><span><strong>TermType :</strong> '.$request->termType.'</span></p><p class="mb-1"><span><strong>Score :</strong> '.$request->score.'</span></p></a>';
				
			}
			
		return ajaxResponse(
            [
                'message'  			=> $output,
            ],
            true,
            Response::HTTP_OK
        );
	
	}
	
	public function saveesvdata(CreateMedicalRequest $request){
	
	 
			 if($request->termtype =='DRG'){
				$WherematchThese 	= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid, 'pui' => $request->pui];
				$findesvdata 		= DB::table('index_drug')->select('drugterm')->where('drugterm',$request->term)->where($WherematchThese)->get()->toArray();
					if(!empty($findesvdata)){
						return ajaxResponse(
								[
									'message' 	 => 'Already exists ( '.$request->type.' )'.$request->termtype.''  ,
								],
							false,
							Response::HTTP_OK
							);
					} else {
						$data =[
							'jobid' 		=> $request->jobid, 
							'orderid' 		=> $request->orderid,
							'pui' 			=> $request->pui,
							'user_id' 		=> \Auth::id(),
							'type' 			=> $request->type,
							'termtype' 		=> $request->termtype,		
							'drugterm' 		=> $request->term,
							'term_added' 	=> $request->term_added,
							'status' 		=> '1', 		
							'created_at' 	=> date('Y-m-d H:i:s'),
						   ];   
						$InsertedID = DB::table('index_drug')->insert($data);
						$last_id 	= DB::getPDO()->lastInsertId();	
						
						return ajaxResponse(
							[
								'message'  => langapp('saved_successfully')
							],
							true,
							Response::HTTP_CREATED
						);	
					}
			} else if($request->termtype =='Checktag'){ 
					$WherematchThese 	= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid, 'pui' => $request->pui];
					$findesvdata 		= DB::table('index_medical_checktag')->select('checktag')->where('checktag',$request->term)->where($WherematchThese)->get()->toArray();
						if(!empty($findesvdata)){
							return ajaxResponse(
									[
										'message' 	 => 'Already exists ( '.$request->type.' )'.$request->termtype.''  ,
									],
								false,
								Response::HTTP_OK
								);
						} else {
							$data =[
								'jobid' 		=> $request->jobid, 
								'orderid' 		=> $request->orderid,
								'pui' 			=> $request->pui,
								'user_id' 		=> \Auth::id(),
								'checktag' 		=> $request->term, 
								'term_added' 	=> $request->term_added,							
								'status' 		=> '1',
								'created_at' 	=> date('Y-m-d H:i:s'),
							   ];   
							$checktags_last_id 	=	DB::table('index_medical_checktag')->insert($data);
							$last_id 			= 	DB::getPDO()->lastInsertId();	

							
							return ajaxResponse(
								[
									'message'  => langapp('saved_successfully')
								],
								true,
								Response::HTTP_CREATED
							);	
						}
			} else if($request->termtype =='MED' || $request->termtype =='DIS'){
				$WherematchThese 	= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid, 'pui' => $request->pui];
				$findesvdata 		= DB::table('index_medical_term')->select('medicalterm')->where('medicalterm',$request->term)->where($WherematchThese)->get()->toArray();
					if(!empty($findesvdata)){
						return ajaxResponse(
								[
									'message' 	 => 'Already exists ( '.$request->type.' )'.$request->termtype.''  ,
								],
							false,
							Response::HTTP_OK
							);
					} else {
						$data =[
							'jobid' 		=> $request->jobid, 
							'orderid' 		=> $request->orderid,
							'pui' 			=> $request->pui,
							'user_id' 		=> \Auth::id(),
							'type' 			=> $request->type,
							'termtype' 		=> $request->termtype,		
							'medicalterm' 	=> $request->term,
							'term_added' 	=> $request->term_added,
							'status' 		=> '1', 		
							'created_at' 	=> date('Y-m-d H:i:s'),
						   ];   
						$InsertedID = DB::table('index_medical_term')->insert($data);
						$last_id 	= DB::getPDO()->lastInsertId();	
						
					return ajaxResponse(
						[
							'message'  => langapp('saved_successfully')
						],
						true,
						Response::HTTP_CREATED
					);	
				}
			}
		}
		
		
		
	public function ajaxdatview(CreateMedicalRequest $request){
			$data = array();
			// Section Dat Data
			$matchThese 	= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid, 'pui' => $request->pui];
			$sectiondata 	= DB::table('datasections')->where($matchThese)->get()->toArray();
			
			$dataary	=	array();
			
			$dataary[0]['id']		= 'section-01';
			$dataary[0]['text']	= 'Section';
			foreach($sectiondata as $key => $section){
				$dataary[0]['children'][$key]['id'] = 'datasections_'.$section->id;
				$dataary[0]['children'][$key]['text'] = '_cl '.$section->sectionval;
			}
			
			
			// Medical Dat Data
			$matchThese 	= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid, 'pui' => $request->pui];
			$medicaldata 	= DB::table('index_medical_term')->where($matchThese)->get()->toArray();
			
			
			
			$medicaltermdata = array();
			foreach($medicaldata as $termgroup){
			   $medicaltermdata[$termgroup->type][] = $termgroup;
			}
			$medicaldataary	=	array();
			$medicaldataary[0]['id']	= 'medical-01';
			$medicaldataary[0]['text']	= 'Medical';
			$cnt=0;
			foreach($medicaltermdata as $medicalkey => $medicaldataterm){
			
				if($medicalkey == 'major'){
					$keytypeterm 	= '_ia';
					$perfixterm		= '_ia ';
				} else {
					$keytypeterm = '_ib';
					$perfixterm		= '_ib ';
				}
					$medicaldataary[0]['children'][$cnt]['id'] = 'medical-01'.$cnt;
					$medicaldataary[0]['children'][$cnt]['text'] = $keytypeterm;
					
					foreach($medicaldataterm as $mdtkey => $termsdata ){
						$medicaldataary[0]['children'][$cnt]['children'][$mdtkey]['id']		= 'index_medical_term_'.$termsdata->id;
						$medicaldataary[0]['children'][$cnt]['children'][$mdtkey]['text']	= $termsdata->medicalterm;
						if($termsdata->diseaseslink !='Null' && !empty($termsdata->diseaseslink)){
								if(strpos($termsdata->diseaseslink, ',') !== false){
									foreach(explode(',', $termsdata->diseaseslink) as $dlink => $selected){
									$medicaldataary[0]['children'][$cnt]['children'][$mdtkey]['children'][$dlink]['id']		= 'index_medical_term_diseaseslink_'.$termsdata->id.$dlink;
									$medicaldataary[0]['children'][$cnt]['children'][$mdtkey]['children'][$dlink]['text']	= $selected;
									}
								} else {
									$medicaldataary[0]['children'][$cnt]['children'][$mdtkey]['children'][0]['id']		= 'index_medical_term_diseaseslink_'.$termsdata->id;
									$medicaldataary[0]['children'][$cnt]['children'][$mdtkey]['children'][0]['text']	= $termsdata->diseaseslink;
								}
						}
					}
				$cnt++;
			}
			
			
			// Medical Check tags Dat Data
			$matchThese 	= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid, 'pui' => $request->pui];
			$checktagdata 	= DB::table('index_medical_checktag')->where($matchThese)->get()->toArray();
			
			$checktags	=	array();
			
			$checktags[0]['id']		= 'checktags-01';
			$checktags[0]['text']	= 'Checktags';
			foreach($checktagdata as $key => $medicalchktag){
				$checktags[0]['children'][$key]['id'] = 'index_medical_checktag_'.$medicalchktag->id;
				$checktags[0]['children'][$key]['text'] = '_ib '.$medicalchktag->checktag;
			}
			
			
			// Drug Dat Data
			
			$matchThese 	= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid, 'pui' => $request->pui];
			$index_drugdata 	= DB::table('index_drug')->where($matchThese)->get()->toArray();
			
			$drugtermdata = array();
			foreach($index_drugdata as $termgroup){
			   $drugtermdata[$termgroup->type][] = $termgroup;
			}
			
			$drugdataary			=	array();
			$drugdataary[0]['id']	= 'drug-01';
			$drugdataary[0]['text']	= 'Drug';
			$cntdrug=0;
			
			
			foreach($drugtermdata as $drugkey => $drugdataterm){
				if($drugkey == 'major'){
					$keytypeterm 	= '_dsa';
					$perfixterm		= '_dsa ';
				} else {
					$keytypeterm = '_dsb';
					$perfixterm		= '_dsb ';
				}
				
				$drugdataary[0]['children'][$cntdrug]['id'] = 'drug-01'.$cntdrug;
				$drugdataary[0]['children'][$cntdrug]['text'] = $keytypeterm;
				
				
				foreach($drugdataterm as $ddtkey => $termsdata ){
					$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['id']		= 'index_drug'.$termsdata->id;
					$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['text']		= $termsdata->drugterm;
					
					//Drug Other Fields
					//if($termsdata->drugotherfields !='Null' && !empty($termsdata->drugotherfields)){
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][0]['id']		= 'index_drug_drugotherfields'.$termsdata->id;
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][0]['text']		= 'Drug Other Fields';
							if(strpos($termsdata->drugotherfields, ',') !== false){
								$dof = 0;
								foreach(explode(',', $termsdata->drugotherfields) as $dlink => $selected){
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][0]['children'][$dlink]['id']		= 'index_drug_drugotherfields'.$termsdata->id.$dlink;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][0]['children'][$dlink]['text']	= $selected;
								$dof++;
								}
							} else {
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][0]['children'][0]['id']		= 'index_drug_drugotherfields_'.$termsdata->id;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][0]['children'][0]['text']	= $termsdata->drugotherfields;
							}
					//}
					
					
					//Drug Therapy
					//if($termsdata->drugtherapy !='Null' && !empty($termsdata->drugtherapy)){
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][1]['id']		= 'index_drug_drugtherapy'.$termsdata->id;
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][1]['text']		= 'Drug Therapy';
							if(strpos($termsdata->drugtherapy, ',') !== false){
							$dt = 0;
								foreach(explode(',', $termsdata->drugtherapy) as $dlink => $selected){
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][1]['children'][$dlink]['id']		= 'index_drug_drugtherapy'.$termsdata->id.$dlink;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][1]['children'][$dlink]['text']	= $selected;
								$dt++;
								}
							} else {
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][1]['children'][0]['id']		= 'index_drug_drugtherapy_'.$termsdata->id;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][1]['children'][0]['text']	= $termsdata->drugtherapy;
							}
					//}

					
				//Drug dose
					//if($termsdata->drugdose !='Null' && !empty($termsdata->drugdose)){
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][2]['id']		= 'index_drug_drugdose'.$termsdata->id;
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][2]['text']		= 'Drug Dose';
							if(strpos($termsdata->drugdose, ',') !== false){
								foreach(explode(',', $termsdata->drugdose) as $dlink => $selected){
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][2]['children'][$dlink]['id']		= 'index_drug_drugdose'.$termsdata->id.$dlink;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][2]['children'][$dlink]['text']	= $selected;
								}
							} else {
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][2]['children'][0]['id']		= 'index_drug_drugdose_'.$termsdata->id;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][2]['children'][0]['text']	= $termsdata->drugdose;
							}
					//}	
					
				
				//Drug routeofdrug
					//if($termsdata->routeofdrug !='Null' && !empty($termsdata->routeofdrug)){
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][3]['id']		= 'index_drug_routeofdrug'.$termsdata->id;
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][3]['text']		= 'Route of Drug';
							if(strpos($termsdata->routeofdrug, ',') !== false){
								foreach(explode(',', $termsdata->routeofdrug) as $dlink => $selected){
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][3]['children'][$dlink]['id']		= 'index_drug_routeofdrug'.$termsdata->id.$dlink;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][3]['children'][$dlink]['text']	= $selected;
								}
							} else {
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][3]['children'][0]['id']		= 'index_drug_routeofdrug_'.$termsdata->id;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][3]['children'][0]['text']	= $termsdata->routeofdrug;
							}
					//}
					
					//Drug dosefreq
					//if($termsdata->dosefreq !='Null' && !empty($termsdata->dosefreq)){
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][4]['id']		= 'index_drug_dosefreq'.$termsdata->id;
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][4]['text']		= 'Dose Frequency';
							if(strpos($termsdata->dosefreq, ',') !== false){
								foreach(explode(',', $termsdata->dosefreq) as $dlink => $selected){
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][4]['children'][$dlink]['id']		= 'index_drug_dosefreq'.$termsdata->id.$dlink;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][4]['children'][$dlink]['text']	= $selected;
								}
							} else {
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][4]['children'][0]['id']		= 'index_drug_dosefreq_'.$termsdata->id;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][4]['children'][0]['text']	= $termsdata->dosefreq;
							}
					//}
					
					
					//Drug drugcomb
					//if($termsdata->drugcomb !='Null' && !empty($termsdata->drugcomb)){
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][5]['id']		= 'index_drug_drugcomb'.$termsdata->id;
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][5]['text']		= 'Drug Combination';
							if(strpos($termsdata->drugcomb, ',') !== false){
								foreach(explode(',', $termsdata->drugcomb) as $dlink => $selected){
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][5]['children'][$dlink]['id']		= 'index_drug_drugcomb'.$termsdata->id.$dlink;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][5]['children'][$dlink]['text']	= $selected;
								}
							} else {
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][5]['children'][0]['id']		= 'index_drug_drugcomb_'.$termsdata->id;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][5]['children'][0]['text']	= $termsdata->drugcomb;
							}
					//}
					
					
					//Drug advdrug
					//if($termsdata->advdrug !='Null' && !empty($termsdata->advdrug)){
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][6]['id']		= 'index_drug_advdrug'.$termsdata->id;
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][6]['text']		= 'Adverse Drug Reaction';
							if(strpos($termsdata->advdrug, ',') !== false){
								foreach(explode(',', $termsdata->advdrug) as $dlink => $selected){
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][6]['children'][$dlink]['id']		= 'index_drug_advdrug'.$termsdata->id.$dlink;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][6]['children'][$dlink]['text']	= $selected;
								}
							} else {
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][6]['children'][0]['id']		= 'index_drug_advdrug_'.$termsdata->id;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][6]['children'][0]['text']	= $termsdata->advdrug;
							}
					//}
				
					//Drug drugcomp
					//if($termsdata->drugcomp !='Null' && !empty($termsdata->drugcomp)){
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][7]['id']		= 'index_drug_drugcomp'.$termsdata->id;
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][7]['text']		= 'Drug Comparison';
							if(strpos($termsdata->drugcomp, ',') !== false){
								foreach(explode(',', $termsdata->drugcomp) as $dlink => $selected){
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][7]['children'][$dlink]['id']		= 'index_drug_drugcomp'.$termsdata->id.$dlink;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][7]['children'][$dlink]['text']	= $selected;
								}
							} else {
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][7]['children'][0]['id']		= 'index_drug_drugcomp_'.$termsdata->id;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][7]['children'][0]['text']	=  $termsdata->drugcomp;
							}
					//}
					
					//Drug drugdosage
					//if($termsdata->drugdosage !='Null' && !empty($termsdata->drugdosage)){
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][8]['id']		= 'index_drug_drugdosage'.$termsdata->id;
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][8]['text']		= 'Drug Dosage';
							if(strpos($termsdata->drugdosage, ',') !== false){
								foreach(explode(',', $termsdata->drugdosage) as $dlink => $selected){
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][8]['children'][$dlink]['id']		= 'index_drug_drugdosage'.$termsdata->id.$dlink;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][8]['children'][$dlink]['text']	=  $selected;
								}
							} else {
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][8]['children'][0]['id']		= 'index_drug_drugdosage_'.$termsdata->id;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][8]['children'][0]['text']	=  $termsdata->drugdosage;
							}
					//}
					
					//Drug druginteraction
					//if($termsdata->druginteraction !='Null' && !empty($termsdata->druginteraction)){
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['id']		= 'index_drug_druginteraction'.$termsdata->id;
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['text']		= 'Drug Interaction';
							if(strpos($termsdata->druginteraction, ',') !== false){
								foreach(explode(',', $termsdata->druginteraction) as $dlink => $selected){
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['children'][$dlink]['id']		= 'index_drug_druginteraction'.$termsdata->id.$dlink;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['children'][$dlink]['text']	=  $selected;
								}
							} else {
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['children'][0]['id']		= 'index_drug_druginteraction_'.$termsdata->id;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['children'][0]['text']	=  $termsdata->druginteraction;
							}
					//}
					
					//Drug specialpharma
					//if($termsdata->specialpharma !='Null' && !empty($termsdata->specialpharma)){
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['id']		= 'index_drug_specialpharma'.$termsdata->id;
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['text']		= 'Special Situtation for Pharmacovigilance';
							if(strpos($termsdata->specialpharma, ',') !== false){
								foreach(explode(',', $termsdata->specialpharma) as $dlink => $selected){
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['children'][$dlink]['id']		= 'index_drug_specialpharma'.$termsdata->id.$dlink;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['children'][$dlink]['text']	=  $selected;
								}
							} else {
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['children'][0]['id']		= 'index_drug_specialpharma_'.$termsdata->id;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['children'][0]['text']	=  $termsdata->specialpharma;
							}
					//}
					
					//Drug unexpecteddrugtreatment
					//if($termsdata->unexpecteddrugtreatment !='Null' && !empty($termsdata->unexpecteddrugtreatment)){
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['id']		= 'index_drug_unexpecteddrugtreatment'.$termsdata->id;
						$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['text']		= 'Unexpected Outcome of Drug Treatment';
							if(strpos($termsdata->unexpecteddrugtreatment, ',') !== false){
								foreach(explode(',', $termsdata->unexpecteddrugtreatment) as $dlink => $selected){
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['children'][$dlink]['id']		= 'index_drug_unexpecteddrugtreatment'.$termsdata->id.$dlink;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['children'][$dlink]['text']	=  $selected;
								}
							} else {
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['children'][0]['id']		= 'index_drug_unexpecteddrugtreatment_'.$termsdata->id;
								$drugdataary[0]['children'][$cntdrug]['children'][$ddtkey]['children'][9]['children'][0]['text']	= $termsdata->unexpecteddrugtreatment;
							}
					//}
					
					
				}
			$cntdrug++;
			}
			
			
			// Drug Trade Dat Data
			$matchThese 		= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid, 'pui' => $request->pui];
			$drugtradenamedata 	= DB::table('drugtradename')->where($matchThese)->get()->toArray();
			
			$drugtradenametermdata = array();
			foreach($drugtradenamedata as $termgroup){
			   $drugtradenametermdata[$termgroup->type][] = $termgroup;
			}
			$drugtradenamedataary	=	array();
			$drugtradenamedataary[0]['id']	= 'drugtradename-01';
			$drugtradenamedataary[0]['text']	= 'Drugtradename';
			$cnt=0;
			foreach($drugtradenametermdata as $drugtradenamekey => $drugtradenamedataterm){
			
				if($drugtradenamekey == 'ma'){
					$keytypeterm 	= '_ma';
					$perfixterm		= '_ma ';
				} else {
					$keytypeterm = '_tr';
					$perfixterm		= '_tr ';
				}
					$drugtradenamedataary[0]['children'][$cnt]['id'] = 'drugtradename-01'.$cnt;
					$drugtradenamedataary[0]['children'][$cnt]['text'] = $keytypeterm;
					
					foreach($drugtradenamedataterm as $mdtkey => $termsdata ){
						$drugtradenamedataary[0]['children'][$cnt]['children'][$mdtkey]['id']		= 'drugtradename_'.$termsdata->id;
						$drugtradenamedataary[0]['children'][$cnt]['children'][$mdtkey]['text']	=  @$termsdata->manufacturename;
						if($termsdata->tradename !='Null' && !empty($termsdata->tradename)){
								if(strpos($termsdata->tradename, ',') !== false){
									foreach(explode(',', $termsdata->tradename) as $dlink => $selected){
									$drugtradenamedataary[0]['children'][$cnt]['children'][$mdtkey]['children'][$dlink]['id']		= 'drugtradename_tradename_'.$termsdata->id.$dlink;
									$drugtradenamedataary[0]['children'][$cnt]['children'][$mdtkey]['children'][$dlink]['text']	= $selected;
									}
								} else {
									$drugtradenamedataary[0]['children'][$cnt]['children'][$mdtkey]['children'][0]['id']		= 'drugtradename_tradename_'.$termsdata->id;
									$drugtradenamedataary[0]['children'][$cnt]['children'][$mdtkey]['children'][0]['text']	= $termsdata->tradename;
								}
						}
					}
				$cnt++;
			}
			
			
			
			// Device Trade Dat Data
			$matchThese 		= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid, 'pui' => $request->pui];
			$devicetradenamedata 	= DB::table('devicetradename')->where($matchThese)->get()->toArray();
			
			$devicetradenametermdata = array();
			foreach($devicetradenamedata as $termgroup){
			   $devicetradenametermdata[$termgroup->type][] = $termgroup;
			}
			$devicetradenamedataary	=	array();
			$devicetradenamedataary[0]['id']	= 'devicetradename-01';
			$devicetradenamedataary[0]['text']	= 'Devicetradename';
			$cnt=0;
			foreach($devicetradenametermdata as $devicetradenamekey => $devicetradenamedataterm){
			
				if($devicetradenamekey == 'mv'){
					$keytypeterm 	= '_mv';
					$perfixterm		= '_mv ';
				} else {
					$keytypeterm = '_tv';
					$perfixterm		= '_tv ';
				}
					$devicetradenamedataary[0]['children'][$cnt]['id'] = 'devicetradename-01'.$cnt;
					$devicetradenamedataary[0]['children'][$cnt]['text'] = $keytypeterm;
					
					foreach($devicetradenamedataterm as $mdtkey => $termsdata ){
						$devicetradenamedataary[0]['children'][$cnt]['children'][$mdtkey]['id']		= 'devicetradename_'.$termsdata->id;
						$devicetradenamedataary[0]['children'][$cnt]['children'][$mdtkey]['text']	=  @$termsdata->manufacturename;
						if($termsdata->tradename !='Null' && !empty($termsdata->tradename)){
								if(strpos($termsdata->tradename, ',') !== false){
									foreach(explode(',', $termsdata->tradename) as $dlink => $selected){
									$devicetradenamedataary[0]['children'][$cnt]['children'][$mdtkey]['children'][$dlink]['id']		= 'devicetradename_tradename_'.$termsdata->id.$dlink;
									$devicetradenamedataary[0]['children'][$cnt]['children'][$mdtkey]['children'][$dlink]['text']	= $selected;
									}
								} else {
									$devicetradenamedataary[0]['children'][$cnt]['children'][$mdtkey]['children'][0]['id']		= 'devicetradename_tradename_'.$termsdata->id;
									$devicetradenamedataary[0]['children'][$cnt]['children'][$mdtkey]['children'][0]['text']	=  $termsdata->tradename;
								}
						}
					}
				$cnt++;
			}
			
			
			
			// CTN Dat Data
			$matchThese 		= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid, 'pui' => $request->pui];
			$ctndata 	= DB::table('ctn')->where($matchThese)->get()->toArray();
			
			$ctndataary	=	array();
			$ctndataary[0]['id']	= 'ctn-01';
			$ctndataary[0]['text']	= 'CTN';
			
			foreach($ctndata as $ctnkey => $ctndataterm){
				$ctndataary[0]['children'][$ctnkey]['id'] = 'ctn-01'.$ctnkey;
				$ctndataary[0]['children'][$ctnkey]['text'] = $ctndataterm->registryname;
					if(strpos($ctndataterm->trailnumber, ',') !== false){
						foreach(explode(',', $ctndataterm->trailnumber) as $dlink => $selected){
						$ctndataary[0]['children'][$ctnkey]['children'][$dlink]['id']		= ''.$ctndataterm->id.$dlink;
						$ctndataary[0]['children'][$ctnkey]['children'][$dlink]['text']	=  $selected;
						}
					} else {
						$ctndataary[0]['children'][$ctnkey]['children'][0]['id']		= 'ctn_trailnumber_'.$ctndataterm->id;
						$ctndataary[0]['children'][$ctnkey]['children'][0]['text']	= $ctndataterm->trailnumber;
					}
			}
			
			
			
			// Medical Device Indexing Dat Data
			$matchThese 	= ['user_id' => \Auth::id(), 'jobid' => $request->jobid, 'orderid' => $request->orderid, 'pui' => $request->pui];
			$medicaldevicedata 	= DB::table('medicaldevice')->where($matchThese)->get()->toArray();
			
			
			
			$medicaldevicetermdata = array();
			foreach($medicaldevicedata as $termgroup){
			   $medicaldevicetermdata[$termgroup->type][] = $termgroup;
			}
			$medicaldevicedataary	=	array();
			$medicaldevicedataary[0]['id']	= 'medicaldevice-01';
			$medicaldevicedataary[0]['text']	= 'Medicaldevice';
			$cnt=0;
			foreach($medicaldevicetermdata as $medicaldevicekey => $medicaldevicedataterm){
			
				if($medicaldevicekey == 'major'){
					$keytypeterm 	= '_dva';
					$perfixterm		= '_dva ';
				} else {
					$keytypeterm = '_dvb';
					$perfixterm		= '_dvb ';
				}
					$medicaldevicedataary[0]['children'][$cnt]['id'] = 'medicaldevice-01'.$cnt;
					$medicaldevicedataary[0]['children'][$cnt]['text'] = $keytypeterm;
					
					foreach($medicaldevicedataterm as $mdtkey => $termsdata ){
						$medicaldevicedataary[0]['children'][$cnt]['children'][$mdtkey]['id']		= 'medicaldevice_'.$termsdata->id;
						$medicaldevicedataary[0]['children'][$cnt]['children'][$mdtkey]['text']	=  $termsdata->deviceterm;
						
						
						
						
						if($termsdata->sublink !='Null' && !empty($termsdata->sublink)){
								if(strpos($termsdata->sublink, ',') !== false){
									foreach(explode(',', $termsdata->sublink) as $dlink => $selected){
									$medicaldevicedataary[0]['children'][$cnt]['children'][$mdtkey]['children'][$dlink]['id']		= 'medicaldevice_sublink_'.$termsdata->id.$dlink;
									$medicaldevicedataary[0]['children'][$cnt]['children'][$mdtkey]['children'][$dlink]['text']	= $selected;
									}
								} else {
									$medicaldevicedataary[0]['children'][$cnt]['children'][$mdtkey]['children'][0]['id']		= 'medicaldevice_sublink__'.$termsdata->id;
									$medicaldevicedataary[0]['children'][$cnt]['children'][$mdtkey]['children'][0]['text']	= $termsdata->sublink;
								}
						}
					}
				$cnt++;
			}

			
			
			$data = array_merge($dataary,$medicaldataary,$checktags,$drugdataary,$drugtradenamedataary,$devicetradenamedataary,$ctndataary,$medicaldevicedataary);
			
			
			//$data = array_merge($dataary,$medicaldataary,$checktags,$drugdataary);
			
			//$data =$medicaldevicedataary;
			
			$filepath = getcwd().'/datfileview/'.$request->jobid.'_'.$request->orderid.'_'.str_replace('_pui ','',$request->pui).'.json';
			if (file_exists ( $filepath )) {
				unlink($filepath);
			}
			$fp = fopen($filepath, 'a');
			fwrite($fp, json_encode($data));
			fclose($fp);
			
			return ajaxResponse(
						[
							'message'  => langapp('saved_successfully')
						],
						true,
						Response::HTTP_CREATED
					);
	}		
}
