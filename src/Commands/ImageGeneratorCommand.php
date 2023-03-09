<?php

namespace FreshbitsWeb\ImageGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImageGeneratorCommand extends Command
{
    public $signature = 'generate:image {--name=} {--width=} {--height=}';

    public $description = 'This command lets you generate images.';

    public function handle(): int
    {
        [$name, $width, $height] = $this->promptForImageDetails();

        if ($this->validateTheArgument($name, $width, $height)) {
            return static::INVALID;
        }

        $this->generateImage($name, $width, $height);

        $this->successMessage($name);

        return static::SUCCESS;
    }

    private function promptForImageDetails(): array
    {
        $name = $this->option('name') ?: $this->ask('What is the name of the image?', 'Hello world!!');
        $width = (int) $this->option('width') ?: (int) $this->ask('What is the width of the image?', config('image-generator.width'));
        $height = (int) $this->option('height') ?: (int) $this->ask('What is the height of the image?', config('image-generator.height'));

        return [$name, $width, $height];
    }

    private function validateTheArgument(string $name, int $width, int $height): bool
    {
        if ($width <= 0) {
            $this->newLine();
            $this->line('<options=bold,reverse;fg=red>Oops! 😔 The width must be greater than 0. Please try again.</>');

            return true;
        }

        if ($height <= 0) {
            $this->newLine();
            $this->line('<options=bold,reverse;fg=red>Oops! 😔 The height must be greater than 0. Please try again.</>');

            return true;
        }

        if (Storage::exists("public/$name.png")) {
            $this->newLine();
            $this->line("<options=bold,reverse;fg=red> WHOOPS! </> 😳 \n");
            $this->line('<fg=red;options=bold>File is reserved:</>'.Storage::path("public/$name.png"));

            return true;
        }

        return false;
    }

    private function generateImage(string $name, int $width, int $height): void
    {
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

    private function successMessage(string $name)
    {
        $this->info('╭───────────────────────────────────────────╮');
        $this->info('│'.str_pad(' IMAGE CREATED 🤙', 43, ' ', STR_PAD_BOTH).'  │');
        $this->info('╰───────────────────────────────────────────╯');
        $this->newLine();
        $this->line('<options=bold;fg=green>IMAGE PATH:</> '.Storage::path("public/$name.png"));
    }
}
