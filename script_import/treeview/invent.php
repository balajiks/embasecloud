<?php
include_once("db_connect.php");
try {
    $sql = 'SELECT * from inven2 where pui IN ("_pui 2003240786","_pui 2003240787","_pui 2003418359","_pui 2003519530","_pui 2003754943","_pui 2003789528","_pui 2003790035","_pui 2003802066","_pui 2003822678","_pui 2003824080","_pui 2004081819","_pui 2004285230","_pui 2004328162","_pui 2004328682","_pui 2004333696")';
    $q = $conn->query($sql);
	$sectiondata = $q->fetchAll();
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

//print '<pre>';
//print_r($sectiondata);
foreach($sectiondata as $key => $data){

	print "INSERT INTO `tbl_projects` (`id`, `carid`, `pubyear`, `pui`, `orderid`, `journal`, `article`, `filepath`, `filename`, `abs`, `publ`, `indexer`, `qc`, `category`, `allocation`, `jobstatus`, `sdupli`, `dupli`, `complex`, `tstatus`, `ordertype`, `unitid`, `stype`, `sigtype`, `srcid`, `vol`, `iss`, `doi`, `ml_file`, `content`, `pii`, `code`, `name`, `description`, `client_id`, `currency`, `start_date`, `due_date`, `hourly_rate`, `fixed_price`, `progress`, `notes`, `manager`, `status`, `auto_progress`, `estimate_hours`, `settings`, `alert_overdue`, `used_budget`, `billable_time`, `unbillable_time`, `unbilled`, `sub_total`, `total_expenses`, `todo_percent`, `contract_id`, `billing_method`, `archived_at`, `overbudget_at`, `token`, `rated`, `deleted_at`, `created_at`, `updated_at`, `feedback_disabled`, `deal_id`, `is_template`) VALUES (NULL, '".$data['carid']."', '".$data['pubyear']."', '".$data['pui']."', '".$data['orderid']."', '".$data['journal']."', '".$data['article']."', 'http://localhost:81/embasecloud/storage/app/uploads/projects/', '".str_replace('_pui ','',$data['pui']).".json', 'No', 'Yes', 'uat', 'uat', 'Category 2', NULL, 'pending', NULL, NULL, NULL, '>TAT', 'INDEX', '".$data['unitid']."', NULL, NULL, '".$data['srcid']."', NULL, NULL, '".$data['doi']."', '".str_replace('_pui ','',$data['pui'])."', NULL, NULL, '0".($key+4)."', 'Project Title', NULL, '1', 'USD', NULL, NULL, '0.00', '0.00', '0', NULL, NULL, 'Active', '1', '0.00', NULL, '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', NULL, 'hourly_project_rate', NULL, NULL, NULL, '0', NULL, NULL, NULL, '0', NULL, '0');";
	print '<br /><br />';


}




exit;
?>

