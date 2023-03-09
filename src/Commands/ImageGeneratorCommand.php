<?php

namespace FreshbitsWeb\ImageGenerator\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImageGeneratorCommand extends Command
{
    public $signature = 'generate:image {name?} {width?} {height?}';

    public $description = 'This command lets you generate images.';

    public function handle(): int
    {
        [$name, $width, $height] = $this->promptForImageDetails();

        $this->generateImage($name, $width, $height);

        return static::SUCCESS;
    }

    private function promptForImageDetails(): array
    {
        $name = $this->argument('name') ?: $this->ask('What is the name of the image?', 'Hello World!!');
        $width = (int) $this->argument('width') ?: $this->ask('What is the width of the image?', 300);
        $height = (int) $this->argument('height') ?: $this->ask('What is the height of the image?', 300);

        if ($width <= 0) {
            throw new Exception('Width must be greater than 0');
        }

        if ($height <= 0) {
            throw new Exception('Height must be greater than 0');
        }

        return [$name, $width, $height];
    }

    private function generateImage(string $name, int $width, int $height): void
    {
        if (Storage::exists("$name.png")) {
            throw new Exception('File already exists');
        }

        // Step 1: Open the file with write permissions
        $file = @fopen(Storage::path("public/$name.png"), 'w');

        $image = @imagecreate($width, $height);

        // White background
        @imagecolorallocate($image, 255, 255, 255);

        // Black text
        $textColor = @imagecolorallocate($image, 0, 0, 0);

        @imagestring($image, 5, 10, 10, $name, $textColor);

        // Step 3: Write the image to the file
        @imagepng($image, $file);

        // Step 4: Close the file
        @fclose($file);

        // Step 6: Free up memory by destroying the image resource
        @imagedestroy($image);
    }
}
