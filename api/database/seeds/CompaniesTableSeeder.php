<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB:: table('companies') -> insert(array(
          array(
            "id"    => "2",
            "business_type_id" => "6",
            "name"  => "USC Psychology Department",
            "address"   => "USC - TC, Talamban, Cebu City",
            "lat"   => "123.1234556",
            "lng"   => "5.1234556"
          ),
          array(
            "id"    => "3",
            "business_type_id" => "6",
            "name"  => "USC DCLL",
            "address"   => "USC - TC, Talamban, Cebu City",
            "lat"   => "123.1234556",
            "lng"   => "5.1234556"
          )
        ));
    }
}
