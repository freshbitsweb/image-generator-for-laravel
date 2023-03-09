<?php

use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::delete('public/Test.png');
});

it('can generate the image', function () {
    expect(Storage::fileExists('public/Test.png'))
        ->toBeFalse();

    $this->artisan('generate:image --name=Test --width=300 --height=100')
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
