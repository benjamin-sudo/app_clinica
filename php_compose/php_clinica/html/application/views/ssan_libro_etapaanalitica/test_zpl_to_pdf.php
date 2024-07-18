<?php


$zpl = "^xa^cfa,50^fo100,100^fdHello World^fs^xz";


$curl = curl_init();


var_dump($curl);

/*
// adjust print density (8dpmm), label width (4 inches), label height (6 inches), and label index (0) as necessary
curl_setopt($curl, CURLOPT_URL, "http://api.labelary.com/v1/printers/8dpmm/labels/4x6/0/");
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_POSTFIELDS, $zpl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Accept: application/pdf")); // omit this line to get PNG images back
$result = curl_exec($curl);

curl_close($curl);
*/





//echo "HOLAAAAAAAAAAAAA";


?>