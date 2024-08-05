<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MilkPriceService;

class UpdateMilkPrice extends Command
{
    protected $signature = 'milkprice:update';
    protected $description = 'Update milk price from external source';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $service = new MilkPriceService();
        $price = $service->getCurrentPrice();
        // Update the price in the database
        \DB::table('milk_prices')->updateOrInsert(
            ['id' => 1], // Assuming a single entry for simplicity
            ['price' => $price, 'updated_at' => now()]
        );
        $this->info('Milk price updated successfully.');
    }
}

