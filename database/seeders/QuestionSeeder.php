<?php

namespace Database\Seeders;

use App\Enums\QuestionStatus;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'content' => 'Có cách nào code không có bug hay code một lần success luôn không?',
                'content_en' => 'Is there a way to code without bugs or to code successfully once?',
                'content_laos' => 'Is there a way to code without bugs or to code successfully once?',
                'user_id' => 1,
                'status' => QuestionStatus::APPROVED,
            ],
            [
                'content' => 'Có cách nào yêu nhiều người cùng một lúc hay không',
                'content_en' => 'Is there a way to love many people at the same time?',
                'content_laos' => 'Is there a way to love many people at the same time?',
                'user_id' => 2,
                'status' => QuestionStatus::APPROVED,
            ]
        ];

        Question::insert($questions);
    }
}
