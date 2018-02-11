<?php

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

        // See: http://php.net/manual/en/function.str-getcsv.php#117692
        $csv = array_map('str_getcsv', file($path));
        array_walk($csv, function(&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv);

        foreach ($csv as $row) {
            // Change date formatting
            $row['created_at'] = Carbon::createFromFormat('d/m/Y H:i:s', $row['created_at']);
            $row['updated_at'] = Carbon::createFromFormat('d/m/Y H:i:s', $row['updated_at']);

            DB::table('recipes')->insert($row);
        }
    }
}
