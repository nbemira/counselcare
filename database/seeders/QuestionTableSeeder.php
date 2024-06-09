<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionTableSeeder extends Seeder
{
    public function run(): void
    {
        Question::create([
            'id' => '1',
            'question' => 'I found it hard to wind down',
            'category_id' => '3',
        ]);

        Question::create([
            'id' => '2',
            'question' => 'I was aware of dryness of my mouth',
            'category_id' => '2',
        ]);

        Question::create([
            'id' => '3',
            'question' => 'I could not seem to experience any positive feeling at all',
            'category_id' => '1',
        ]);

        Question::create([
            'id' => '4',
            'question' => 'I experienced breathed difficulty',
            'category_id' => '2',
        ]);

        Question::create([
            'id' => '5',
            'question' => 'I found it difficult to work up the initiative to do things',
            'category_id' => '1',
        ]);

        Question::create([
            'id' => '6',
            'question' => 'I tended to over-react to situations',
            'category_id' => '3',
        ]);

        Question::create([
            'id' => '7',
            'question' => 'I experienced trembling',
            'category_id' => '2',
        ]);
        
        Question::create([
            'id' => '8',
            'question' => 'I felt that I was using a lot of nervous energy',
            'category_id' => '3',
        ]);

        Question::create([
            'id' => '9',
            'question' => 'I was worried about situations in which I might panic and make a fool of myself',
            'category_id' => '2',
        ]);

        Question::create([
            'id' => '10',
            'question' => 'I felt that I had nothing to look forward to',
            'category_id' => '1',
        ]);

        Question::create([
            'id' => '11',
            'question' => 'I found myself getting agigate',
            'category_id' => '3',
        ]);
        
        Question::create([
            'id' => '12',
            'question' => 'I found it difficult to relax',
            'category_id' => '3',
        ]);

        Question::create([
            'id' => '13',
            'question' => 'I felt down-hearted and blue',
            'category_id' => '1',
        ]);

        Question::create([
            'id' => '14',
            'question' => 'I was intolerant of anything that kept from getting on with what I was doing',
            'category_id' => '3',
        ]);
        
        Question::create([
            'id' => '15',
            'question' => 'I felt I was close to panic',
            'category_id' => '2',
        ]);

        Question::create([
            'id' => '16',
            'question' => 'I was unable to become enthusiastic about anything',
            'category_id' => '1',
        ]);

        Question::create([
            'id' => '17',
            'question' => 'I felt I was not worth much as a person',
            'category_id' => '1',
        ]);

        Question::create([
            'id' => '18',
            'question' => 'I felt that I was rather touchy',
            'category_id' => '3',
        ]);
        
        Question::create([
            'id' => '19',
            'question' => 'I was aware of the action of my heart in the absense of physical exertion',
            'category_id' => '2',
        ]);

        Question::create([
            'id' => '20',
            'question' => 'I felt scared without any good reason',
            'category_id' => '2',
        ]);
        
        Question::create([
            'id' => '21',
            'question' => 'I felt that life was meaningless',
            'category_id' => '1',
        ]);
    }
}
