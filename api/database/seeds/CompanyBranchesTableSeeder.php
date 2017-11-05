<?php

use Illuminate\Database\Seeder;

class CompanyBranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB:: table('company_branches') -> insert(array(
          array(
            "id"          => "2",
            "company_id"  => "2"
          ),
          array(
            "id"          => "3",
            "company_id"  => "3"
          )
        ));
    }
}
