<?php
$s3 = Storage::disk('s3');
$client = $s3->getDriver()->getAdapter()->getClient();
$bucket = Config::get('filesystems.disks.s3.bucket');

$key  = "Embase/Production/UAT/Orders_Received/2020/08_Aug/01-Aug-2020/43665130_1/AdditionalItemFile/2004800977.pdf";

$command = $client->getCommand('GetObject', [
	'Bucket' => $bucket,
	'Key' => $key,
	'ContentDisposition' => "inline",
    'ContentType' => "application/pdf"
]);

$request = $client->createPresignedRequest($command, '+20 minutes');

	print  (string) $request->getUri();		
	
?>
	   
<?php


function xmlToArray($xml, $options = array()) {
    $defaults = array(
        'namespaceSeparator' 	=> ':',						//you may want this to be something other than a colon
        'attributePrefix' 		=> '',   					//to distinguish between attributes and nodes with the same name
        'alwaysArray' 			=> array(),  		 		//array of xml tag names which should always become arrays
        'autoArray' 			=> true,        			//only create arrays for tags which appear more than once
        'textContent' 			=> 'keyworddataterm',       //key used for the text content of elements
        'autoText' 				=> true,         			//skip textContent key if node has no attributes or child nodes
        'keySearch' 			=> false,       			//optional search and replace on tag and attribute names
        'keyReplace' 			=> false       				//replace values for above search values (as passed to str_replace())
    );
    $options = array_merge($defaults, $options);
    $namespaces = $xml->getDocNamespaces();
    $namespaces[''] = null; 								//add base (empty) namespace
 
    														//get attributes from all namespaces
    $attributesArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
            												//replace characters in attribute name
            if ($options['keySearch']) $attributeName =
                    str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
            $attributeKey = $options['attributePrefix']
                    . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                    . $attributeName;
            $attributesArray[$attributeKey] = (string)$attribute;
        }
    }
 
    //get child nodes from all namespaces
    $tagsArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        foreach ($xml->children($namespace) as $childXml) {
            //recurse into child nodes
            $childArray = xmlToArray($childXml, $options);
			foreach($childArray as $childTagName => $childProperties) {
            //replace characters in tag name
            if ($options['keySearch']) $childTagName =
                    str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
            //add namespace prefix, if any
            if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;
 
            if (!isset($tagsArray[$childTagName])) {
                //only entry with this key
                //test if tags of this type should always be arrays, no matter the element count
                $tagsArray[$childTagName] =
                        in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
                        ? array($childProperties) : $childProperties;
            } elseif (
                is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                === range(0, count($tagsArray[$childTagName]) - 1)
            ) {
                //key already exists and is integer indexed array
                $tagsArray[$childTagName][] = $childProperties;
            } else {
                //key exists so convert to integer indexed array with previous value in position 0
                $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
            }
			
			}
        }
    }
 
    //get text content of node
    $textContentArray = array();
    $plainText = trim((string)$xml);
    if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;
 
    //stick it all together
    $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
            ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;
 
    //return node as array
    return array(
        $xml->getName() => $propertiesArray
    );
}


//Added term to highlist suggester terms
$index_drug = DB::table('index_drug')->select('drugterm as termname')->where('pui', $jobsourceinfo[0]->pui)->where('orderid', $jobsourceinfo[0]->orderid)->get()->toArray();
$index_medical_term = DB::table('index_medical_term')->select('medicalterm as termname')->where('pui', $jobsourceinfo[0]->pui)->where('orderid', $jobsourceinfo[0]->orderid)->get()->toArray();

$savedterms = array_merge((array)$index_drug,(array)$index_medical_term);
$checksaveterm = array();
foreach($savedterms as $saveterms){
	$checksaveterm[] = $saveterms->termname;
}






?>
<style>
.tab-container{
  background : #fafafa;
  margin: 0;
  padding: 0;
  max-height: 35px;
}

ul.tabs{
  margin: 0;
  list-style-type : none;
  line-height : 35px;
  max-height: 35px;
  overflow: hidden;
  display: inline-block;
  padding-right: 20px
}

ul.tabs > li.active{
  z-index: 2;
  background: #efefef;
}

ul.tabs > li{
  float : right;
  margin : 5px -10px 0;
  border-top-right-radius: 25px 170px;
  border-top-left-radius: 20px 90px;
  padding : 0 30px 0 25px;
  height: 170px;
  background: #fff;
  position : relative;
  box-shadow: 0 10px 20px rgba(0,0,0,.5);
  max-width : 400px;
}

ul.tabs > li > a{
  display: inline-block;
  max-width:100%;
  overflow: hidden;
  text-overflow: ellipsis;
  text-decoration: none;
  color: #222;
}



