<?php
require "./functions.php";
header("Content-Type:application/json");

$dollarPrice = "27545";

$dollarPrices = $dollarPrice . 0;
$dollarPriceInRials = number_format($dollarPrices);
$dollarPriceInTomans = number_format($dollarPrice);

if (!empty($_GET['name'])) {
    $symbol = $_GET['name'];

    $id = getIDDigitalCurrency($symbol);

    if ($id === NULL) {
        response(200, 'Digital currency not found', NULL, NULL, NULL, NULL, NULL, NULL, $dollarPriceInRials, $dollarPriceInTomans);
        return;
    }


    $priceInDollars = getInfoDigitalCurrency($id)[0];
    $priceRials = number_format($priceInDollars * $dollarPrices);
    $priceTomans = number_format($priceInDollars * $dollarPrice);


    $lastUpdated = getInfoDigitalCurrency($id)[1];
    $name = getInfoDigitalCurrency($id)[2];

    response(200, 'Digital currency found', strtoupper($symbol), $name, $priceInDollars, $priceRials, $priceTomans, $lastUpdated, $dollarPriceInRials, $dollarPriceInTomans);
} else {
    response(400, "Invalid Request", NULL, NULL, NULL, NULL, NULL, NULL, $dollarPriceInRials, $dollarPriceInTomans);
}
