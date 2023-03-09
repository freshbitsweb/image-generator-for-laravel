<?php

use Illuminate\Support\Facades\Storage;

it('can generate the image', function () {
    Storage::delete('public/Test.png');

    expect(Storage::fileExists('public/Test.png'))
        ->toBeFalse();

    $this->artisan('generate:image Test 300 100')
        ->assertExitCode(0);

    expect(Storage::fileExists('public/Test.png'))
        ->toBeTrue();
});

it('can ask the question for generate the image', function () {
    $this->artisan('generate:image')
        ->expectsQuestion('What is the name of the image?', 'Test')
        ->expectsQuestion('What is the width of the image?', 300)
        ->expectsQuestion('What is the height of the image?', 300)
        ->assertExitCode(0);
});
