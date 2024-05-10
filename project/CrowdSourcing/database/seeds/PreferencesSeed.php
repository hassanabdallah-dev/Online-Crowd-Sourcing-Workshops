<?php

use Illuminate\Database\Seeder;
use App\Preferences;
class PreferencesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Preferences::create(
            [
                'name' => 'validation',
                'enable' => false,
                'descripton' => 'Validate every newly registered account manually',
        ]);
        Preferences::create(
            [
                'name' => 'role',
                'enable' => false,
                'descripton' => 'Let users specify their role',
        ]);

            Preferences::create(
                [
                    'name' => 'deac-admin',
                    'enable' => false,
                    'descripton' => 'Make Admin Users Deactivatable',
        ]);
            Preferences::create(
                [
                   'name' => 'delete-admin',
                   'enable' => false,
                   'descripton' => 'Make Admin Users Deletable',
                ]);
        Preferences::create(
                [
                       'name' => 'rounds-number',
                        'enable' => false,
                        'value' => 5,
                        'descripton' => 'Specify the number of rounds in workshops, the maximum number of rounds is number of participants -1. In case the maximum is exceeded the the workshop will cintinue untill everyone has voted every idea.',
        ]);
        Preferences::create(
            [
                   'name' => 'email-verification',
                    'enable' => false,
                    'descripton' => 'Every Newly Registered Account Should Be Confirmed by Email Address',
    ]);
    Preferences::create(
        [
               'name' => 'workshop-deactivate',
                'enable' => false,
                'descripton' => 'End workshop automatically once all participants registered in a group.This Preference is not effective if for workshops that passed voting stage.',
]);
        }
}
