<?php

namespace FreshbitsWeb\ImageGenerator\Commands;

use Illuminate\Console\Command;

class ImageGeneratorCommand extends Command
{
    public $signature = 'generate:images';

    public $description = 'This command lets you generate images.';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
