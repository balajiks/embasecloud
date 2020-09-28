<?php

include_once __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$host 		= $_ENV['DB_HOST'];
$dbname 	= $_ENV['DB_DATABASE'];
$username 	= $_ENV['DB_USERNAME'];
$password 	= $_ENV['DB_PASSWORD'];



try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

try {
    $sql = 'SELECT * from tbl_datasections where jobid = "'.$_POST['jobid'].'" AND pui = "'.$_POST['pui'].'" AND orderid = "'.$_POST['orderid'].'" AND user_id = "'.$_POST['userid'].'"';
    $q = $pdo->query($sql);
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


?>
