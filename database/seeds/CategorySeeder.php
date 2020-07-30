<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['name' => "Angular", 'slug' => 'angular'],
            ['name' => "Vue", 'slug' => 'vue'],
            ['name' => "Vuex", 'slug' => 'vuex'],
            ['name' => "Laravel", 'slug' => 'laravel'],
            ['name' => "Javascript", 'slug' => 'javascript'],
            ['name' => "Flutter", 'slug' => 'flutter'],
            ['name' => "Dart", 'slug' => 'dart'],
        ];

        DB::table('categories')->insert($types);
    }
}
