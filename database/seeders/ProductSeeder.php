<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private const PRODUCT_COUNT = 20;

    public function run(): void
    {
        Product::factory()->count(self::PRODUCT_COUNT)->create();
    }
}
