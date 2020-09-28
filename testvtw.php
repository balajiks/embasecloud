<?php



	$lurl = "https://54.255.193.244/api/login";
    $curl = curl_init($lurl);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $headers = array();
    $headers["Content-Type"] = "application/json";
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $data = array(
        "email" => "n.ganeshbabu@spi-global.com",
        "password" => "0<?LZ7@i7)S>"
    );
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $resp = curl_exec($curl);
    curl_close($curl);
    $adata = json_decode($resp, true);
   
   	$paction = '/jobs/insertvtwpiis';
    $url = 'https://54.255.193.244/api/v1';
    print $url . $paction;
	
	$fdata  = array(
        "pii" => "202010091058"
    );
	$fdata = json_encode($fdata);
	
    $dcurl = curl_init($url . $paction);
    curl_setopt($dcurl, CURLOPT_RETURNTRANSFER, true);
    $dheaders = array(
        'Content-Type: application/json',
        'Authorization: ' . $adata['message']['Authorization']
    );
    curl_setopt($dcurl, CURLOPT_HTTPHEADER, $dheaders);
    curl_setopt($dcurl, CURLOPT_POST, true);
    curl_setopt($dcurl, CURLOPT_POSTFIELDS, $fdata);
    curl_setopt($dcurl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($dcurl, CURLOPT_SSL_VERIFYPEER, false);
    $dresp = curl_exec($dcurl);
    curl_close($dcurl);
    $ddata = json_decode($dresp, true);
    print_r($dresp);
	
	?>