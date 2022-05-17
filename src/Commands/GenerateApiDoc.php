<?php

namespace Axeldotdev\LaravelApiDoc\Commands;

use Illuminate\Console\Command;

class GenerateApiDoc extends Command
{
    public $signature = 'api-doc:generate';

    public $description = 'Generate the API Doc static views.';

    public function handle(): int
    {
        // TODO: generate the php file from the blade file

        return static::SUCCESS;
    }
}
