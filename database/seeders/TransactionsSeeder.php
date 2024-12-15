<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artisan::call('migrate:refresh --path=/database/migrations/2024_08_20_161425_create_transactions_table.php');
        Artisan::call('migrate:refresh --path=/database/migrations/2024_08_20_161429_create_transaction_details_table.php');
        Artisan::call('migrate:refresh --path=/database/migrations/2024_08_24_123020_create_payments_table.php');
    }
}
