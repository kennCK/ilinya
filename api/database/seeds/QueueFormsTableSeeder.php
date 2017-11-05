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
            "company_id" => "2",
            "availability" => "1",
            "detail" => "Chair's Concerns",
            "title"  => "Enrolment Purposes",
            "is_private"  => "1"
          ),
          array(
            "id"    => "2",
            "company_id" => "2",
            "availability" => "1",
            "detail" => "Enrolment Concerns",
            "title"  => "2nd Semester Enrolment",
            "is_private"  => "1"
          ),
          array(
            "id"    => "3",
            "company_id" => "3",
            "availability" => "1",
            "detail" => "Chair's Concerns",
            "title"  => "Enrolment Purposes",
            "is_private"  => "1"
          ),
          array(
            "id"    => "4",
            "company_id" => "3",
            "availability" => "1",
            "detail" => "Enrolment Concerns",
            "title"  => "2nd Semester Enrolment",
            "is_private"  => "1"
          ),
        ));
    }
}
