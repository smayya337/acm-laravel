<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OfficerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $officers_24_25 = [
            [
                'username' => 'rce9je',
                'sort_order' => 1,
                'position' => 'Chair'
            ],
            [
                'username' => 'cgm5sa',
                'sort_order' => 2,
                'position' => 'Vice Chair'
            ],
            [
                'username' => 'ekm5sd',
                'sort_order' => 3,
                'position' => 'Secretary'
            ],
            [
                'username' => 'jqk5ct',
                'sort_order' => 4,
                'position' => 'Treasurer'
            ],
            [
                'username' => 'eav6vg',
                'sort_order' => 5,
                'position' => 'Event Coordinator'
            ],
            [
                'username' => 'dxw2ds',
                'sort_order' => 6,
                'position' => 'Outreach Officer'
            ],
            [
                'username' => 'bkh3jf',
                'sort_order' => 7,
                'position' => 'Webmaster'
            ],
            [
                'username' => 'uyf9an',
                'sort_order' => 8,
                'position' => 'HSPC Director'
            ],
            [
                'username' => 'pvz6tx',
                'sort_order' => 9,
                'position' => 'HSPC Head Judge'
            ]
        ];
        $officers_25_26 = [
            [
                'username' => 'eav6vg',
                'sort_order' => 1,
                'position' => 'Chair'
            ],
            [
                'username' => 'jwd2xc',
                'sort_order' => 2,
                'position' => 'Vice Chair'
            ],
            [
                'username' => 'bvn9ad',
                'sort_order' => 4,
                'position' => 'Treasurer'
            ],
            [
                'username' => 'kcp7wm',
                'sort_order' => 5,
                'position' => 'Event Coordinator'
            ],
            [
                'username' => 'yez9pj',
                'sort_order' => 6,
                'position' => 'Event Coordinator'
            ],
            [
                'username' => 'wvw4we',
                'sort_order' => 7,
                'position' => 'Outreach Officer'
            ],
            [
                'username' => 'dxw2ds',
                'sort_order' => 8,
                'position' => 'Outreach Officer'
            ],
            [
                'username' => 'bkh3jf',
                'sort_order' => 9,
                'position' => 'Webmaster'
            ],
            [
                'username' => 'jqk5ct',
                'sort_order' => 10,
                'position' => 'HSPC Director'
            ],
            [
                'username' => 'vmf5yp',
                'sort_order' => 11,
                'position' => 'HSPC Head Judge'
            ]
        ];
        for ($i = 0; $i < sizeof($officers_24_25); $i++) {
            $officer = $officers_24_25[$i];
            $user_id = DB::table('users')->where('username', $officer['username'])->value('id');
            $officer['user_id'] = $user_id;
            unset($officer['username']);
            $officer['year'] = 2024;
            DB::table('officers')->insert($officer);
        }
        for ($i = 0; $i < sizeof($officers_25_26); $i++) {
            $officer = $officers_25_26[$i];
            $user_id = DB::table('users')->where('username', $officer['username'])->value('id');
            $officer['user_id'] = $user_id;
            unset($officer['username']);
            $officer['year'] = 2025;
            DB::table('officers')->insert($officer);
        }
    }
}
