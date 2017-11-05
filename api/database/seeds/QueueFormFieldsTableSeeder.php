<?php

use Illuminate\Database\Seeder;

class QueueFormFieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB:: table('queue_form_fields') -> insert(array(

          /*
            PSYCH
          */
          array(
            "id"    => "1", "queue_form_id" => "1", "is_admin_only" => '0', "sequence" => "1","description"  => "What is your Complete Name?", "type" => "text"
          ),
          array(
            "id"    => "2", "queue_form_id" => "1", "is_admin_only" => '0', "sequence" => "2","description"  => "What is your ID Number?", "type" => "text"
          ),
          array(
            "id"    => "3", "queue_form_id" => "1", "is_admin_only" => '0', "sequence" => "3","description"  => "What is your Course and Year Level?", "type" => "text"
          ),
          array(
            "id"    => "4", "queue_form_id" => "1", "is_admin_only" => '0', "sequence" => "4","description"  => "What is your Concerns?", "type" => "text"
          ),

          /*
            PSYCH ENROLMENT
          */
          array(
            "id"    => "5", "queue_form_id" => "2", "is_admin_only" => '0', "sequence" => "1","description"  => "What is your Complete Name?", "type" => "text"
          ),
          array(
            "id"    => "6", "queue_form_id" => "2", "is_admin_only" => '0', "sequence" => "2","description"  => "What is your ID Number?", "type" => "text"
          ),
          array(
            "id"    => "7", "queue_form_id" => "2", "is_admin_only" => '0', "sequence" => "3","description"  => "What is your Course and Year Level?", "type" => "text"
          ),
          array(
            "id"    => "8", "queue_form_id" => "2", "is_admin_only" => '0', "sequence" => "4","description"  => "What is your Concerns?", "type" => "text"
          ),

          /*
            DCLL
          */
          array(
            "id"    => "9", "queue_form_id" => "3", "is_admin_only" => '0', "sequence" => "1","description"  => "What is your Complete Name?", "type" => "text"
          ),
          array(
            "id"    => "10", "queue_form_id" => "3", "is_admin_only" => '0', "sequence" => "2","description"  => "What is your ID Number?", "type" => "text"
          ),
          array(
            "id"    => "11", "queue_form_id" => "3", "is_admin_only" => '0', "sequence" => "3","description"  => "What is your Course and Year Level?", "type" => "text"
          ),
          array(
            "id"    => "12", "queue_form_id" => "3", "is_admin_only" => '0', "sequence" => "4","description"  => "What is your Concerns?", "type" => "text"
          ),

          /*
            DCLL ENROLMENT
          */
          array(
            "id"    => "13", "queue_form_id" => "4", "is_admin_only" => '0', "sequence" => "1","description"  => "What is your Complete Name?", "type" => "text"
          ),
          array(
            "id"    => "14", "queue_form_id" => "4", "is_admin_only" => '0', "sequence" => "2","description"  => "What is your ID Number?", "type" => "text"
          ),
          array(
            "id"    => "15", "queue_form_id" => "4", "is_admin_only" => '0', "sequence" => "3","description"  => "What is your Course and Year Level?", "type" => "text"
          ),
          array(
            "id"    => "16", "queue_form_id" => "4", "is_admin_only" => '0', "sequence" => "4","description"  => "What is your Concerns?", "type" => "text"
          ),
          
        ));
    }
}
