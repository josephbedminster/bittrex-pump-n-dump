<?php
/* Public key and secret key to be set on wrapper.php */

require __DIR__.'/src/wrapper.php';
define ("BUY_CURRENCY", "BTC"); //Monnaie d'achat de la monnaie a pumper
define ("TAKE_PROFIT", 5); //% de benef pour le limit sell
define ("BTC_TOINVEST", 0.0033); //Nombre de BTC a investir

if (!checkAsset($argv[1])) {
	echo "Veuillez entrer une crypto !\n";
	exit;
}

$buy_rate = doBuyNow($b, $argv[1], BTC_TOINVEST);
doSellAtLimit($b, $argv[1], $buy_rate);