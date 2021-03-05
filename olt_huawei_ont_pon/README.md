<img src="icon.png" align="right" />

# Template Zabbix para monitorar OLT Huawei

Monitoramento Base de OLT's Huawei.

## Requisitos

- Zabbix Sender para receber os dados.
- PHP, linguagem base.
- SNMP para realizar a coleta.
- Composer para instalar as dependencias.

## Instalando

- Adicione os arquivos na pasta dos externalscripts (default /usr/lib/zabbix/externalscript).
- Importe os Templates.
- Adicione os Templates ao Host.


## DEBUG

- Dependendo da versão/configuraçao do snmp no sistema base, a saída das oid podem ser diferentes, aí tem que alterar algumas linhas no código linhas.

```$index = substr($keys[$i], 15, 10);```

Essa linha faz a separação da index da oid pela posição do caráctere, por exemplo.

```array(1) {
  ["IF-MIB::ifName.4194321152"]=>
  string(18) "STRING: GPON 0/2/3"
}
```

## Exemplo
<img src="example.png" align="right" />


