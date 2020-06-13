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
            'title' => 'Laravel',
            'text' => 'php artisan serve',
            'url' => '',
            'color' => 'indigo'
        ];
        Label::create($param);

    }
}
