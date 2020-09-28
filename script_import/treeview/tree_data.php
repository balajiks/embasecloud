<?php
include_once("db_connect.php");
try {
    $sql = 'SELECT * from tbl_datasections where jobid = "'.$_POST['jobid'].'" AND pui = "'.$_POST['pui'].'" AND orderid = "'.$_POST['orderid'].'" AND user_id = "'.$_POST['userid'].'"';
    $q = $conn->query($sql);
	$sectiondata = $q->fetchAll();
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

$data	=	array();
			
$data['id']		= 0;
$data['text']	= 'Section';
foreach($sectiondata as $key => $section){
	$data['children'][$key]['id'] = $section['id'];
	$data['children'][$key]['text'] = $section['sectionval'];
}

// Encode:
echo json_encode($data);
exit;
?>
