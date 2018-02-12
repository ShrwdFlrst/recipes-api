<?php

use App\Csv\Parser;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RecipeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = public_path() . '/../database/recipe-data.csv';
        $parser = new Parser();
        $csv = $parser->toArray($path);

        foreach ($csv as $row) {
            DB::table('recipes')->insert($row);
        }
    }
}