/* Clear Fix took for HTML 5 Boilerlate*/

.clearfix:before, .clearfix:after { content: ""; display: table; }
.clearfix:after { clear: both; }
.clearfix { zoom: 1; }
.pdfobject-container {
	width: 100%;
	max-width: 100%;
	height: 600px;
	margin: 2em 0;
}

.pdfobject { border: solid 1px #666; }
#results { padding: 1rem; }
.hidden { display: none; }
.success { color: #4F8A10; background-color: #DFF2BF; }
.fail { color: #D8000C; background-color: #FFBABA; }
</style>


<?php $__env->startSection('content'); ?>
<?php
function group_by($key, $data) {
    $result = array();
    foreach($data as $val) {
        if(array_key_exists($key, $val)){
			$val[$key] = str_replace( array( '<', '>' ), '', $val[$key]);
            $result[$val[$key]][] = $val;
        }else{
            $result[""][] = $val;
        }
    }
    return $result;
}

$minorchecktags = DB::table('minorchecktags')->where('status', 1)->get();
$checktag = array();
foreach($minorchecktags as $minorchecktag){
	$checktag[] = $minorchecktag->name;
}

$checktermdata = DB::table('terms')->get();
$termtag = array();
foreach($checktermdata as $termkey => $termdata){
	$termtag[$termkey]['name'] = $termdata->term_name;
	$termtag[$termkey]['type'] = $termdata->term_type;
	
}

$checktermdata = DB::table('terms')->get();
$termtag = array();
foreach($checktermdata as $termkey => $termdata){
	$termtag[$termkey]['name'] = $termdata->term_name;
	$termtag[$termkey]['type'] = $termdata->term_type;
	
}





//ML Engine XML 

$mlxmlfilepath = get_option('site_url').'ml_files/ML_UAT'.$jobsourceinfo[0]->ml_file.'.xml';
$MLxmlNode = simplexml_load_file($mlxmlfilepath);
$XMLarrayData = xmlToArray($MLxmlNode);


$xmlmlarraydata = array();
foreach($XMLarrayData['DocAnalytics']['DocAnalyticsSections']['DocAnalyticsSection'] as $xmldata){
	if(@$xmldata['final']!=''){
	$aryGroup 		= group_by("weight", $xmldata['Mainterm']);
	}
}
krsort($aryGroup);

$mlkeydata = array();
$cnt = 0;
foreach($aryGroup as $key => $aryval){
	if($key > 0.25){
		$keyname	=	'Level_1';
		$keyval		=	'Level 1';
		
		foreach($aryval as $val){
			$mlkeydata[$keyname][$cnt]['name']  = $val['name'];
			$mlkeydata[$keyname][$cnt]['weight']  = $val['weight'];
			$found_key = array_search($val['name'], array_column($termtag, 'name'));
			$keytermtype	= $termtag[$found_key]['type'];
			$mlkeydata[$keyname][$cnt]['termtype']  = $keytermtype;
		}
	} else {
		$keyname	=	'Level_2';
		$keyval		=	'Level 2';
		foreach($aryval as $val){
			$mlkeydata[$keyname][$cnt]['name']  = $val['name'];
			$mlkeydata[$keyname][$cnt]['weight']  = $val['weight'];
			$found_key = array_search($val['name'], array_column($termtag, 'name'));
			$keytermtype	= $termtag[$found_key]['type'];
			$mlkeydata[$keyname][$cnt]['termtype']  = $keytermtype;
		}
	}
$cnt ++;
}


$foldericon = getAsset('images/folder.png');
$treeviewstruct = '';
foreach($mlkeydata as $key => $aryval){
if($key == 'Level_1'){
	$keyname	=	'Level_1';
	$keyval		=	'Level 1';
} else {
	$keyname	=	'Level_2';
	$keyval		=	'Level 2';
}


$treeviewstruct .= '
<li id="'.$keyname.'" data-jstree={"icon":"'.$foldericon.'"}>'.$keyval.'
  <ul>
    ';
    foreach($aryval as $keysection => $treeval){
    
    switch ($treeval['termtype']) {
    case "DRG":
    //$icon			= 	getAsset('images/drug.png');
    $classname		= 	'DRG';
    $keytermtype 	=   'DRG';
    $classkeyname   =	'label label-primary btn-xxs';
    $termfinder		=	'Drug';
	$found_key = array_search($treeval['name'], $checksaveterm);
	if ($found_key !== false) {
	 $icon			= 	getAsset('images/drugactive.png');
	} else {
	 $icon			= 	getAsset('images/drug.png');
	}
    break;
    case "MED":
    $classname		= 	'MED';
    $keytermtype 	=   'MED';
    $classkeyname   =	'label label-info btn-xxs';
    $termfinder		=	'Medical';
	$found_key = array_search($treeval['name'], $checksaveterm);
	if ($found_key !== false) {
	 $icon			= 	getAsset('images/medicineactive.png');
	} else {
	 $icon			= 	getAsset('images/medicine.png');
	}
	
    break;
    case "DIS":
    $classname		= 	'DIS';
    $keytermtype 	=   'DIS';
    $classkeyname   =	'label label-info btn-xxs';
    $termfinder		=	'Disease';
	$found_key = array_search($treeval['name'], $checksaveterm);
	if ($found_key !== false) {
	 $icon			= 	getAsset('images/diseaseactive.png');
	} else {
	 $icon			= 	getAsset('images/disease.png');
	}
	
    break;
    }
    
    
	$keyhintname	= '<span style="display:none;">'.$treeval['name'].'</span><div class="label label-warning btn-xxs" style="display:none;">'.$treeval['termtype'].'</div><div class="label label-info btn-xxs" title="'.$keytermtype.'">'.round($treeval['weight'],2).'</div>';	
	
	
    $treeviewstruct .='<li id="'.$key.'_'.$keysection.'" class="class'.$classname.'" data-jstree={"icon":"'.$icon.'"} title="'.$keytermtype.'"><span id="treevalterm">'.$treeval['name'].'&nbsp;&nbsp;'.$keyhintname.'</span></li>';
	  
	  
    }
    $treeviewstruct .='
  </ul>
</li>
';

}



$foldericon = getAsset('images/folder.png');


$xmlfilepath = get_option('site_url').'ml_files/'.$jobsourceinfo[0]->orderid.'_output_1.xml';
$xmlNode = simplexml_load_file($xmlfilepath);
$arrayData = xmlToArray($xmlNode);



if(!empty($arrayData['bibdataset']['item']['bibrecord']['head']['enhancement']['descriptorgroup']['descriptors'])) {

$treeviewstruct .= '
<li id="elsevierterm" data-jstree={"icon":"'.$foldericon.'"}>Elsevier Term
  <ul>
    ';
    
    foreach($arrayData['bibdataset']['item']['bibrecord']['head']['enhancement']['descriptorgroup']['descriptors'] as $elsterm => $elstermdata){
    
    
    foreach($elstermdata['descriptor'] as $keydatalink => $keydataterm){
    if( $keydataterm['mainterm']['weight'] == 'a' ) { 
    $weightterm = 'Major';
    } else {
    $weightterm = 'Minor';
    }
	
	
	switch ($elstermdata['type']) {
		case "DRA":
		$found_key = array_search($keydataterm['mainterm']['keyworddataterm'], $checksaveterm);
		if ($found_key !== false) {
		 $icon			= 	getAsset('images/drugactive.png');
		} else {
		 $icon			= 	getAsset('images/drug.png');
		}
		$classname		= 	'DRG';
		$keytermtype 	=   'DRG';
		$classkeyname   =	'label label-primary btn-xxs';
		$termfinder		=	'Drug';
		break;
		case "MEA":
		$found_key = array_search($keydataterm['mainterm']['keyworddataterm'], $checksaveterm);
		if ($found_key !== false) {
		 $icon			= 	getAsset('images/medicineactive.png');
		} else {
		 $icon			= 	getAsset('images/medicine.png');
		}
		$classname		= 	'MED';
		$keytermtype 	=   'MED';
		$classkeyname   =	'label label-info btn-xxs';
		$termfinder		=	'Medical';
		break;
    }
	
	$keyhintname	= '<span style="display:none;">'.$keydataterm['mainterm']['keyworddataterm'].'</span>
    <div class="label label-warning btn-xxs" style="display:none;">'.$keytermtype.'</div>
    <div class="label label-info btn-xxs" title="'.$keytermtype.'">'.$termfinder.'</div>
    ';	
    
    $treeviewstruct .='
    <li id="'.$elsterm.'_'.$keydatalink.'" class="class'.$classname.'" data-jstree={"icon":"'.$icon.'"} title="'.$weightterm.'"><span id="treevalterm">'.$keydataterm['mainterm']['keyworddataterm'].'&nbsp;&nbsp;'.$keyhintname.'</span></li>';
    }
    }
    $treeviewstruct .='
  </ul>
  ';
  }
  
  ?>
  
	  
	  
  <input type="hidden" class="form-control" placeholder="jobid" name="jobid" id="jobid" value="<?php echo e($jobsourceinfo[0]->id); ?>" />
  <input type="hidden" class="form-control" placeholder="pui" name="pui" id="pui" value="<?php echo e($jobsourceinfo[0]->pui); ?>" />
  <input type="hidden" class="form-control" placeholder="orderid" name="orderid" id="orderid" value="<?php echo e($jobsourceinfo[0]->orderid); ?>" />
  <aside class="aside-xll b-l">
    <section class="vbox">
      <section class="scrollable" id="feeds">
        <div class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px">
          <div class="panel-group m-b" id="accordion2">
            <ul class="list no-style" id="responses-list">
              <li class="panel btn-default" id="tokenize">
                <div class="panel-heading"><?php echo e(svg_image('solid/cogs')); ?> <?php echo trans('app.'.'emtreemlheader'); ?> </div>
              </li>
            </ul>
          </div>
          <div id="tree">
            <ul>
              <?php echo $treeviewstruct; ?>
            </ul>
          </div>
        </div>
      </section>
    </section>
  </aside>
  <aside class="b-2 bg" id="">
    <section class="vbox">
      <div class="panel-group m-b" id="accordion2" style="height:40px;">
        <ul class="list no-style" id="responses-list">
          <li class="panel btn-default" id="tokenize" style="height:40px;">
            <div class=tab-container>
              <ul class="tabs clearfix" >
                <li> <a href=# ><?php echo e(svg_image('solid/cogs')); ?> &nbsp;<span class="btn btn-default btn-xs"><strong>JobID: <?php echo e($jobsourceinfo[0]->id); ?></strong></span> &nbsp;&nbsp; <span class="btn btn-default btn-xs"><strong>PUI: <?php echo e($jobsourceinfo[0]->pui); ?></strong></span> </a> </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
     
	  <div id="results" class="hidden"></div>
    <div id="pdf"></div>
    <script src="<?php echo e(getAsset('js/pdfobject.min.js')); ?>"></script>
    <script>
		var options = {
			pdfOpenParams: {
				navpanes: 0,
				toolbar: 1,
				statusbar: 0,
				view: "FitV",
				search: 'Acceptability',
				page: 1
			},
			forcePDFJS: true,
			PDFJS_URL: "<?php echo e(get_option('site_url')); ?>js/pdfjs/web/viewer.html"
		};
		
		
		var myPDF = PDFObject.embed("<?php echo (string) $request->getUri(); ?>", "#pdf", options);
		var el = document.querySelector("#results");
	</script>
	
	
	 
	 
    </section>
  </aside>
  
  <?php echo e(get_option('site_url')); ?>../storage/app/uploads/projects/<?php echo e($jobsourceinfo[0]->filename); ?>

  <?php /*?>
  //var myPDF = PDFObject.embed("<?php //echo   (string) $request->getUri();?>", "#pdf", options);
  <aside class="aside-lg b-l">
    <section class="vbox">
      <section class="scrollable">
        <div class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px">
          <div class="panel-group m-b" id="accordion2">
            <ul class="list no-style" id="responses-list">
              <li class="panel btn-default" id="tokenize">
                <div class="panel-heading">@icon('solid/cogs') @langapp('sentences') </div>
              </li>
            </ul>
          </div>
          <div id="sentencesfeeds">
            <div id="preloader"><i class="fas fa-spin fa-spinner"></i> Loading...</div>
          </div>
        </div>
      </section>
    </section>
  </aside><?php */?>
  <?php $__env->startPush('pagescript'); ?>
  
  <script>
$("#preloader").hide();		
function passsentences(selectedval,term,termType,score){
   if(selectedval !='') {
		$("#preloader").show();	
		axios.post('<?php echo e(get_option('site_url')); ?>api/v1/indexing/ajax/esvsentences', {
			selectterm: selectedval,
			term: term,
			termType: termType,
			score: score
		})
		.then(function (response) {
			$('#sentencesfeeds').html(response.data.message); 
			$("#preloader").hide();	
			<!--toastr.success(response.data.message, '<?php echo trans('app.'.'success'); ?> ');-->
		})
		.catch(function (error) {
			var errors = error.response.data.errors;
			var errorsHtml= '';
			$.each( errors, function( key, value ) {
				errorsHtml += '<li>' + value[0] + '</li>';
			});
			toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
		});
	}
}


jQuery(window).on('load', function() {
	var open = false;
	toggle(open);
});

function toggle(open){
   if(open){
    $("#tree").jstree('close_all');
    open = false;
   } else{
    $("#tree").jstree('open_all');
    open = true;
   }
}
</script>
  <?php $__env->stopPush(); ?>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.indexersourceapp', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>