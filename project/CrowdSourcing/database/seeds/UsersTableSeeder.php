<?php

use Illuminate\Database\Seeder;
use \App\User;
use \App\Preferences;
use \App\Role;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function getTime($verified){
        if($verified){
            return now();
        }
        return NULL;
    }
    public function run()
    {
        $adminRole = Role::where('name' , 'admin')->first();
        $monitorRole = Role::where('name' , 'monitor')->first();
        $participantRole = Role::where('name' , 'participant')->first();
        $activated = Preferences::where('name', 'validation')->first()->enable;
        $verified = Preferences::where('name', 'email-verification')->where('enable',false)->exists();
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'activated' => true,
            'email_verified_at' => now()
        ]);
        $monitor = User::create([
            'name' => 'Monitor User',
            'email' => 'monitor@monitor.com',
            'password' => Hash::make('12345678'),
            'activated' => !$activated,
            'email_verified_at' => $this->getTime($verified)
        ]);
        $participant1 = User::create([
            'name' => 'participant1 User',
            'email' => 'p1@p1.com',
            'password' => Hash::make('12345678'),
            'activated' => !$activated,
            'email_verified_at' => $this->getTime($verified)
        ]);
        $participant2 = User::create([
            'name' => 'participant2 User',
            'email' => 'p2@p2.com',
            'password' => Hash::make('12345678'),
            'activated' => !$activated,
            'email_verified_at' => $this->getTime($verified)
        ]);
        $participant3 = User::create([
            'name' => 'participant3 User',
            'email' => 'p3@p3.com',
            'password' => Hash::make('12345678'),
            'activated' => !$activated,
            'email_verified_at' => $this->getTime($verified)
        ]);
        $participant4 = User::create([
            'name' => 'participant4 User',
            'email' => 'p4@p4.com',
            'password' => Hash::make('12345678'),
            'activated' => !$activated,
            'email_verified_at' => $this->getTime($verified)
        ]);
        $participant5 = User::create([
        'name' => 'participant5 User',
        'email' => 'p5@p5.com',
        'password' => Hash::make('12345678'),
        'activated' => !$activated,
        'email_verified_at' => $this->getTime($verified)
         ]);
        $participant6 = User::create([
            'name' => 'participant6 User',
            'email' => 'p6@p6.com',
            'password' => Hash::make('12345678'),
            'activated' => !$activated,
            'email_verified_at' => $this->getTime($verified)
        ]);
        $participant7 = User::create([
            'name' => 'participant7 User',
            'email' => 'p7@p7.com',
            'password' => Hash::make('12345678'),
            'activated' => !$activated,
            'email_verified_at' => $this->getTime($verified)
        ]);
        $participant8 = User::create([
            'name' => 'participant8 User',
            'email' => 'p8@p8.com',
            'password' => Hash::make('12345678'),
            'activated' => !$activated,
            'email_verified_at' => $this->getTime($verified)
        ]);
        $participant9 = User::create([
            'name' => 'participant9 User',
            'email' => 'p9@p9.com',
            'password' => Hash::make('12345678'),
            'activated' => !$activated,
            'email_verified_at' => $this->getTime($verified)
        ]);
        $participant10 = User::create([
            'name' => 'participant10 User',
            'email' => 'p10@p10.com',
            'password' => Hash::make('12345678'),
            'activated' => !$activated,
            'email_verified_at' => $this->getTime($verified)
        ]);
        $admin->roles()->attach($adminRole);
        $monitor->roles()->attach($monitorRole);
        $participant10->roles()->attach($participantRole);
        $participant9->roles()->attach($participantRole);
        $participant8->roles()->attach($participantRole);
        $participant7->roles()->attach($participantRole);
        $participant6->roles()->attach($participantRole);
        $participant5->roles()->attach($participantRole);
        $participant4->roles()->attach($participantRole);
        $participant3->roles()->attach($participantRole);
        $participant2->roles()->attach($participantRole);
        $participant1->roles()->attach($participantRole);

    }
}
