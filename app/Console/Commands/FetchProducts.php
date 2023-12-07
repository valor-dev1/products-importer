<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $max = Product::max('product_id');
        $response = Http::get(config('sources.product.base_url')."products?limit=10&skip={$max}"); // Adjust the API URL and limit here   
        if ($response->successful()) {
            $products = $response->json();
            foreach ($products['products'] as $productData) {
                Product::updateOrCreate(
                    [
                        'product_id' => $productData['id']
                    ],
                    [
                    'name' => $productData['title'],
                    'description' => $productData['description'],
                    'price' => $productData['price']
                ]);
            }

            $this->info('Products fetched and stored successfully.');
        } else {
            $this->error('Failed to fetch products.');
        }
    }
}
