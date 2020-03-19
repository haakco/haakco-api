<?php

namespace App\Jobs;

use App\Libraries\AgentString\AgentStringParsingLibrary;
use App\Models\AgentString;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AgentStringParseJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $agentString;

    /**
     * Create a new job instance.
     *
     * @param AgentString $agentString
     */
    public function __construct(AgentString $agentString)
    {
        $this->agentString = $agentString;
    }

    /**
     * Execute the job.
     *
     * @param AgentStringParsingLibrary $agentStringLibrary
     *
     * @return void
     */
    public function handle(AgentStringParsingLibrary $agentStringLibrary)
    {
        //Confirm someone else didn't update agent string
        $exists = AgentString::query()
            ->where('id', $this->agentString->id)
            ->where('parsed', true)
            ->exists();

        if (!$exists) {
            $agentStringLibrary->parseAgentStrings($this->agentString);
        }
    }
}
