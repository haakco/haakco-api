<?php

namespace App\Console\Commands;

use App\Libraries\Helper\MinioS3Library;
use Illuminate\Console\Command;

class MinioAddDefaultBuckets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minio:addDefaultBuckets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds required default buckets when using minio';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(MinioS3Library $minioS3Library)
    {
        $minioS3Library->createDefaultBuckets();
    }
}
