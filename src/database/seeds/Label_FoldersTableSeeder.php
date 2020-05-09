<?php

use Illuminate\Database\Seeder;
use App\LabelFolder;

class Label_FoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param  = [
            'user_id' => '1',
            'title' => 'php',
        ];

        LabelFolder::create($param);

        $param  = [
            'user_id' => '1',
            'title' => 'ruby',
        ];

        LabelFolder::create($param);

        $param  = [
            'user_id' => '1',
            'title' => 'laravel',
        ];

        LabelFolder::create($param);

        $param  = [
            'user_id' => '1',
            'title' => 'Vue.js',
        ];

        LabelFolder::create($param);

        $param  = [
            'user_id' => '1',
            'title' => 'Vue.js',
        ];

        LabelFolder::create($param);

        $param  = [
            'user_id' => '1',
            'title' => 'Vue.js',
        ];

        LabelFolder::create($param);

        $param  = [
            'user_id' => '1',
            'title' => 'Vue.js',
        ];

        LabelFolder::create($param);

        $param  = [
            'user_id' => '1',
            'title' => 'Vue.js',
        ];

        LabelFolder::create($param);

        $param  = [
            'user_id' => '1',
            'title' => 'Vue.js',
        ];

        LabelFolder::create($param);

        $param  = [
            'user_id' => '2',
            'title' => 'Laravel',
        ];

        LabelFolder::create($param);

        $param  = [
            'user_id' => '2',
            'title' => 'Laravel',
        ];

        LabelFolder::create($param);

        $param  = [
            'user_id' => '2',
            'title' => 'Laravel',
        ];

        LabelFolder::create($param);

        $param  = [
            'user_id' => '2',
            'title' => 'Laravel',
        ];

        LabelFolder::create($param);
    }
}
