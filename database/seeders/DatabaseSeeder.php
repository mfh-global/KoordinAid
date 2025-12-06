<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class DatabaseSeeder extends Seeder
{
    private const SQL_FILES = [
        //'categories.sql',
        //'genders.sql',
        //'sizegroups.sql',
        //'products.sql',
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::SQL_FILES as $file) {
            $sql = file_get_contents(__DIR__ . '/../init_sql/' . $file);
            DB::unprepared($sql);
        }
    }
}
