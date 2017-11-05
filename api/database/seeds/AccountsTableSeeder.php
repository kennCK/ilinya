<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account2 = Hash::make('uscpsych2017');
        $account3 = Hash::make('uscdcll2017');
        DB:: table('accounts') -> insert(array(
          array("id" => "2","username" => "uscpsych", "email" => "support@ilinya.com", "password" => $account2), 
          array("id" => "3","username" => "uscdcll", "email" => "support@ilinya.com", "password" => $account3),
        ));
    }
}
