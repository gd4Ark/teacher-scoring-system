<?php

use App\Models\Subject;

use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    public function run()
    {
        $rows = [
            '计算机维修',
            '网络管理',
            '数据库',
            'C语言',
            '前端开发',
            '后端开发',
            '云计算基础',
            'VB语言',
            '综合布线',
            'PhotoShop',
            'Flash动画制作',
            '计算机英语',
            '电子电工基础',
            '应用文',
            '新模式英语',
        ];
        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'name' => $row
            ];
        }
        Subject::query()->delete();
        Subject::query()->insert($result);
    }
}
