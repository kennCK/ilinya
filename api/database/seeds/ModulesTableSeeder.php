<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB:: table('modules') -> insert(array(
        //Dashboard
        array('id' => 1, 'parent_id' => 0,  'description'=>'Form Management', 'icon' => 'fa fa-address-card-o', 'path' => 'form_management', 'rank' => 1),
        //Workforce Management
        array('id' => 10, 'parent_id' => 0,  'description'=>'Queueing Management', 'icon' => 'fa fa-clock-o',  'path' => 'queueing_management', 'rank' => 2),      

      ));
    }
}
