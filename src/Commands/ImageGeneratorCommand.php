<?php

namespace FreshbitsWeb\ImageGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class ImageGeneratorCommand extends Command
{
    public $signature = 'generate:image {--name=} {--width=} {--height=} {--bgColor=} {--textColor=}';

    public $description = 'This command lets you generate images.';

    public function handle(): int
    {
        [$name, $width, $height, $bgColor, $textColor] = $this->promptForImageDetails();

        if ($this->validateTheArgument($name, $width, $height)) {
            return static::INVALID;
        }

        $html = $this->renderView($name, $bgColor, $textColor);

        $this->generateImage($name, $width, $height, $html);

        $this->successMessage($name);

        return static::SUCCESS;
    }

    private function promptForImageDetails(): array
    {
        $name = $this->option('name') ?: $this->ask('What is the name of the image?', 'Hello world!!');
        $width = (int) $this->option('width') ?: (int) $this->ask('What is the width of the image?', config('image-generator.width'));
        $height = (int) $this->option('height') ?: (int) $this->ask('What is the height of the image?', config('image-generator.height'));
        $bgColor = $this->option('bgColor') ?: $this->ask('What is the background color of the image?', config('image-generator.background_color'));
        $textColor = $this->option('textColor') ?: $this->ask('What is the text color of the image?', config('image-generator.text_color'));

        return [$name, $width, $height, $bgColor, $textColor];
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

    private function generateImage(string $name, int $width, int $height, string $html): void
    {
        Browsershot::html($html)
            ->windowSize($width, $height)
            ->save(Storage::path("public/$name.png"));
    }

    private function successMessage(string $name)
    {
        $this->info('╭───────────────────────────────────────────╮');
        $this->info('│'.str_pad(' IMAGE CREATED 🤙', 43, ' ', STR_PAD_BOTH).'  │');
        $this->info('╰───────────────────────────────────────────╯');
        $this->newLine();
        $this->line('<options=bold;fg=green>IMAGE PATH:</> '.Storage::path("public/$name.png"));
    }

    private function renderView(string $name, string $bgColor, string $textColor)
    {
        return view('image-generator-for-laravel::theme', [
            'name' => $name,
            'backgroundColor' => $bgColor,
            'textColor' => $textColor,
        ])->render();
    }
}
