<?php

use Illuminate\Support\Facades\Storage;

it('can generate the image', function () {
    Storage::delete('public/Test.png');

    $this->artisan('generate:images Test 300 100')
        ->assertExitCode(0);

    expect(Storage::fileExists('public/Test.png'))
        ->toBeTrue();

    Storage::assertExists('public/Test.png');
});
