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
            'url' => 'https://qiita.com/',
            'color' => 'indigo'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '1',
            'title' => 'Docker',
            'text' => 'docker-compose exec wordspace bash',
            'url' => 'https://qiita.com/__takunosuke',
            'color' => 'teal'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '1',
            'title' => 'Docker',
            'text' => 'docker ps -a',
            'url' => null,
            'color' => 'pink'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '1',
            'title' => 'PHP',
            'text' => 'require once',
            'url' => '',
            'color' => 'grey'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '1',
            'title' => 'Laravel',
            'text' => 'php artisan db:seed',
            'url' => null,
            'color' => 'brown'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '1',
            'title' => 'Laravel',
            'text' => 'php artisan routes:list',
            'url' => '',
            'color' => 'green'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '1',
            'title' => 'Docker',
            'text' => 'docker-compose up -d',
            'url' => null,
            'color' => 'orange'
        ];
        Label::create($param);
        $param = [
            'label_folder_id' => '1',
            'title' => 'Vue.js',
            'text' => 'v-model',
            'url' => null,
            'color' => 'purple'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '1',
            'title' => 'おいしい居酒屋',
            'text' => 'ぐるなび',
            'url' => '',
            'color' => 'black'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '1',
            'title' => 'マイナビ',
            'text' => '転職用',
            'url' => 'https://aws.amazon.com/jp/',
            'color' => 'indigo'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '1',
            'title' => 'vim',
            'text' => 'insert',
            'url' => null,
            'color' => 'red'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '1',
            'title' => 'shell',
            'text' => 'pwd',
            'url' => 'https://materialdesignicons.com/',
            'color' => 'cyan'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '2',
            'title' => 'コマンド',
            'text' => 'cd',
            'url' => null,
            'color' => 'grey'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '2',
            'title' => 'Java Script',
            'text' => 'getElementById',
            'url' => null,
            'color' => 'orange'
        ];
        Label::create($param);

        $param = [
            'label_folder_id' => '3',
            'title' => 'Docker image 全削除',
            'text' => 'hello3',
            'url' => null,
            'color' => 'pink'
        ];
        Label::create($param);
    }
}
