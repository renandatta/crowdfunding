<?php

use App\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentType::insert([
            ['name' => 'BCA', 'description' => 'Lorem ipsum sir dolor amet'],
            ['name' => 'BNI', 'description' => 'Lorem ipsum sir dolor amet'],
            ['name' => 'OVO', 'description' => 'Lorem ipsum sir dolor amet'],
            ['name' => 'Gopay', 'description' => 'Lorem ipsum sir dolor amet'],
            ['name' => 'Dana', 'description' => 'Lorem ipsum sir dolor amet'],
        ]);
    }
}
