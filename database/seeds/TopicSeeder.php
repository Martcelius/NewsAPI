<?php

use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topic = new App\Topic([
            'topic' => 'pemilu',
        ]);
        $topic->save();

        $topic = new app\Topic([
            'topic' => 'politik',
        ]);
        $topic->save();

        $topic = new app\Topic([
            'topic' => 'mobil',
        ]);
        $topic->save();
    }
}
