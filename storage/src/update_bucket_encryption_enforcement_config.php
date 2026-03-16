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

# [START storage_update_bucket_encryption_enforcement_config]
use Google\Cloud\Storage\StorageClient;

/**
 * Updates or removes encryption enforcement configurations from a bucket.
 *
 * @param string $bucketName The ID of your GCS bucket (e.g. "my-bucket").
 */
function update_bucket_encryption_enforcement_config(string $bucketName): void
{
    $storage = new StorageClient();
    $bucket = $storage->bucket($bucketName);

    // Update a specific encryption type's restriction mode
    // This partial update preserves other existing encryption settings.
    $updateOptions = [
        'encryption' => [
            'googleManagedEncryptionEnforcementConfig' => [
                'restrictionMode' => 'FullyRestricted'
            ]
        ]
    ];
    $bucket->update($updateOptions);
    printf('Google-managed encryption enforcement set to FullyRestricted for %s.' . PHP_EOL, $bucketName);

    // Remove all encryption enforcement configurations altogether
    // Setting these values to null removes the policies from the bucket metadata.
    $clearOptions = [
        'encryption' => [
            'defaultKmsKeyName' => null,
            'googleManagedEncryptionEnforcementConfig' => null,
            'customerSuppliedEncryptionEnforcementConfig' => null,
            'customerManagedEncryptionEnforcementConfig' => null,
        ],
    ];

    $bucket->update($clearOptions);
    printf('All encryption enforcement configurations removed from bucket %s.' . PHP_EOL, $bucketName);
}
# [END storage_update_bucket_encryption_enforcement_config]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
