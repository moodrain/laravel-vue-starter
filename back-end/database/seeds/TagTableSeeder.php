<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->truncate();
        $count = 100;
        for($i = 1;$i <= $count;$i++) {
            DB::table('tags')->insert([
                'name' => 'tag-' . $i,
                'user_id' => 1,
                'click' => mt_rand(0, 1000),
                'weight' => mt_rand(0, 1000),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
