<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_account = new User;

        $admin_account->name = "Master Account";
        $admin_account->email = "admin@admin.com";
        $admin_account->password = bcrypt("admin");
        $admin_account->user_role = 2;
        $admin_account->account_status = 1;

        $admin_account->save();
    }
}
