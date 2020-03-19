<?php

namespace App\Console\Commands;

use App\Libraries\AgentString\AgentStringParsingLibrary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AgentStringParseConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agent:update {--minutesBack=15}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses agent string to extract data';

    /**
     * Execute the console command.
     *
     * @param AgentStringParsingLibrary $agentStringLibrary
     *
     * @return mixed
     */
    public function handle(AgentStringParsingLibrary $agentStringLibrary)
    {
        $minutesBack = (int)$this->option('minutesBack');
        Log::info('Console ' . $this->getName() . ' minutesBack=' . $minutesBack);

        $agentStringLibrary->updateAll($minutesBack);
    }
}
