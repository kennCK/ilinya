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
            "business_type_id" => "1"
          ),
        ));
    }
}
