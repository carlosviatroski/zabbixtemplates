#!/usr/bin/php

<?php

use \Disc\Zabbix\Sender;

require 'check_huawei_pon/vendor/autoload.php';
include("check_huawei_pon/funcoeshuawei_olt.php");


$sender = new \Disc\Zabbix\Sender('localhost', 10051);

$result = array();
$row = array();
$olt = $argv[1];
$host = $argv[2];
$snmp_index = $argv[3];

$quantidade_configurada = huawei_getall_olt_configured($olt, '2017*public', $snmp_index);

$len = count($quantidade_configurada);

for ($i = 0; $i < $len; $i++) {
    if ($quantidade_configurada[$i]["1"] > 0) {
        $onus_offline = huawei_get_total_onu_status_offline($olt, '2017*public', $quantidade_configurada[$i][0]);
        $json = array(
            'STATUS' => "ENVIANDO DADOS $snmp_index",
            'ONUS OFFLINE' => $onus_offline,
            'ONUS ONLINE' => ($quantidade_configurada[$i]["1"] - $onus_offline),
            'TOTAL ONUS:' => $quantidade_configurada[$i]["1"]
        );
        $sender->addData($host, "ClientesOnline[" . $snmp_index . "]", ($quantidade_configurada[$i]["1"] - $onus_offline));
        $sender->addData($host, "ClientesOffline[" . $snmp_index . "]", $onus_offline);
        $sender->addData($host, "TotalClientes[" . $snmp_index . "]", $quantidade_configurada[$i]["1"]);
        $sender->send();
        echo json_encode($json);
        exit;
    } else {
        $json = array(
            'STATUS' => "ENVIANDO SEM DADOS DE PON SEM ONU $snmp_index",
            'ONUS OFFLINE' => '0',
            'ONUS ONLINE' => '0',
            'TOTAL ONUS:' => '0'
        );
        $sender->addData($host, "ClientesOnline[" . $snmp_index . "]", '0');
        $sender->addData($host, "ClientesOffline[" . $snmp_index . "]", '0');
        $sender->addData($host, "TotalClientes[" . $snmp_index . "]", '0');
        $sender->send();
        echo json_encode($json);
        exit;
    }
}
