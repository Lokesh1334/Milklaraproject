<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class MilkPriceService
{
    public function getCurrentPrice()
    {
        // Replace with actual API URL
        $response = Http::get('https://timesofindia.indiatimes.com/city/chennai/tamil-nadu-govt-raises-milk-procurement-prices/articleshow/105965434.cms');
        $data = $response->json();
        return $data['price'];
    }
}
