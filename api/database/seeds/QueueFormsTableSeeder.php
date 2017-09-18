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
            "availability" => "1",
            "title"  => "Reservation"
          ),
          array(
            "id"    => "2",
            "company_id" => "2",
            "availability" => "1",
            "title"  => "Ticket"
          ),
          array(
            "id"    => "3",
            "company_id" => "3",
            "availability" => "1",
            "title"  => "Ticket"
          ),
          array(
            "id"    => "4",
            "company_id" => "4",
            "availability" => "1",
            "title"  => "Reservation"
          ),
          array(
            "id"    => "5",
            "company_id" => "4",
            "availability" => "1",
            "title"  => "Payment"
          )
        ));
    }
}
