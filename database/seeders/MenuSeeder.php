<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Category::factory(5)->create()->each(function ($catory) {
            Menu::factory(10)->create(['category_id' => $catory->id]);
        });
    }
}
