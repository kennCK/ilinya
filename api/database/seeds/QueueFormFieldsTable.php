<?php

use Illuminate\Database\Seeder;

class QueueFormFieldsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    		/*
				$table->increments('id');
        $table->integer('queue_form_id');
        $table->integer('sequence');
        $table->string('description');
        $table->integer('type');
        $table->string('setting')->nullable();
        $table->boolean('main_field');
    		*/
        DB:: table('queue_form_fields') -> insert(array(
        	/*
						K1 Reservation
        	*/
          array(
            "id"    => "1", "queue_form_id" => "1","sequence"  => "1", 'description' => 'What is your Complete Name?', 'type' => 'text'
          ),
          array(
            "id"    => "2", "queue_form_id" => "1","sequence"  => "2", 'description' => 'What is your Contact Number?', 'type' => 'number'
          ),
          array(
            "id"    => "3", "queue_form_id" => "1","sequence"  => "3", 'description' => 'How many are you?', 'type' => 'number'
          ),
          array(
            "id"    => "4", "queue_form_id" => "1","sequence"  => "4", 'description' => 'How many hours you want to reserve?', 'type' => 'number'
          ),

          /*

						Roble Ticketing
          */
          array(
            "id"    => "5", "queue_form_id" => "2","sequence"  => "1", 'description' => 'What is your Complete Name?', 'type' => 'text'
          ),
          array(
            "id"    => "6", "queue_form_id" => "2","sequence"  => "2", 'description' => 'What is your Contact Number?', 'type' => 'number'
          ),
          array(
            "id"    => "7", "queue_form_id" => "2","sequence"  => "3", 'description' => 'What is your Address?', 'type' => 'text'
          ),


          /*

						SM Ticketing
          */
          array(
            "id"    => "8", "queue_form_id" => "3","sequence"  => "1", 'description' => 'What is your Complete Name?', 'type' => 'text'
          ),
          array(
            "id"    => "9", "queue_form_id" => "3","sequence"  => "2", 'description' => 'What is your Contact Number?', 'type' => 'number'
          ),
          array(
            "id"    => "10", "queue_form_id" => "3","sequence"  => "3", 'description' => 'What is your Email Address?', 'type' => 'email'
          ),

          /*

						PINO Reservation
          */
          array(
            "id"    => "11", "queue_form_id" => "4","sequence"  => "1", 'description' => 'What is your Complete Name?', 'type' => 'text'
          ),
          array(
            "id"    => "12", "queue_form_id" => "4","sequence"  => "2", 'description' => 'What is your Contact Number?', 'type' => 'number'
          ),
          array(
            "id"    => "13", "queue_form_id" => "4","sequence"  => "3", 'description' => 'How many are you?', 'type' => 'text'
          ),
          array(
            "id"    => "14", "queue_form_id" => "4","sequence"  => "3", 'description' => 'What is the time you are going to eat?', 'type' => 'text'
          ),


           /*

						USC Payment
          */
          array(
            "id"    => "15", "queue_form_id" => "5","sequence"  => "1", 'description' => 'What is your ID Number?', 'type' => 'text'
          ),

          array(
            "id"    => "16", "queue_form_id" => "5","sequence"  => "2", 'description' => 'What is your Complete Name?', 'type' => 'text'
          ),
          array(
            "id"    => "17", "queue_form_id" => "5","sequence"  => "3", 'description' => 'How much do you want to pay?', 'type' => 'number'
          ),
          array(
            "id"    => "18", "queue_form_id" => "5","sequence"  => "4", 'description' => 'What is the purpose of payment?', 'type' => 'text'
          ),
          
        ));
    }
}
