<?php

namespace App\Console\Commands;

use App\Libraries\Helper\UrlLibrary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ShortUrlTackingCheckConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shortUrl:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Goes through all short url data to fix problem';

    /**
     * Execute the console command.
     *
     * @param UrlLibrary $urlLibrary
     * @return mixed
     */
    public function handle(UrlLibrary $urlLibrary)
    {
        Log::info('Console start ' . $this->getName());

        $urlLibrary->fixShortURLTracking();
    }
}
