<?php
$host	=	"localhost";
$user	=	"root";
$pass	=	"spiproject";
$db		=	"embase_v2";
$connect= new mysqli($host,$user,$pass,$db) or die("ERROR:could not connect to the database!!!");


function safe_json_encode($value){
if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
    $encoded = json_encode($value, JSON_PRETTY_PRINT);
} else {
    $encoded = json_encode($value, true);
}
switch (json_last_error()) {
    case JSON_ERROR_NONE:
        return $encoded;
    case JSON_ERROR_DEPTH:
        return 'Maximum stack depth exceeded'; // or trigger_error() or throw new Exception()
    case JSON_ERROR_STATE_MISMATCH:
        return 'Underflow or the modes mismatch'; // or trigger_error() or throw new Exception()
    case JSON_ERROR_CTRL_CHAR:
        return 'Unexpected control character found';
    case JSON_ERROR_SYNTAX:
        return 'Syntax error, malformed JSON'; // or trigger_error() or throw new Exception()
    case JSON_ERROR_UTF8:
        $clean = utf8ize($value);
        return safe_json_encode($clean);
    default:
        return 'Unknown error'; // or trigger_error() or throw new 
Exception();
}
}


function utf8ize($mixed) {
if (is_array($mixed)) {
    foreach ($mixed as $key => $value) {
        $mixed[$key] = utf8ize($value);
    }
} else if (is_string ($mixed)) {
    return utf8_encode($mixed);
}
return $mixed;
}

$fo=fopen("jsondata.json","r");
$fr=fread($fo,filesize("jsondata.json"));
$fr = preg_replace("!\r?\n!", "", $fr);



echo safe_json_encode($fr);
//To display all values from JSON file

print_r($array);

exit;
 
$query="insert into tbl_minorchecktags values('','$array[FirstName]','$array[LastName]')";

$connect->query($query);

echo "Data Imported Sucessfully from JSON!";
?>