<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Exists;

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
        try {
            $max = Product::max('product_id');
            $response = Http::get(config('sources.product.base_url') . "products?limit=10&skip={$max}"); // Adjust the API URL and limit here   
            if ($response->successful()) {
                $products = $response->json();
                if (Arr::get($products,'products')) {
                    foreach ($products['products'] as $productData) {
                        Product::updateOrCreate(
                            [
                                'product_id' => $productData['id']
                            ],
                            [
                                'name' => $productData['title'],
                                'description' => $productData['description'],
                                'price' => $productData['price']
                            ]
                        );
                    }
                    $this->info('Products fetched and stored successfully.');
                } else {
                    Log::info('Products not found please check your data.');
                    $this->info('Array key does not exists');
                }
            } else {
                $this->error('Failed to fetch products.');
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
