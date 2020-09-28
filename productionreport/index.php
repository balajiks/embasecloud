<?php
define("ROW_PER_PAGE",2);
require_once('db.php');

	//Indeing data
	
	$query = "SELECT COALESCE(puser, 'Total') as 'In-House Code', employee.pgcode,proc, count(ppui) as 'Production' from prod INNER JOIN employee ON prod.puser=employee.embcode  where  DATE(ptime)= '2020-08-14' AND spre='end' AND proc='index' and puser not in ('ESG', 'EPP', 'EMH', 'ESA', 'ESW', 'ESY', 'EML', 'EVD', 'EDG', 'ERS', 'EYK', 'EAA', 'EEJ', 'EGA') group by puser "; //DATE_SUB(CURDATE(), INTERVAL 1 DAY)
	$pdo_statement = $pdo_conn->prepare($query);
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
	
	$pgcode	 = array('203608','203676','205370','205609','205613','205686','205770','205776','205778','205780','302597','302970','303323','303633','303860','303864','206459','304483','304568','304565','304564','206570','206573','304586','304587','206080','206085','206443','206445','302693','203646','301108','203839','206092','PG4309','PG4936','PG4306','PG4428');
	$actualplan = array('25','25','25','25','25','25','25','25','25','25','25','25','25','25','25','25','16','16','10','10','10','8','8','8','8','6','6','6','6','25','25','25','25','18','8','7','0','0');
	
	$array = array();
	foreach($result as $key => $data){
		$array[$key]['EntryDate'] 	= date('Y-m-d').'T00:00:00';
		$array[$key]['client'] 		= 'CAS';
		$array[$key]['engagement'] 	= 'Elsevier Embase indexing';
		$array[$key]['EMPID'] 		= $data['pgcode'];
		$array[$key]['Role'] 		= $data['proc'];
		$array[$key]['Actual'] 		= $data['Production'];
		$array[$key]['Plan'] 		= $actualplan[array_search($data['pgcode'],$pgcode,true)];
	}
	
	//QC Data
	
	$queryqc = "SELECT COALESCE(puser, 'Total') as 'In-House Code', employee.pgcode,proc, count(ppui) as 'Production' from prod INNER JOIN employee ON prod.puser=employee.embcode  where  DATE(ptime)= '2020-08-14' AND spre='end' AND proc='qc' and puser not in ('ESG', 'EPP', 'EMH', 'ESA', 'ESW', 'ESY', 'EML', 'EVD', 'EDG', 'ERS', 'EYK', 'EAA', 'EEJ', 'EGA') group by puser "; //DATE_SUB(CURDATE(), INTERVAL 1 DAY)
	$pdo_statementqc = $pdo_conn->prepare($queryqc);
	$pdo_statementqc->execute();
	$resultqc = $pdo_statementqc->fetchAll();
	
	$pgcodeqc	 = array('203608','203676','205370','205609','205613','205686','205770','205776','205778','205780','302597','302970','303323','303633','303860','303864','206459','304483','304568','304565','304564','206570','206573','304586','304587','206080','206085','206443','206445','302693','203646','301108','203839','206092','PG4309','PG4936','PG4306','PG4428');
	$actualplanqc = array('25','25','25','25','25','25','25','25','25','25','25','25','25','25','25','25','16','16','10','10','10','8','8','8','8','6','6','6','6','25','25','25','25','18','8','7','0','0');
	
	$arrayqc = array();
	foreach($resultqc as $key => $data){
		$arrayqc[$key]['EntryDate'] 	= date('Y-m-d').'T00:00:00';
		$arrayqc[$key]['client'] 		= 'CAS';
		$arrayqc[$key]['engagement'] 	= 'Elsevier Embase indexing';
		$arrayqc[$key]['EMPID'] 		= $data['pgcode'];
		$arrayqc[$key]['Role'] 			= $data['proc'];
		$arrayqc[$key]['Actual'] 		= $data['Production'];
		$arrayqc[$key]['Plan'] 			= $actualplanqc[array_search($data['pgcode'],$pgcodeqc,true)];
	}
	
	$finalarray['ProductivityList'] = array();
	$finalarray['ProductivityList'] = array_merge($arrayqc,$array);
	
	/*// Use json_encode() function 
	$json = json_encode($finalarray); 
   
	// Display the output 
	echo($json); */
	
	print '<pre>';
	print_r($finalarray);
	exit;
	
?>
