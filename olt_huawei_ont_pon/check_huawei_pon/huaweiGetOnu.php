<?php
include("funcoeshuawei_onu.php");


$serial = huawei_getall_onu_serial('179.125.32.240', '2017*public');
$nome   = huawei_getall_onu_nomes('179.125.32.240', '2017*public');
$power  = huawei_getall_onu_powerlevel('179.125.32.240', '2017*public');
// $power_olt = huawei_getall_olt_powerlevel('179.125.32.240', '2017*public');
$distance = huawei_getall_onu_distance('179.125.32.240', '2017*public');
$status = huawei_getall_onu_status('179.125.32.240', '2017*public');


$result = array();
$arr = array();
$len = count($nome);
$row = array();

for ($i = 0; $i < $len; $i++) {
       $row["serial"] = $serial[$i][1];
       $row["nome"] = $nome[$i];
       $row["status"] = $status[$i];
       $row["power"] = $power[$i];
       // $row["power_olt"] = $power_olt[$i];
       $row["distance"] = $distance[$i];
       array_push($result, $row);
}

var_dump($result);
