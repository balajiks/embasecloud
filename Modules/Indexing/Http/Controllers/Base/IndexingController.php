<?php

namespace Modules\Indexing\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\CSVRequest;
use App\Http\Requests\EmailRequest;
use App\Notifications\WhatsAppSubscribe;
use DataTables;
use Illuminate\Http\Request;
use Modules\Files\Helpers\Uploader;
use Modules\Indexing\Emails\indexingBulkEmail;
use Modules\Indexing\Emails\RequestConsent;
use Modules\Indexing\Entities\Indexing;
use Modules\Indexing\Exports\indexingExport;
use Modules\Indexing\Helpers\IndexingCsvProcessor;
use Modules\Indexing\Http\Requests\BulkSendRequest;
use Modules\Indexing\Jobs\BulkDeleteindexing;
use Modules\Messages\Entities\Emailing;
use Modules\Users\Entities\User;
use DB;

abstract class indexingController extends Controller
{
    /**
     * Indexing model
     *
     * @var \Modules\Indexing\Entities\Indexing
     */
    public $indexing;
    /**
     * Request instance
     *
     * @var \Illuminate\Http\Request
     */
    public $request;
    /**
     * Indexing display type kanban|table
     *
     * @var string
     */
    public $displayType;
	
	protected $user;

    public function __construct(Indexing $indexing, Request $request,User $user)
    {
        $this->middleware(['auth', 'verified', '2fa', 'can:menu_indexing']);
        $this->displayType 	= request('view', 'kanban');
        $this->request     	= $request;
        $this->indexing     = $indexing;
		$this->user    		= $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
		$this->userId = \Auth::id();
		$loggeduserrole =  \Auth::user()->profile->userrole;
		
		if($loggeduserrole == '2'){
			$jobdata = DB::table('projects')->where('qc', 'admin')->where('jobstatus', 'onprocess')->first();
			if(empty($jobdata)){
				$jobdata = DB::table('projects')->where('qc', 'admin')->where('jobstatus', 'pending')->first();
			}
		} else {
			$jobdata = DB::table('projects')->where('indexer', 'admin')->where('jobstatus', 'onprocess')->first();
			if(empty($jobdata)){
				$jobdata = DB::table('projects')->where('indexer', 'admin')->where('jobstatus', 'pending')->first();
			}
		}
		
		if($jobdata->id !=''){
			$matchThese 		= ['user_id' => \Auth::id(), 'pui' => $jobdata->pui, 'jobid' => $jobdata->id, 'orderid' => $jobdata->orderid];
			$repositoryname 	= DB::table('datasections')->where($matchThese)->get()->toArray();
			
			$conditionValues	= ['user_id' => \Auth::id(), 'pubchoice' => '+', 'pui' => $jobdata->pui, 'jobid' => $jobdata->id, 'orderid' => $jobdata->orderid];
			$pubchoicecount 	= DB::table('datasections')->where($conditionValues)->count();
		}
		
		
		$tabmenu				= 'indexermeta';
		$tab 					= 'section';
		$allowedTabs    		= ['section', 'medical', 'drug', 'drugtradename', 'mdt', 'ctn', 'msn', 'mdi'];
        $data['tab']    		= in_array($tab, $allowedTabs) ? $tab : 'section';
		$data['page']        	= $this->getPage();
        $data['displayType'] 	= $this->getDisplayType();
        $data['filter']      	= $this->request->filter;
		$data['jobdata']      	= $jobdata;
		$data['sectioncount']   = count($repositoryname);
		$data['pubchoicecount'] = $pubchoicecount;
		$data['tabmenu']   		= $tabmenu;
		
        return view('indexing::index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Indexing $indexing, $tab = 'section', $option = null)
    {
		$allowedTabs    = ['section', 'medical', 'drug', 'drugtradename', 'mdt', 'ctn', 'msn', 'mdi'];
        $data['tab']    		= in_array($tab, $allowedTabs) ? $tab : 'section';
		$data['page']        	= $this->getPage();
		$data['displayType'] 	= $this->getDisplayType();
        $data['filter']      	= $this->request->filter;
		$data['indexing']   	= $indexing;
		$data['option'] 		= $option;
	    return view('indexing::create')->with($data);
    }
	
	
	 /**
     * Display the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function addindexing(Indexing $indexing, $tab = 'section', $option = null)
    {
       $this->userId = \Auth::id();
		$loggeduserrole =  \Auth::user()->profile->userrole;
		
		
		//Get JOB 
		if($loggeduserrole == '2'){
			$jobdata = DB::table('projects')->where('qc', 'admin')->where('jobstatus', 'onprocess')->first();
			if(empty($jobdata)){
				$jobdata = DB::table('projects')->where('qc', 'admin')->where('jobstatus', 'pending')->first();
			}
		} else {
			$jobdata = DB::table('projects')->where('indexer', 'admin')->where('jobstatus', 'onprocess')->first();
			if(empty($jobdata)){
				$jobdata = DB::table('projects')->where('indexer', 'admin')->where('jobstatus', 'pending')->first();
			}
		}
		
		
		
		if($jobdata->id !=''){
			$matchThese 		= ['user_id' => \Auth::id(), 'pui' => $jobdata->pui, 'jobid' => $jobdata->id, 'orderid' => $jobdata->orderid];
			$datasections 		= DB::table('datasections')->where($matchThese)->get()->toArray();
			
			$conditionValues	= ['user_id' => \Auth::id(), 'pubchoice' => '+', 'pui' => $jobdata->pui, 'jobid' => $jobdata->id, 'orderid' => $jobdata->orderid];
			$pubchoicecount 	= DB::table('datasections')->where($conditionValues)->count();
		}
		
		
		
		
		
		// FIELD 3
		$diseaseslink 	= DB::table('diseases')->where('status', 1)->get()->toArray();
		$minorchecktags = DB::table('minorchecktags')->where('status', 1)->get()->toArray();
		$mmt_ct_list = array();
		foreach($minorchecktags as $checktag){
		   $mmt_ct_list[$checktag->type][] = $checktag;
		}
		
		
		// FIELD 4
		$drugotherfields		= DB::table('drug_otherfield')->where('status', 1)->get()->toArray();
		$drugunits 				= DB::table('drugunits')->where('status', 1)->get()->toArray();
		$routedrugadmins 		= DB::table('routedrugadmins')->where('status', 1)->get()->toArray();
		$dosefrequencys 		= DB::table('dosefrequencys')->where('status', 1)->get()->toArray();
		$drugdosescheduleterms 	= DB::table('drugdosescheduleterms')->where('status', 1)->get()->toArray();		
		$specialsituations 		= DB::table('specialsituations')->where('status', 1)->get()->toArray();
		$unexpectedoutcomes 	= DB::table('unexpectedoutcomes')->where('status', 1)->get()->toArray();
		
		
		// FIELD 5
		$registries 	= DB::table('registries')->where('status', 1)->get()->toArray();
		
		// FIELD 6
		$repositoryname 	= DB::table('repositoryname')->where('status', 1)->get()->toArray();
		
		$allowedTabs    					= 	['section', 'medical', 'drug', 'drugtradename', 'mdt', 'ctn', 'msn', 'mdi'];
        $data['tab']    					= 	in_array($tab, $allowedTabs) ? $tab : 'section';
		$data['page']        				= 	$this->getPage();
        $data['displayType'] 				= 	$this->getDisplayType();
        $data['filter']      				= 	$this->request->filter;
		$data['jobdata']      				= 	$jobdata;
		$data['diseaseslink']   			= 	$diseaseslink;
		$data['mmt_ct_list']   				=  	$mmt_ct_list;
		$data['drugunits']   				=  	$drugunits;
		$data['routedrugadmins']   			=  	$routedrugadmins;
		$data['dosefrequencys']   			=  	$dosefrequencys;
		$data['drugdosescheduleterms']   	=  	$drugdosescheduleterms;
		$data['specialsituations']   		=  	$specialsituations;
		$data['unexpectedoutcomes']   		=  	$unexpectedoutcomes;
		$data['registries']   				=  	$registries;
		$data['repositoryname']   			=  	$repositoryname;
		$data['sectioncount']   			=   count($datasections);
		$data['drugotherfields']   			=   $drugotherfields;
		$tabmenu							=   'indexermeta';
		$data['tabmenu']   					=   $tabmenu;
		$data['pubchoicecount'] = $pubchoicecount;
		
		
        return view('indexing::index')->with($data);
    }
	
	public function showmeta($id){
		$jobmetainfo 			= DB::table('projects')->where('id', $id)->get()->toArray();
		$data['jobmetainfo']    = $jobmetainfo;
		return view('indexing::modal.showmeta')->with($data);
	}
	
	public function showsource($id){
		$jobsourceinfo 			= DB::table('projects')->where('id', $id)->get()->toArray();
		$data['jobsourceinfo']  = $jobsourceinfo;
		$data['page']        	= $this->getPage();
        $data['displayType'] 	= $this->getDisplayType();
        $data['filter']      	= $this->request->filter;
		return view('indexing::showsource')->with($data);
	}
	
	public function showemtree($id){
		$jobsourceinfo 			= DB::table('projects')->where('id', $id)->get()->toArray();
		$data['jobsourceinfo']  = $jobsourceinfo;
		$data['page']        	= $this->getPage();
        $data['displayType'] 	= $this->getDisplayType();
        $data['filter']      	= $this->request->filter;
		
		return view('indexing::showemtree')->with($data);
	}
	
	public function ajaxapivalidation($id){
		$jobsourceinfo 			= DB::table('projects')->where('id', $id)->get()->toArray();
		$data['jobsourceinfo']  = $jobsourceinfo;
	
		$jobid = $jobsourceinfo[0]->id;
		$orderid = $jobsourceinfo[0]->orderid;	
		$pui = $jobsourceinfo[0]->pui;	
		
		//print '<pre>';
		
		$data = array();
		// Section Dat Data
		$matchThese 	= ['user_id' => \Auth::id(), 'jobid' => $jobid, 'orderid' => $orderid, 'pui' => $pui];
		$sectiondata 	= DB::table('datasections')->where($matchThese)->get()->toArray();
		
		$dataary	=	array();
		
			
		foreach($sectiondata as $key => $section){
			$dataary['section_list'][$key]['Section'] 			= $section->sectionval;
			$dataary['section_list'][$key]['PublicationChoice'] = '';
			$dataary['section_list'][$key]['Classifications'] 	= [];
		}
		
		
		
		
		// Medical Dat Data
		$matchThese 	= ['user_id' => \Auth::id(), 'jobid' => $jobid, 'orderid' => $orderid, 'pui' => $pui];
		$medicaldata 	= DB::table('index_medical_term')->where($matchThese)->get()->toArray();
		
		
		foreach($medicaldata as $key => $medical){
		
		if($medical->type == 'major'){ $typekey = '_ia'; } else {$typekey = '_ib'; }
		if($medical->termtype == 'DIS'){ $typediease = 'true'; } else {$typediease = 'false'; }
		
		if(@$medical->diseaseslink !='' && @$medical->diseaseslink !='Null'){ $diseases = explode(',',@$medical->diseaseslink); } else {$diseases = []; }
		
		
			$dataary['medical_list'][$key]['FieldType'] 			= ucwords($medical->type).$typekey;
			$dataary['medical_list'][$key]['FieldValue'] 			= $medical->medicalterm;
			$dataary['medical_list'][$key]['DiseaseLinks'] 			= $diseases;
			$dataary['medical_list'][$key]['IsDiseaseTerm'] 		= $typediease;
		}
		
		
		
		
		
		
		
		// Medical Check tags Dat Data
		$matchThese 	= ['user_id' => \Auth::id(), 'jobid' => $jobid, 'orderid' => $orderid, 'pui' => $pui];
		$checktagdata 	= DB::table('index_medical_checktag')->where($matchThese)->get()->toArray();
		
		foreach($checktagdata as $key => $medicalchktag){
			$dataary['medical_list'][$key+count($medicaldata)]['FieldType'] = 'Minor_ib_Checktags';
			$dataary['medical_list'][$key+count($medicaldata)]['FieldValue'] = $medicalchktag->checktag;
			$dataary['medical_list'][$key+count($medicaldata)]['DiseaseLinks'] 			= [];
			$dataary['medical_list'][$key+count($medicaldata)]['IsDiseaseTerm'] 		= 'false';
		}
		
		//$dataary = json_encode($dataary);
		//print_r($dataary);
		//exit;
		// Drug Dat Data
		
		$matchThese 	= ['user_id' => \Auth::id(), 'jobid' => $jobid, 'orderid' => $orderid, 'pui' => $pui];
		$index_drugdata 	= DB::table('index_drug')->where($matchThese)->get()->toArray();
		
		foreach($index_drugdata as $key =>  $drugdataterm){
			if($drugdataterm->type == 'major'){ $typekey = '_dsa'; } else {$typekey = '_dsb'; }
			
			
			 if(@!empty($drugdataterm->drugotherfields)) {
			 	 $drugotherfields	= explode(',',@$drugdataterm->drugotherfields);
			 } else {
			 	 $drugotherfields= [];
			}
			
			if(@!empty($drugdataterm->drugtherapy)) {
			 	 $drugtherapy	= explode(',',@$drugdataterm->drugtherapy);
			 } else {
			 	 $drugtherapy= [];
			}
			
			if(@!empty($drugdataterm->routeofdrug)) {
			 	 $routeofdrug	= explode(',',@$drugdataterm->routeofdrug);
			 } else {
			 	 $routeofdrug= [];
			}
			
			if(@!empty($drugdataterm->drugdose)) {
			 	 $drugdose	= explode(',',@$drugdataterm->drugdose);
			 } else {
			 	 $drugdose= [];
			}
			
			if(@!empty($drugdataterm->dosefreq)) {
			 	 $dosefreq	= explode(',',@$drugdataterm->dosefreq);
			 } else {
			 	 $dosefreq= [];
			}
			
			if(@!empty($drugdataterm->drugcomb)) {
			 	 $drugcomb	= explode(',',@$drugdataterm->drugcomb);
			 } else {
			 	 $drugcomb= [];
			}
			
			if(@!empty($drugdataterm->advdrug)) {
			 	 $advdrug	= explode(',',@$drugdataterm->advdrug);
			 } else {
			 	 $advdrug= [];
			}
			
			if(@!empty($drugdataterm->drugcomp)) {
			 	 $drugcomp	= explode(',',@$drugdataterm->drugcomp);
			 } else {
			 	 $drugcomp= [];
			}
			
			if(@!empty($drugdataterm->drugdosage)) {
			 	 $drugdosage	= explode(',',@$drugdataterm->drugdosage);
			 } else {
			 	 $drugdosage= [];
			}
			
			if(@!empty($drugdataterm->druginteraction)) {
			 	 $druginteraction	= explode(',',@$drugdataterm->druginteraction);
			 } else {
			 	 $druginteraction= [];
			}
			
			if(@!empty($drugdataterm->specialpharma)) {
			 	 $specialpharma	= explode(',',@$drugdataterm->specialpharma);
			 } else {
			 	 $specialpharma= [];
			}
			
			if(@!empty($drugdataterm->unexpecteddrugtreatment)) {
			 	 $unexpecteddrugtreatment	= explode(',',@$drugdataterm->unexpecteddrugtreatment);
			 } else {
			 	 $unexpecteddrugtreatment= [];
			}
			
			$dataary['drug_list'][$key]['FieldType'] 												= ucwords($drugdataterm->type).$typekey;
			$dataary['drug_list'][$key]['FieldValue'] 												= $drugdataterm->drugterm;
			$dataary['drug_list'][$key]['OtherDruglinks_Obj']['OtherDrugLinks'] 					= $drugotherfields;
			$dataary['drug_list'][$key]['OtherDruglinks_Obj']['DrugTherapy'] 						= $drugtherapy;
			$dataary['drug_list'][$key]['OtherDruglinks_Obj']['RouteOfDrugAdministration'] 			= $routeofdrug;
			$dataary['drug_list'][$key]['OtherDruglinks_Obj']['DrugDoseInfo'] 						= $drugdose;
			$dataary['drug_list'][$key]['OtherDruglinks_Obj']['DoseFrequency'] 						= $dosefreq;
			$dataary['drug_list'][$key]['OtherDruglinks_Obj']['DrugCombination'] 					= $drugcomb;
			$dataary['drug_list'][$key]['OtherDruglinks_Obj']['ADR'] 								= $advdrug;
			$dataary['drug_list'][$key]['OtherDruglinks_Obj']['Dcmp'] 								= $drugcomp;
			$dataary['drug_list'][$key]['OtherDruglinks_Obj']['DrugDosageScheduleTerms'] 			= $drugdosage;
			$dataary['drug_list'][$key]['OtherDruglinks_Obj']['DrgInteraction'] 					= $druginteraction;
			$dataary['drug_list'][$key]['OtherDruglinks_Obj']['specialsituationpharmacovigilance'] 	= $specialpharma;
			$dataary['drug_list'][$key]['OtherDruglinks_Obj']['unexpectedoutcomedrugtreatment'] 	= $unexpecteddrugtreatment;
		}
		
		
		
		// Drug Trade Dat Data
		$matchThese 		= ['user_id' => \Auth::id(), 'jobid' => $jobid, 'orderid' => $orderid, 'pui' => $pui];
		$drugtradenamedata 	= DB::table('drugtradename')->where($matchThese)->get()->toArray();
		
		foreach($drugtradenamedata as $key => $termgroup){
			$dataary['drugtradename_list'][$key]['FieldCode'] 			= '_'.$termgroup->type;
			$dataary['drugtradename_list'][$key]['DrugManufacture'] 	= $termgroup->manufacturename;
			$dataary['drugtradename_list'][$key]['DrugNames'] 			= explode(',',@$termgroup->tradename);
			$dataary['drugtradename_list'][$key]['CountryCode'] 		= $termgroup->countrycode;
			
		}
		
		
		// Device Trade Dat Data
		$matchThese 		= ['user_id' => \Auth::id(), 'jobid' => $jobid, 'orderid' => $orderid, 'pui' => $pui];
		$devicetradenamedata 	= DB::table('devicetradename')->where($matchThese)->get()->toArray();
		
		foreach($devicetradenamedata as $key =>  $termgroup){
			
			$dataary['devicename_list'][$key]['FieldCode'] 			= '_'.$termgroup->type;
			$dataary['devicename_list'][$key]['Manufacture'] 		= $termgroup->manufacturename;
			$dataary['devicename_list'][$key]['TradeNames'] 		= explode(',',@$termgroup->tradename);
			$dataary['devicename_list'][$key]['CountryCode'] 		= $termgroup->countrycode;
			
		}
		
		
		// CTN Dat Data
		$matchThese 	= ['user_id' => \Auth::id(), 'jobid' => $jobid, 'orderid' => $orderid, 'pui' => $pui];
		$ctndata 		= DB::table('ctn')->where($matchThese)->get()->toArray();
		
		foreach($ctndata as $key => $ctndataterm){
			$dataary['ctn_list'][$key]['RegistryCode'] 	= $ctndataterm->registryname;	
			$dataary['ctn_list'][$key]['CTNs'][] 		= $ctndataterm->trailnumber;
		}
		
		
		// Medical Device Indexing Dat Data
		$matchThese 	= ['user_id' => \Auth::id(), 'jobid' => $jobid, 'orderid' => $orderid, 'pui' => $pui];
		$medicaldevicedata 	= DB::table('medicaldevice')->where($matchThese)->get()->toArray();
		
		
		
		foreach($medicaldevicedata as $key => $medicaltermdata){
		
		if($medicaltermdata->type == 'major'){ $typekey = '_dva'; } else {$typekey = '_dvb'; }
			$dataary['medicaldevice_list'][$key]['MedicalDeviceType'] 			= ucwords($medicaltermdata->type).$typekey;
			$dataary['medicaldevice_list'][$key]['DeviceTerm'] 			= $medicaltermdata->deviceterm;
			
			$dataary['medicaldevice_list'][$key]['DeviceLinks'][]['DeviceLinkType'] 			= str_replace(' ','',(ucwords($medicaltermdata->devicelink)));
			$dataary['medicaldevice_list'][$key]['DeviceLinks'][]['SubLinks'] 			= explode(',',@$medicaltermdata->sublink);
		}
		
		
		
		//$dataary = json_encode($dataary);
		
	
		
		
		$datametaary = array();
		
		
		
		
		$datametaary['carid']						=	$jobsourceinfo[0]->carid;
		$datametaary['orderid']						=	$jobsourceinfo[0]->orderid;
		$datametaary['pui']							=	$jobsourceinfo[0]->pui;
		$datametaary['unitid']						=	$jobsourceinfo[0]->unitid;
		$datametaary['parcelId']					=	'none';
		$datametaary['supplierID']					=	'5';
		$datametaary['IsAbstractAvailable']			=	false;
		$datametaary['IsPublicationAvailable']		=	false;
		
		//$datametaary = json_encode($datametaary);
		
		$opsbankary = array();
		$opsbankary['RequestID'] = date('ymdHis').uniqid(true);
		$opsbankary['MetadataObj'] = $datametaary;
		$opsbankary['IndexData'] = $dataary;
		
		
		
		$requestdata = json_encode($opsbankary);
		
		
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://localhost:5000/api/emtreegeneration/generate_opsbank2_xml3",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>  $requestdata,
		  CURLOPT_HTTPHEADER => array(
							'Content-Type: application/json',
							),

		 
		));
		$output = curl_exec($curl);
		curl_close($curl);
		
		
	
		$output = json_decode($output,true);
		
		
		$data['page'] 			= 'showopsbank';
		$data['output'] 		= base64_encode($output['OPSBankII_XML_Content']);
		$data['errorlist'] 		= $output['ErrorList'];
		$data['ErrorCount'] 	= $output['ErrorCount'];
		$data['WarningCount'] 	= $output['WarningCount'];
		$data['jobid'] 			= $jobsourceinfo[0]->id;
		$data['orderid'] 		= $jobsourceinfo[0]->orderid;
		$data['pui'] 			= $jobsourceinfo[0]->pui;

        return view('indexing::modal.showopsbank')->with($data);
		
	
	
	
	
	
	}
	
	/**
     * Show the form for creating a new section resource.
     *
     * @return \Illuminate\View\View
     */
    public function createsection()
    {
		print '<pre>ASAsAS';
		//print_r($indexing);
		///print_r($request);
		exit;	
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
     * Display the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function view(Indexing $indexing, $tab = 'overview', $option = null)
    {
        $allowedTabs    = ['activity', 'calendar', 'comments', 'compose', 'conversations', 'files', 'calls', 'overview', 'whatsapp'];
        $data['tab']    = in_array($tab, $allowedTabs) ? $tab : 'overview';
        $data['page']   = $this->getPage();
        $data['indexing']   = $indexing;
        $data['option'] = $option;

        return view('indexing::view')->with($data);
    }
	
	

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function edit(Indexing $indexing)
    {
        $data['indexing'] = $indexing;
        return view('indexing::modal.update')->with($data);
    }
    /**
     * Show modal to convert indexing
     */
    public function convert(Indexing $indexing)
    {
        $data['indexing'] = $indexing;
        return view('indexing::modal.convert')->with($data);
    }

    /**
     * Export indexing as CSV
     */
    public function export()
    {
        if (isAdmin()) {
            return (new indexingExport)->download('indexing_' . now()->toIso8601String() . '.csv');
        }
        abort(404);
    }
    /**
     * Show import indexing form
     */
    public function import()
    {
        if ($this->request->type == 'google') {
            return $this->importGoogleContacts();
        }

        $data['page'] = $this->getPage();

        return view('indexing::modal.uploadcsv')->with($data);
    }

    public function nextStage(Indexing $indexing)
    {
        $data['indexing'] = $indexing;
        return view('indexing::modal.next_stage')->with($data);
    }

    public function parseImport(CSVRequest $request, \App\Helpers\ExcelImport $importer)
    {
        $dt['page'] = $this->getPage();
        $path       = $request->file('csvfile')->getRealPath();
        if ($request->has('header')) {
            $data = $importer->getData($path);
        } else {
            $data = array_map('str_getcsv', file($path));
        }
        if (count($data) > 0) {
            if ($request->has('header')) {
                $csv_header_fields = [];
                foreach ($data[0] as $key => $value) {
                    $csv_header_fields[] = $key;
                }
            }
            $csv_data      = array_slice($data, 0, 2);
            $csv_data_file = \App\Entities\CsvData::create(
                [
                    'csv_filename' => $request->file('csvfile')->getClientOriginalName(),
                    'csv_header'   => $request->has('header'),
                    'csv_data'     => json_encode($data),
                ]
            );
        } else {
            return redirect()->back();
        }

        return view('indexing::import_fields', compact('csv_header_fields', 'csv_data', 'csv_data_file'))->with($dt);
    }
    /**
     * Send consent request to indexing
     */
    public function sendConsent(Indexing $indexing)
    {
        if (is_null($indexing->token)) {
            $indexing->update(['token' => genToken()]);
        }
        \Mail::to($indexing)->send(new RequestConsent($indexing));
        toastr()->success(langapp('sent_successfully'), langapp('response_status'));

        return redirect()->route('indexing.view', ['id' => $indexing->id]);
    }

    /**
     * Send whatsapp consent request to indexing
     */
    public function sendWhatsappConsent(Indexing $indexing)
    {
        $indexing->notify(new WhatsAppSubscribe($indexing->mobile));
        $indexing->chats()->create([
            'user_id' => \Auth::id(),
            'inbound' => 0,
            'message' => langapp('whatsapp_subscribe_reply', [
                'company' => get_option('company_name'), 'subtext' => get_option('whatsapp_sub_text'),
            ]),
            'from'    => get_option('whatsapp_number'),
            'to'      => $indexing->mobile,
        ]);
        toastr()->success(langapp('sent_successfully'), langapp('response_status'));

        return redirect(url()->previous());
    }

    public function processImport()
    {
        \Validator::make(
            array_flip($this->request->fields),
            [
                'name'    => 'required',
                'company' => 'required',
                'email'   => 'required',
            ]
        )->validate();
        (new IndexingCsvProcessor)->import($this->request);

        $data['message']  = langapp('saved_successfully');
        $data['redirect'] = route('indexing.index');

        return ajaxResponse($data);
    }
    /**
     * Confirm delete
     */
    public function delete(Indexing $indexing)
    {
        $data['indexing'] = $indexing;

        return view('indexing::modal.delete')->with($data);
    }
    /**
     * Send email to indexing
     */
    public function email(EmailRequest $request, Indexing $indexing)
    {
        $when = empty($request->reserved_at) ? now()->addMinutes(1) : dateParser($request->reserved_at);
        $request->request->add(['meta' => ['sender' => \Auth::user()->email, 'to' => $indexing->email]]);
        $request->request->add(['reserved_at' => $when->toDateTimeString()]);
        $request->request->add(['message' => str_replace("{name}", $indexing->name, $request->message)]);
        $mail = $indexing->emails()->create($request->except(['uploads', 'selectCanned']));

        if ($request->hasFile('uploads')) {
            $this->makeUploads($mail, $request);
        }

        \Mail::to($indexing)->later($when, new indexingBulkEmail($mail, \Auth::user()->profile->email_signature));

        $data['message']  = langapp('sent_successfully');
        $data['redirect'] = route('indexing.view', ['id' => $indexing->id, 'tab' => 'conversations']);

        return ajaxResponse($data);
    }

    protected function makeUploads($mail, $request)
    {
        $request->request->add(['module' => 'emails']);
        $request->request->add(['module_id' => $mail->id]);
        $request->request->add(['title' => $mail->subject]);
        $request->request->add(['description' => 'Email ' . $mail->subject . ' file']);

        return (new Uploader)->save('uploads/emails', $request);
    }

    public function replyEmail(EmailRequest $request)
    {
        $recipients = explode(',', trim($request->to));
        $email      = Emailing::create($request->except(['to']));

        $email->update([
            'from' => \Auth::id(), 'meta' => ['sender' => \Auth::user()->email, 'to' => $recipients],
        ]);
        $data['message']  = langapp('sent_successfully');
        $data['redirect'] = route(
            'indexing.view',
            [
                'id' => $email->indexing->id, 'tab' => 'emails', 'action' => $request->reply_id,
            ]
        );

        return ajaxResponse($data);
    }
    /**
     * Select indexing to send email
     */
    public function bulkEmail()
    {
        if ($this->request->has('checked')) {
            $data['page']  = $this->getPage();
            $data['indexing'] = $this->indexing->whereIn('id', $this->request->checked)->select('id', 'name', 'email')->get();

            return view('indexing::bulkEmail')->with($data);
        }
        return response()->json(['message' => 'No indexing selected', 'errors' => ['missing' => ["Please select atleast 1 indexing"]]], 500);
    }
    /**
     * Send email to multiple indexing
     */
    public function sendBulk(BulkSendRequest $request)
    {
        $when = empty($request->later_date) ? now()->addMinutes(1) : dateParser($request->later_date);
        if ($request->has('indexing')) {
            foreach ($request->indexing as $l) {
                $indexing = $this->indexing->findOrFail($l);
                $mail = $indexing->emails()->create(
                    [
                        'to'          => $indexing->id,
                        'from'        => \Auth::id(),
                        'subject'     => $request->subject,
                        'message'     => str_replace("{name}", $indexing->name, $request->message),
                        'reserved_at' => $when->toDateTimeString(),
                        'meta'        => [
                            'sender' => get_option('company_email'),
                            'to'     => $indexing->email,
                        ],
                    ]
                );
                \Mail::to($indexing)->bcc(!empty($request->bcc) ? $request->bcc : [])->later($when, new indexingBulkEmail($mail, \Auth::user()->profile->email_signature));
            }
        }
        $data['message']  = langapp('sent_successfully');
        $data['redirect'] = route('indexing.index');

        return ajaxResponse($data);
    }
    /**
     * Delete multiple indexing
     */
    public function bulkDelete()
    {
        if ($this->request->has('checked')) {
            BulkDeleteindexing::dispatch($this->request->checked, \Auth::id())->onQueue('normal');
            $data['message']  = langapp('deleted_successfully');
            $data['redirect'] = url()->previous();
            return ajaxResponse($data);
        }
        return response()->json(['message' => 'No indexing selected', 'errors' => ['missing' => ["Please select atleast 1 indexing"]]], 500);
    }

    public function ajaxDeleteMail()
    {
        if ($this->request->ajax()) {
            Emailing::findOrFail($this->request->id)->delete();
            return response()->json(
                ['status' => 'success', 'message' => langapp('deleted_successfully')],
                200
            );
        }
    }

    /**
     * Get indexing for display in datatable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function tableData()
    {
        $model = $this->applyFilter()->with('status:id,name', 'agent:id,username,name');

        return DataTables::eloquent($model)
            ->editColumn(
                'name',
                function ($indexing) {
                    $str = '<a href="' . route('indexing.view', $indexing->id) . '">';
                    if ($indexing->has_email) {
                        $str .= '<i class="fas fa-envelope-open text-danger"></i> ';
                    }
                    if ($indexing->has_chats) {
                        $str .= '<i class="fab fa-whatsapp text-danger"></i> ';
                    }
                    return $str . str_limit($indexing->name, 15) . '</a>';
                }
            )
            ->editColumn(
                'chk',
                function ($indexing) {
                    return '<label><input type="checkbox" name="checked[]" value="' . $indexing->id . '"><span class="label-text"></span></label>';
                }
            )
            ->editColumn(
                'company',
                function ($indexing) {
                    return str_limit($indexing->company, 15);
                }
            )
            ->editColumn(
                'email',
                function ($indexing) {
                    $str = '<a href="' . route('indexing.view', ['indexing' => $indexing->id, 'tab' => 'conversations']) . '">';
                    return $str . $indexing->email . '</a>';
                }
            )
            ->editColumn(
                'indexing_value',
                function ($indexing) {
                    return formatCurrency(get_option('default_currency'), (float) $indexing->indexing_value);
                }
            )
            ->editColumn(
                'stage',
                function ($indexing) {
                    return '<span class="text-dark">' . str_limit($indexing->status->name, 15) . '</span>';
                }
            )
            ->editColumn(
                'sales_rep',
                function ($indexing) {
                    return str_limit(optional($indexing->agent)->name, 15);
                }
            )
            ->rawColumns(['name', 'stage', 'chk', 'indexing', 'email'])
            ->make(true);
    }

    public function importGoogleContacts()
    {
        $code          = $this->request->code;
        $googleService = \OAuth::consumer('Google', route('indexing.import.callback'));
        if (!is_null($code)) {
            $token  = $googleService->requestAccessToken($code);
            $result = json_decode($googleService->request('https://www.google.com/m8/feeds/contacts/default/full?alt=json&max-results=1500'), true);
            session(['lock_assigned_alert' => true]);
            foreach ($result['feed']['entry'] as $contact) {
                if (isset($contact['gd$email'])) {
                    $data              = [];
                    $data['name']      = isset($contact['title']['$t']) ? $contact['title']['$t'] : $contact['gd$email'][0]['address'];
                    $data['source']    = 'Google Contacts';
                    $data['stage_id']  = get_option('default_indexing_stage');
                    $data['job_title'] = isset($contact['gd$organization'][0]['gd$orgTitle']['$t']) ? $contact['gd$organization'][0]['gd$orgTitle']['$t'] : '';
                    $data['company']   = isset($contact['gd$organization'][0]['gd$orgName']['$t']) ? $contact['gd$organization'][0]['gd$orgName']['$t'] : '';
                    $data['phone']     = isset($contact['gd$phoneNumber'][0]['$t']) ? $contact['gd$phoneNumber'][0]['$t'] : '';
                    $data['email']     = $contact['gd$email'][0]['address'];
                    $data['address1']  = isset($contact['gd$postalAddress'][0]['$t']) ? $contact['gd$postalAddress'][0]['$t'] : '';
                    $data['city']      = isset($contact['gd$structuredPostalAddress'][0]['gd$city']) ? $contact['gd$structuredPostalAddress'][0]['gd$city'] : '';
                    $data['state']     = isset($contact['gd$structuredPostalAddress'][0]['gd$region']) ? $contact['gd$structuredPostalAddress'][0]['gd$region'] : '';
                    $data['country']   = isset($contact['gd$structuredPostalAddress'][0]['gd$country']) ? $contact['gd$structuredPostalAddress'][0]['gd$country'] : '';
                    $data['sales_rep'] = get_option('default_sales_rep');
                    $indexing              = Indexing::updateOrCreate(
                        [
                            'email' => $contact['gd$email'][0]['address'],
                        ],
                        $data
                    );
                    $indexing->tag('google');
                }
            }
            session(['lock_assigned_alert' => false]);

            toastr()->info('indexing created from Google contacts', langapp('response_status'));

            return redirect()->route('indexing.index');
        } else {
            $url = $googleService->getAuthorizationUri();
            return redirect((string) $url);
        }
    }

    protected function applyFilter()
    {
        if ($this->request->filter === 'converted') {
            return $this->indexing->apply(['converted' => 1])->whereNull('archived_at');
        }
        if ($this->request->filter === 'archived') {
            return $this->indexing->apply(['archived' => 1]);
        }
        return $this->indexing->query()->whereNull('archived_at');
    }

    protected function getDisplayType()
    {
        if (!is_null($this->request->view)) {
            session(['indexingview' => $this->displayType]);
        }

        return session('indexingview', $this->displayType);
    }

    private function getPage()
    {
        return langapp('indexing');
    }
	
    protected function getIndexJobFile()
    {
        

        return session('indexingview', $this->displayType);
    }
	
}
