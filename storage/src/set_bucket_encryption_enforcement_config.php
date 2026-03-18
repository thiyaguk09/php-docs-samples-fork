<?php
/**
 * Copyright 2026 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/main/storage/README.md
 */

namespace Google\Cloud\Samples\Storage;

# [START storage_set_bucket_encryption_enforcement_config]
use Google\Cloud\Storage\StorageClient;

/**
 * Creates a bucket with specific encryption enforcement (e.g., CMEK-only).
 *
 * @param string $bucketName The ID of your GCS bucket (e.g. "my-bucket").
 * @param string $kmsKeyName The name of the KMS key to be used as the default (e.g. "projects/my-project/...").
 */
function set_bucket_encryption_enforcement_config(string $bucketName, string $kmsKeyName): void
{
    $storage = new StorageClient();
    $bucket = $storage->bucket($bucketName);

    // This configuration enforces that all objects uploaded to the bucket
    // must use Customer Managed Encryption Keys (CMEK).
    $options = [
        'encryption' => [
            'defaultKmsKeyName' => $kmsKeyName,
            'googleManagedEncryptionEnforcementConfig' => [
                'restrictionMode' => 'FullyRestricted',
            ],
            'customerSuppliedEncryptionEnforcementConfig' => [
                'restrictionMode' => 'FullyRestricted',
            ],
            'customerManagedEncryptionEnforcementConfig' => [
                'restrictionMode' => 'NotRestricted',
            ],
        ],
    ];
    $storage->createBucket($bucketName, $options);

    printf('Bucket %s created with encryption enforcement configuration.' . PHP_EOL, $bucketName);
}
# [END storage_set_bucket_encryption_enforcement_config]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
