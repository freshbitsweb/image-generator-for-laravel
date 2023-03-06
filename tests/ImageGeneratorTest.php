<?php

use Illuminate\Support\Facades\Storage;

it('can ask questions', function () {
    Storage::deleteDirectory('public');

    $this->artisan('generate:images')
        ->expectsQuestion('What is the name of the image?', 'Test')
        ->expectsQuestion('What is the width of the image?', 300)
        ->expectsQuestion('What is the height of the image?', 300)
        ->assertExitCode(0);
});
