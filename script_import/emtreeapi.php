<?php




$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://localhost:5000/api/emtreegeneration/generateemtree?SearchTerm=abdominal%20obesity",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HTTPHEADER => array('Content-Length: 0'),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;

//$json_string = '[{"id":3,"children":[{"id":4,"children":[{"id":5}]}]},{"id":6},{"id":2},{"id":4}]';
$array = json_decode($response, true);

function buildMarkupListTree($aData)
{
    if (false === is_array($aData))
    {
        return '';
    }

    $sMarkup = '<ul>';

    foreach ($aData['Nodes'] as $sKey => $mValue)
    {
        $sMarkup.= '<li>' . trim($mValue['Term']);

        if (is_array($mValue))
        {
            $sMarkup.= buildMarkupListTree($mValue);
        }
        else
        {
            $sMarkup.= $mValue;
        }

        $sMarkup.= '</li>';
    }

    $sMarkup.= '</ul>';

    return $sMarkup;
}


print buildMarkupListTree($array);

print_r($array);

exit;

?>