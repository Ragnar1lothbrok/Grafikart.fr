<?php

use App\Domains\Course\Course;
use Illuminate\Support\Carbon;

it('does not include scheduled courses in rss feed', function () {
    Carbon::setTestNow('2026-07-12 12:00:00');

    $published = Course::factory()->online()->create([
        'title' => 'Published course',
        'created_at' => now()->subDay(),
    ]);

    $scheduled = Course::factory()->online()->create([
        'title' => 'Scheduled course',
        'created_at' => now()->addDay(),
    ]);

    $this->get('/feed.rss')
        ->assertSuccessful()
        ->assertSee($published->title)
        ->assertDontSee($scheduled->title);
});
