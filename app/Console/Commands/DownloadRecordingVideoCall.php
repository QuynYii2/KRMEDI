<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Aws\S3\S3Client;

class DownloadRecordingVideoCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:allrecordings {searchString}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download all recordings from S3 where the name includes a specific string';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bucketName = ('video-storage-krmedi');
        $searchString = $this->argument('searchString');
        $saveDir = storage_path('app/video-record/');

        // Ensure the save directory exists
        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0777, true);
        }

        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => ('ap-southeast-2'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        try {
            // List objects in the bucket
            $result = $s3Client->listObjectsV2([
                'Bucket' => $bucketName,
                'Prefix' => '',
            ]);

            $objects = $result['Contents'];
            $filteredObjects = array_filter($objects, function ($object) use ($searchString) {
                return strpos($object['Key'], $searchString) !== false;
            });

            if (empty($filteredObjects)) {
                $this->info("No objects found with the search string: {$searchString}");
                return;
            }

            foreach ($filteredObjects as $object) {
                $objectKey = $object['Key'];
                $saveAsPath = $saveDir . basename($objectKey);

                $s3Client->getObject([
                    'Bucket' => $bucketName,

                    'Key'    => $objectKey,
                    'SaveAs' => $saveAsPath,
                ]);

                $this->info("File downloaded successfully: {$saveAsPath}");
            }
        } catch (Aws\Exception\AwsException $e) {
            $this->error("Error downloading files: " . $e->getMessage());
        }
    }
}
