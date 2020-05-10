<?php

use Illuminate\Database\Seeder;
use App\Label;

class LabelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'label_folder_id' => '1',
            'title' => 'test1',
            'text' => 'hello1',
            'url' => 'null',
            'color' => 'indigo'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '1',
            'title' => 'test2',
            'text' => 'hello2',
            'url' => 'null',
            'color' => 'teal'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '2',
            'title' => 'test3',
            'text' => 'hello3',
            'url' => 'null',
            'color' => 'grey'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '2',
            'title' => 'test3',
            'text' => 'hello3',
            'url' => 'null',
            'color' => 'orange'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '3',
            'title' => 'test3',
            'text' => 'hello3',
            'url' => 'null',
            'color' => 'pink'
        ];
        Label::create($param);
    }
}
