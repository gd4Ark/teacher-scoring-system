<?php

use App\Models\Group;

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    public function run()
    {
        $rows = [
            '16春计网专（1）',
            '17春计网专（2）',
            '18春计网专（3）',
            '16春会计专（1）',
            '17春会计专（2）',
            '18春会计专（3）',
            '16春电商专（1）',
            '17春电商专（2）',
            '18春电商专（3）',
        ];
        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'name' => $row
            ];
        }
        Group::query()->delete();
        Group::query()->insert($result);
    }
}
