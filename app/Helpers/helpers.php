<?php
use Illuminate\Support\Facades\Http;  
use Symfony\Component\DomCrawler\Crawler;
// V1.0
if (!function_exists('placeBuyOrder')) {
    function placeBuyOrder() { 
       //
         // API URL
         $url = 'https://api.dhan.co/v2/orders';

         // Access token from Postman
         $accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJkaGFuIiwicGFydG5lcklkIjoiIiwiZXhwIjoxNzQ1NDkwNTc3LCJ0b2tlbkNvbnN1bWVyVHlwZSI6IlNFTEYiLCJ3ZWJob29rVXJsIjoiIiwiZGhhbkNsaWVudElkIjoiMTEwNDY1Mzc0NyJ9.240Ox84B_iIN7RFywltf5wqU8UqqFM1vgMb12iC1QoL58wzgErl8mOg_EPIWzl72sycxUSpJicBY8uLwj3WusQ';
 
         // Data for the POST request (same as in Postman)
         $orderData = json_encode([
             "dhanClientId" => "1104653747",
             "correlationId" => "",
             "transactionType" => "BUY",
             "exchangeSegment" => "NSE_EQ",
             "productType" => "INTRADAY",
             "orderType" => "LIMIT",
             "validity" => "DAY",
             "securityId" => "1333",
             "quantity" => "5",
             "disclosedQuantity" => "0",
             "price" => "1651",
             "triggerPrice" => "",
             "afterMarketOrder" => false,
             "amoTime" => "OPEN",
             "boProfitValue" => 1665,
             "boStopLossValue" => 1658
         ]);
 
         //dd($orderData);
         $response = Http::withHeaders([
             'access-token' => $accessToken,
             'Accept' => 'application/json',
             'Content-Type' => 'application/json',
         ])->withBody($orderData, 'application/json')->post($url); 
         //dd($response->status(), $response->body(), $response->headers());
  
    }
} 
 
    function getLivePrice(){ 

        $ticker = '500209'; // BSE Infosys
        $exchange = 'BOM'; 
        $url = "https://www.google.com/finance/quote/{$ticker}:{$exchange}?hl=en";

        // Guzzle request with User-Agent
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'
        ])->get($url);

        if (!$response->successful()) {
            return ['error' => 'Failed to fetch data'];
        }

        // Extracting the HTML content
        $html = $response->body();
        $crawler = new Crawler($html);

        try {
            $price = $crawler->filter('.YMlKec.fxKbKc')->first()->text();
            return $price;
        } catch (\Exception $e) {
            return 'Price not found. HTML structure may have changed.';
        }
    } 

if (!function_exists('placeSellOrder')) {
    function placeSellOrder()
    {
        $url = 'https://api.dhan.co/v2/orders';

        // Access token from Postman
        $accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJkaGFuIiwicGFydG5lcklkIjoiIiwiZXhwIjoxNzQ1NDkwNTc3LCJ0b2tlbkNvbnN1bWVyVHlwZSI6IlNFTEYiLCJ3ZWJob29rVXJsIjoiIiwiZGhhbkNsaWVudElkIjoiMTEwNDY1Mzc0NyJ9.240Ox84B_iIN7RFywltf5wqU8UqqFM1vgMb12iC1QoL58wzgErl8mOg_EPIWzl72sycxUSpJicBY8uLwj3WusQ';

        // Data for the POST request (same as in Postman)
        $orderData = json_encode([
            "dhanClientId" => "1104653747",
            "correlationId" => "",
            "transactionType" => "SELL",
            "exchangeSegment" => "NSE_EQ",
            "productType" => "INTRADAY",
            "orderType" => "LIMIT",
            "validity" => "DAY",
            "securityId" => "1333",
            "quantity" => "5",
            "disclosedQuantity" => "0",
            "price" => "1651",
            "triggerPrice" => "",
            "afterMarketOrder" => false,
            "amoTime" => "OPEN",
            "boProfitValue" => 1665,
            "boStopLossValue" => 1658
        ]);

        //dd($orderData);
        $response = Http::withHeaders([
            'access-token' => $accessToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->withBody($orderData, 'application/json')->post($url); 
        //dd($response->status(), $response->body(), $response->headers());
    }
}

function getalltrade(){
    $url = 'https://api.dhan.co/v2/trades';
    $accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJkaGFuIiwicGFydG5lcklkIjoiIiwiZXhwIjoxNzQ1NDkwNTc3LCJ0b2tlbkNvbnN1bWVyVHlwZSI6IlNFTEYiLCJ3ZWJob29rVXJsIjoiIiwiZGhhbkNsaWVudElkIjoiMTEwNDY1Mzc0NyJ9.240Ox84B_iIN7RFywltf5wqU8UqqFM1vgMb12iC1QoL58wzgErl8mOg_EPIWzl72sycxUSpJicBY8uLwj3WusQ';


    $response = Http::withHeaders([
        'access-token' => $accessToken,
    ])->get($url);

    //dd($response->status(), $response->body(), $response->headers())

    // Check if the response is successful
    if ($response->successful()) {
        return $response->json(); // ✅ Return data
    } else {
        return ['error' => 'API request failed'];
    }

}
// NOT IN USE IN V1.0
if (!function_exists('get_prosition')) {
    function get_prosition($exchange) { 
        if($exchange == "BSE"){
            return "BSE";
        }
        if($exchange == "NSE"){
            return "NSE";
        }
        if($exchange == "MCX"){
            return "MCX";
        }
    }
}

if (!function_exists('get_side')) {
    function get_side($side) { 
        if($side == "BUY"){
            return "BUY";
        }
        if($side == "SELL"){
            return "SELL";
        } 
    }
}
if (!function_exists('get_order_type')) {
    function get_order_type($order_type) { 
        if($order_type == "MARKET"){
            return "MARKET";
        }
        if($order_type == "LIMIT"){
            return "LIMIT";
        } 
    }
}
