<?php

namespace Database\Seeders;

use App\Models\CommitteeTags;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivityTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = [
            ['Feest','fas fa-glass-cheers', 'bg-danger'],
            ['Kamp','fas fa-fire-alt','bg-warning'],
            ['Activiteit','fas fa-snowboarding','bg-success'],
            ['Studie','fas fa-book','bg-info'],
            ['Algemeen','fas fa-bookmark','bg-secondary']
        ];
        foreach($arr as $tag) {
            $newTag = new CommitteeTags();
            $newTag->name = $tag[0];
            $newTag->icon = $tag[1];
            $newTag->colorClass = $tag[2];
            $newTag->save();
        }
    }
}
