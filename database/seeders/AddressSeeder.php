<?php

namespace Database\Seeders;

use App\Traits\StoreSqlInDatabaseTrait;
use Illuminate\Database\Seeder;

final class AddressSeeder extends Seeder
{
    use StoreSqlInDatabaseTrait;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->storeSql(storage_path('sql/Address/address.sql'));
    }
}
