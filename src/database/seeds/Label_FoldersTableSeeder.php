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
            'title' => 'Laravel',
        ];

        LabelFolder::create($param);
    }
}