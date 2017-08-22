<?php

use Illuminate\Database\Seeder;

class QueueFormsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB:: table('queue_forms') -> insert(array(
          array(
            "id"    => "1",
            "company_id" => "1",
            "title"  => "Payment"
          ),
          array(
            "id"    => "2",
            "company_id" => "2",
            "title"  => "Payment"
          ),
        ));
    }
}
