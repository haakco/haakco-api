<?php

namespace App\Libraries\Helper;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Carbon\Carbon;
use Illuminate\Console\OutputStyle;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;

class MinioS3Library
{
    /**
     * @var \Aws\S3\S3Client
     */
    private S3Client $s3Client;

    public function __construct()
    {
        $this->s3Client = new S3Client(
            [
                'region' => config('filesystems.disks.minio.region'),
                'version' => '2006-03-01',
                'endpoint' => config('filesystems.disks.minio.endpoint'),
                'credentials' => [
                    'key' => config('filesystems.disks.minio.key'),
                    'secret' => config('filesystems.disks.minio.secret'),
                ],
                // Set the S3 class to use objects.dreamhost.com/bucket
                // instead of bucket.objects.dreamhost.com
                'use_path_style_endpoint' => config('filesystems.disks.minio.use_path_style_endpoint'),
            ]
        );
    }

    public function getListOfBuckets()
    {
        $listResponse = $this->s3Client->listBuckets();

        return collect($listResponse['Buckets'])
            ->reduce(function ($carry, $item) {
                $name = $item['Name'];
                /** @var \Aws\Api\DateTimeResult $creationDate */
                $creationDate = $item['CreationDate'];
                $carry[$item['Name']] = [
                    'name' => $item['Name'],
                    'creationDate' => Carbon::createFromTimestamp($creationDate->getTimestamp()),
                ];
                return $carry;
            }, []);
    }

    public function createBucket($bucketName): bool
    {
        try {
            $result = $this->s3Client->createBucket(
                [
                    'Bucket' => $bucketName,
                ]
            );
        } catch (AwsException $e) {
            echo $e->getMessage();
            echo "\n";
            return false;
        }

        return $result['@metadata']['statusCode'] === 200;
    }

    public function createDefaultBuckets()
    {
        $currentBuckets = $this->getListOfBuckets();
        if (!array_key_exists(config('filesystems.disks.minio.bucket'), $currentBuckets)) {
            $this->createBucket(config('filesystems.disks.minio.bucket'));
        } else {
            Log::error('Bucket already exists. Cowardly failing to create a new one');
            if (App::runningInConsole()) {
                $output = new ConsoleOutput();
                $output->writeln('Bucket already exists. Cowardly failing to create a new one');
            }
        }
    }
}
