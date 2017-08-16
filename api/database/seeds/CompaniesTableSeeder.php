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
            "id"    => "1",
            "business_type_id" => "1",
            "name"  => "K1",
            "address"   => "Crossroads, Cebu City",
            "contact_number"    => "123456789",
            "email" => "k1@gmail.com",
            "lat"   => "123.1234556",
            "lng"   => "5.1234556"
          ),
          array(
            "id"    => "2",
            "business_type_id" => "3",
            "name"  => "Roble",
            "address"   => "Cebu City",
            "contact_number"    => "123456789",
            "email" => "roble@gmail.com",
            "lat"   => "123.1234556",
            "lng"   => "5.1234556"
          ),
          array(
            "id"    => "3",
            "business_type_id" => "2",
            "name"  => "ILinya",
            "address"   => "Cebu City",
            "contact_number"    => "123456789",
            "email" => "roble@gmail.com",
            "lat"   => "123.1234556",
            "lng"   => "5.1234556"
          ),
        ));
    }
}
