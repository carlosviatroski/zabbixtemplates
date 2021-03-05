#!/usr/bin/php

<?php

function huawei_getall_olt_pon($host, $community, $pon)
{
    $arr = snmp2_real_walk($host, $community, "iso.3.6.1.2.1.31.1.1.1.1.$pon", 10000000, 3);
    $arrreturn = array();

    // return $arr;


    foreach ($arr as $idx) {


        $nome = explode(":", $idx);
        $nome[1] = str_replace('"', "", $nome[1]);

        // if (strlen($keys[$i]) > 12) {
        // $index = substr($keys[$i], 25, 10);
        // $retorno = array($index, $nome["1"]);
        array_push($arrreturn, ltrim($nome[1]));
        // $i++;
        // }
    }
    return $arrreturn;
}


function huawei_getall_olt_configured($host, $community, $snmp_index)
{
    $arr = snmp2_real_walk($host, $community, "iso.3.6.1.4.1.2011.6.128.1.1.2.21.1.16.$snmp_index", 10000000, 3);
    $keys = array_keys($arr);
    $arrreturn = array();
    $i = 0;
    foreach ($arr as $idx) {
        $index = substr($keys[$i], 49, 10);
        $quantidade = explode(":", $idx);

        $retorno = array($index, ltrim($quantidade["1"]));
        array_push($arrreturn, $retorno);
        $i++;
    }
    return $arrreturn;
}



#4194321152
function huawei_getall_onu_pon($host, $community, $pon)
{
    $arr = snmp2_real_walk('179.125.32.240', '2017*public', "iso.3.6.1.4.1.2011.6.128.1.1.2.43.1.3.$pon", 10000000, 3);

    $keys = array_keys($arr);
    $arrreturn = array();

    $i = 0;
    foreach ($arr as $idx) {
        $onuid = substr($keys[$i], 48);
        $sn = preg_replace("/\s+/", "", $idx);
        $sn = explode(":", $sn);
        $status = huawei_get_onu_status($host, $community, $onuid);
        // var_dump($status);
        $retorno = array(
            'SN' => $sn["1"],
            'STATUS' => $status
        );
        array_push($arrreturn, $retorno);
        $i++;
    }

    return $arrreturn;
}


function huawei_get_onu_rx($host, $community, $onuid)
{
    $arr = snmp2_walk($host, $community, "1.3.6.1.4.1.2011.6.128.1.1.2.51.1.4.$onuid", 10000000, 3);
    $signal = explode(":", $arr[0]);
    return $signal[1];
}

function huawei_get_onu_status($host, $community, $onuid)
{
    $arr = snmp2_walk($host, $community, "1.3.6.1.4.1.2011.6.128.1.1.2.46.1.15.$onuid", 10000000, 3);
    $status = explode(":", $arr[0]);
    return $status[1];
}


function huawei_get_total_onu_status_offline($host, $community, $pon)
{
    $arr = snmp2_real_walk($host, $community, "iso.3.6.1.4.1.2011.6.128.1.1.2.43.1.3.$pon", 10000000, 3);

    $keys = array_keys($arr);
    $arrreturn = array();

    $i = 0;
    $total_onu_off = 0;

    foreach ($arr as $idx) {
        $onuid = substr($keys[$i], 48);
        $sn = preg_replace("/\s+/", "", $idx);
        $sn = explode(":", $sn);
        // $signal = huawei_get_onu_rx($host, $community, $onuid);
        $status = huawei_get_onu_status($host, $community, $onuid);

        if ($status == 2) {
            $total_onu_off++;
        }

        $i++;
    }

    return $total_onu_off;
}
