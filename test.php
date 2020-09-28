<?php
	$rrr = Storage::disk('s3')->download('Embase/Production/UAT/Orders_Received/2020/08_Aug/01-Aug-2020/43665130_1/AdditionalItemFile/2004800977.pdf');
	  print '<pre>';
	  print_r($rrr);
	  exit;
	  ?>


<?php



$lurl = "https://54.255.193.244/api/login";
$curl = curl_init($lurl);
curl_setopt($curl, CURLOPT_POST, true);;
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$headers = array();
$headers["Content-Type"] = "application/json";
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$data = array(
"email"=> "n.ganeshbabu@spi-global.com",
"password" => "0<?LZ7@i7)S>"
);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$resp = curl_exec($curl);
curl_close($curl);
$adata=json_decode($resp, true);









$url='https://54.255.193.244/api/v1';
$action='/jobs/vtwpiis';
$dcurl = curl_init($url.$action);
curl_setopt($dcurl, CURLOPT_RETURNTRANSFER, true);
//$dheaders = array();
//$dheaders["Content-Type"] = "application/json";
//$dheaders["Authorization"] = $adata['message']['Authorization'];

$headers = array(
'Content-Type: application/json',
'Authorization: '.$adata['message']['Authorization']
);

curl_setopt($dcurl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($dcurl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($dcurl, CURLOPT_SSL_VERIFYPEER, false);
$dresp = curl_exec($dcurl);
curl_close($dcurl);




$ddata=json_decode($dresp, true);
var_dump($ddata);

 

?>