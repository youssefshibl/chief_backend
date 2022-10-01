<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class usertableseeder extends Seeder
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
            Menu::factory(2)->create(['category_id' => $catory->id])->each(function ($menu) {
                $id = $menu->id;
                User::factory(1)->create()->each(function ($user) use ($id) {
                    Order::factory(1)->create(['menu_id' => $id, 'user_id' => $user->id]);
                    Address::factory(1)->create(['user_id' => $user->id]);
                });
            });
        });
    }
}
