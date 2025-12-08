<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait StoreSqlInDatabaseTrait
{
    public function storeSql(string $filePath): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $sql = file_get_contents($filePath);

        DB::unprepared($sql);
    }
}
