<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getStockPrice()
    {
        $ticker = '500209'; // BSE Infosys
        $exchange = 'BOM'; 
        $url = "https://www.google.com/finance/quote/{$ticker}:{$exchange}?hl=en";

        // Guzzle request with User-Agent
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'
        ])->get($url);

        if (!$response->successful()) {
            return response()->json(['error' => 'Failed to fetch data'], 500);
        }

        // Extracting the HTML content
        $html = $response->body();
        $crawler = new Crawler($html);

        try {
            $price = $crawler->filter('.YMlKec.fxKbKc')->first()->text();
            return response()->json(['price' => $price]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Price not found. HTML structure may have changed.'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
