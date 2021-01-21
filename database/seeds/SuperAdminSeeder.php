<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // First user
		$adminUname = env('ADMIN_UNAME', 'admin');
		$adminFname = env('ADMIN_FNAME', 'FName');
		$adminLname = env('ADMIN_LNAME', 'LName');
		$adminMail = env('ADMIN_UNAME', 'example@example.com');
		$adminPassword = env('ADMIN_PASSWORD', 'laraveltest');
		
		
		// Drop the table
        DB::table('users')->delete();
        // Seed the table
        User::create(
            [
                'uname' => $adminUname,
                'fname' => $adminFname,
                'lname' => $adminLname,
                'email' => $adminMail,
                'password' => Hash::make($adminPassword)
            ]);
        $user = User::where('uname', $adminUname)->first();
        $user->assignRole('superAdmin');
    }
}
