<?php

use Illuminate\Database\Seeder;

class AccountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB:: table('account_types') -> insert(array(
          array("id" => "1","description" => "Admin"), 
          array("id" => "2","description" => "Employee"), 
        ));
    }
}
