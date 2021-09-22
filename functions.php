<?php



function getIDDigitalCurrency(string $name)
{
    $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/map';
    $parameters = [
        'start' => '1',
        'symbol' => $name
    ];

    $headers = [
        "Accept: application/json",
        "X-CMC_PRO_API_KEY: 3222ff3f-dfee-4218-8f6b-d1bd90aae5e0"
    ];
    $qs = http_build_query($parameters);
    $request = "{$url}?{$qs}";

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $request,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => 1
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    @$id = json_decode($response, true)['data'][0]['id'];

    return $id;
}



function getInfoDigitalCurrency(int $idname): array
{
    $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
    $parameters = [
        'id' => $idname,
        'convert' => 'USD'
    ];

    $headers = [
        "Accept: application/json",
        "X-CMC_PRO_API_KEY: 3222ff3f-dfee-4218-8f6b-d1bd90aae5e0"
    ];
    $qs = http_build_query($parameters);
    $request = "{$url}?{$qs}";

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $request,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => 1
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $allInfo = json_decode($response, true);

    $price = $allInfo['data'][$idname]['quote']['USD']['price'];

    $lastUpdated = $allInfo['data'][$idname]['quote']['USD']['last_updated'];

    $name = $allInfo['data'][$idname]["slug"];

    $return = [$price, $lastUpdated, $name];

    return $return;
}



function response($status, $message, $symbol, $name, $priceInDollars, $priceRials, $priceTomans, $lastUpdated, $dollarPrices, $dollarPrice)
{
    header("HTTP/1.1 " . $status);
    $response['status'] = $status;
    $response['message'] = $message;
    $response['symbol'] = $symbol;
    $response['name'] = $name;
    $response['price_in_dollars'] = $priceInDollars;
    $response['price_in_rials'] = $priceRials;
    $response['price_in_tomans'] = $priceTomans;
    $response['dollar_price_in_rials'] = $dollarPrices;
    $response['dollar_price_in_tomans'] = $dollarPrice;
    $response['last_updated'] = $lastUpdated;
    $json_response = json_encode($response);
    echo $json_response;
}
