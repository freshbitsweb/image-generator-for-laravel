<?php

namespace FreshbitsWeb\ImageGenerator\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImageGeneratorCommand extends Command
{
    public $signature = 'generate:images {--name=Hello World!!} {--width=300} {--height=300}';

    public $description = 'This command lets you generate images.';

    public function handle(): int
    {
        [$name, $width, $height] = $this->askQuestions();

        if ($width === 0) {
            $this->error('Width must be greater than 0');

            return static::INVALID;
        }

        if ($height === 0) {
            $this->error('Height must be greater than 0');

            return static::INVALID;
        }

        $this->createImage($name, $width, $height);

        return static::SUCCESS;
    }

    private function askQuestions(): array
    {
        $name = $this->ask('What is the name of the image?', $this->option('name'));
        $width = (int) $this->ask('What is the width of the image?', $this->option('width'));
        $height = (int) $this->ask('What is the height of the image?', $this->option('height'));

        return [$name, $width, $height];
    }

    private function createImage(string $name, int $width, int $height): void
    {
        if (Storage::exists("public/$name.png")) {
            throw new Exception('File already exists');
        }

        // Step 1: Open the file with write permissions
        $file = @fopen(storage_path("app/public/$name.png"), 'x');

        $image = @imagecreate($width, $height);

        // White background
        $bgColor = @imagecolorallocate($image, 255, 255, 255);

        // Black text
        $textColor = @imagecolorallocate($image, 0, 0, 0);

        @imagestring($image, 5, 10, 10, $name, $textColor);

        if (! is_bool($file)) {
            // Step 3: Write the image to the file
            @imagepng($image, $file);

            // Step 4: Close the file
            fclose($file);
        }

        // Step 6: Free up memory by destroying the image resource
        imagedestroy($image);
    }
}
