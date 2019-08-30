<?php

use App\Models\Teacher;

use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{
    public function run()
    {
        $rows = [
            '田川暮',
            '郭昱文',
            '田春岚',
            '金嫔然',
            '崔博雅',
            '彭学英',
            '夏夏柳',
            '宋孤云',
            '金朝雨',
            '邱彦露',
            '方知睿',
            '金婀娜',
            '余冬寒',
            '张凉音',
            '邓婷丽',
        ];
        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'name' => $row
            ];
        }
        Teacher::query()->delete();
        Teacher::query()->insert($result);
    }
}
