<?php


function huawei_getall_onu_serial($host, $community)
{
	$arr = snmp2_real_walk($host, $community, ".1.3.6.1.4.1.2011.6.128.1.1.2.43.1.3", 10000000, 3);
	$keys = array_keys($arr);
	$arrreturn = array();
	// print_r($arr);
	$i = 0;
	foreach ($arr as $idx) {

		$sn = preg_replace("/\s+/", "", $idx);
		$sn = explode(":", $sn);

		$index = substr($keys[$i], 38, 10);

		$retorno = array($index, $sn["1"]);
		array_push($arrreturn, $retorno);
		$i++;
	}
	return $arrreturn;
}

function huawei_getall_onu_nomes($host, $community)
{
	$arr = snmp2_walk($host, $community, ".1.3.6.1.4.1.2011.6.128.1.1.2.43.1.9", 5000000, 3);
	$arrreturn = array();
	foreach ($arr as $idx) {

		$nome = explode(":", $idx);
		$nome[1] = str_replace('"', "", $nome[1]);
		array_push($arrreturn, ltrim($nome[1]));
	}
	return $arrreturn;
}


function huawei_getall_onu_powerlevel($host, $community)
{
	$arr = snmp2_walk($host, $community, ".1.3.6.1.4.1.2011.6.128.1.1.2.51.1.4", 5000000, 3);
	$arrreturn = array();
	foreach ($arr as $idx) {

		// print_r($idx . "\n");
		$rx = explode(":", $idx);
		// // $macs[1] = $macs[1] / 100;
		array_push($arrreturn, $rx[1]);
	}
	return $arrreturn;
}

function huawei_getall_olt_powerlevel($host, $community)
{
	$arr = snmp2_walk($host, $community, ".1.3.6.1.4.1.2011.6.128.1.1.2.51.1.6", 5000000, 3);
	$arrreturn = array();
	foreach ($arr as $idx) {

		// print_r($idx . "\n");
		$oltrx = explode(":", $idx);
		// // $macs[1] = $macs[1] / 100;
		array_push($arrreturn, $oltrx[1]);
	}
	return $arrreturn;
}

function huawei_getall_onu_status($host, $community)
{
	$arr = snmp2_walk($host, $community, ".1.3.6.1.4.1.2011.6.128.1.1.2.46.1.15", 5000000, 3);
	$arrreturn = array();
	foreach ($arr as $idx) {
		$status = explode(":", $idx);
		array_push($arrreturn, ltrim($status[1]));
	}
	return $arrreturn;
}


function huawei_getall_onu_distance($host, $community)
{
	$arr = snmp2_walk($host, $community, "1.3.6.1.4.1.2011.6.128.1.1.2.46.1.20", 5000000, 3);
	$arrreturn = array();
	foreach ($arr as $idx) {
		$status = explode(":", $idx);
		array_push($arrreturn, ltrim($status[1]));
	}
	return $arrreturn;
}
