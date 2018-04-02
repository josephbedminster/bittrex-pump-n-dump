<?php
	require __DIR__.'/edsonmedina/bittrex/Client.php';
	use edsonmedina\bittrex\Client;
	$key = ''; //PK
	$secret = ''; //SK
	$b = new Client ($key, $secret);

	function checkAsset($asset) {
		if ($asset == null || strlen($asset) < 2 || strlen($asset) > 4)
			return (false);
		return (true);
	}

	function getBuyPriceNow($b, $ticker) {
		$res = $b->getTicker ("BTC-".$ticker);
		echo "Je voudrai l'acheter au prix de : ".(($res->Last * 105) / 100)."BTC\n";
		return (($res->Last * 105) / 100);
	}

	function getSellPriceNow($rate) {
		return (($rate * (100 + TAKE_PROFIT)) / 100);
	}

	function getBTCBalance($b) {
		return ($b->getBalance("BTC")->Balance);
	}

	function getBalance($b, $ticker) {
		return ($b->getBalance($ticker)->Balance);
	}

	function doBuyNow($b, $ticker, $balance_toinvest) {
		if (getBTCBalance($b) < $balance_toinvest) {
			echo "Pas assez de BTC pour achetter ! Vérifier les configs.\n";
			exit;
		}
		$rate = getBuyPriceNow($b, $ticker);
		$quantity = ($balance_toinvest / $rate);
		echo "Je vais acheter $quantity \$$ticker pour $balance_toinvest BTC à $rate\n";
		$res = $b->buyLimit (BUY_CURRENCY."-".$ticker, $quantity, $rate);
		return ($rate);
	}

	function doSellAtLimit($b, $ticker, $rate) {
		$quantity = getBalance($b, $ticker);
		$rate = getSellPriceNow($rate);
		echo "Je met mon ordre de vente à $rate $";
		$res = $b->sellLimit (BUY_CURRENCY."-".$ticker, $quantity, $rate);
	}
