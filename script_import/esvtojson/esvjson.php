<?php
/**
 * Function that groups an array of associative arrays by some key.
 * 
 * @param {String} $key Property to sort by.
 * @param {Array} $data Array that stores multiple associative arrays.
 */
/*function group_by($key, $data) {
    $result = array();
    foreach($data as $val) {
        if(array_key_exists($key, $val)){
            $result[$val[$key]][] = $val;
        }else{
            $result[""][] = $val;
        }
    }
    return $result;
}

// Get the contents of the JSON file 
$strJsonFileContents = file_get_contents("2001560563.json");
// Convert to array 
$strAry		 	= json_decode($strJsonFileContents, true);
$aryGroup['group'] 	= group_by("weight", $strAry['mainterms']);
ksort($aryGroup['group']);
//$strAry 	= json_encode($aryGroup);

 $aryGroup = json_encode($aryGroup['group']);
 print'<prE>';
 print_r($aryGroup);*/
 
 
 
function group_by($key, $data) {
    $result = array();
    foreach($data as $val) {
        if(array_key_exists($key, $val)){
            $result[$val[$key]][] = $val;
        }else{
            $result[""][] = $val;
        }
    }
    return $result;
}




 
 // Get the contents of the JSON file 
$strJsonFileContents = file_get_contents("2003507972.json");
// Convert to array 
$strAry		 	= json_decode($strJsonFileContents, true);




$aryGroup 	= group_by("weight", $strAry['mainterms']);
asort($aryGroup);

print'<prE>';
//print_r($aryGroup);


//exit;



$treeviewstruct = '';
foreach($aryGroup as $key => $aryval){
if($key == 'a'){
	$keyname	=	'Level_1';
	$keyval		=	'Level 1';
} else {
	$keyname	=	'Level_2';
	$keyval		=	'Level 2';
}



$treeviewstruct .= '<li id="'.$keyname.'">'.$keyval.'<ul>';
	foreach($aryval as $keysection => $treeval){
	
			if(!empty(@$treeval['sentences'])){ 
				$sen = base64_encode(json_encode(@$treeval['sentences']));
			} else { 
				$sen = 'null';
			}
	
		 $treeviewstruct .='<li id="'.$key.'_'.$keysection.'" onclick="passsentences(\''.$sen.'\')">'.$treeval['term'];
		 if(!empty($treeval['links'])){
		 	foreach($treeval['links'] as $keylink => $keyterm){
				$treeviewstruct .= '<ul>';
				
				if(!empty(@$keyterm['sentences'])){ 
					$sen = base64_encode(json_encode(@$keyterm['sentences']));
				} else { 
					$sen = 'null';
				}
				
				 $treeviewstruct .='<li id="'.$key.'_'.$keysection.'_'.$keylink.'" onclick="passsentences(\''.$sen.'\')">'.$keyterm['term'];
				 	if(!empty($keyterm['sublinks'])){
						$treeviewstruct .= '<ul>';
		 				foreach($keyterm['sublinks'] as $keysublink => $keysubterm){
							if(!empty(@$keysubterm['sentences'])){ 
								$sen = base64_encode(json_encode(@$keysubterm['sentences']));
							} else { 
								$sen = 'null';
							}
				 			$treeviewstruct .='<li id="'.$key.'_'.$keysection.'_'.$keylink.'_'.$keysublink.'" onclick="passsentences(\''.$sen.'\')">'.$keysubterm['term'].'</li>';
						}
						$treeviewstruct .= '</ul>';
					}
					$treeviewstruct .= '</li></ul>';
			}		 
		 }
		 $treeviewstruct .= '</li>';
	}
$treeviewstruct .='</ul></li>';
}





print $treeviewstruct;

/* if(@$treeval['links']){
		    foreach($treeval as $keysection => $treeval){
				$treeviewstruct .= '<ul>';
				$treeviewstruct .='<li id="'.$keysection.'">'.$treeval['term']
				$treeviewstruct .= '</ul>';
		 	}
*/
exit;



$mainarrayparent[0]['parentid'] = '-1';
$mainarrayparent[0]['id'] = '1';
$mainarrayparent[0]['weight'] = 'b';
$mainarrayparent[0]['term'] = 'b';
$mainarrayparent[0]['termType'] = 'b';
$mainarrayparent[0]['score'] = '0';

$mainarrayparent =  array
  (
  	array("id"=>"1", "parentid"=>"-1",  "text"=>"b", "value"=>"b", "weight"=>"b", "score"=>"0", "sentences"=>"" ), // , "weight"=>"b", "score"=>"0"
	array( "id"=>"2","parentid"=>"-1", "text"=>"a", "value"=>"a",  "weight"=>"a", "score"=>"0", "sentences"=>"") // ,  "weight"=>"a", "score"=>"0"
);
	
 
 $mainarray[] = array();
 foreach($strAry['mainterms'] as $key =>$mainterms){
 		
		$keyval = $key;
		$keyval = $keyval;
		
		
		$mainarray[$keyval]['id'] = $key+3;
		
		
		
 
 		if($mainterms['weight'] == 'b'){
			$mainarray[$keyval]['parentid'] = 1;
		} else {
			$mainarray[$keyval]['parentid'] = 2;
		}	
		
 		
		
		$mainarray[$keyval]['text'] = $mainterms['term'];
		$mainarray[$keyval]['value'] = $mainterms['termType'];
		$mainarray[$keyval]['weight'] = $mainterms['weight'];
		$mainarray[$keyval]['score'] = $mainterms['score'];
		if (@is_array($mainterms['sentences'])){
			 foreach($mainterms['sentences'] as $sentences){
				$mainarray[$keyval]['sentences'][] = $sentences;
			}
		}
 }
 
 $mainarray = array_merge($mainarray,$mainarrayparent);
 
 //$mainarray = json_encode($mainarray,true);
 
print'<prE>';
print_r($mainarray);
 
 



?>