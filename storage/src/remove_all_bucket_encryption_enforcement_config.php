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

# [START storage_remove_all_encryption_enforcement_config]
use Google\Cloud\Storage\StorageClient;

/**
 * Removes all encryption enforcement configurations from a bucket.
 *
 * @param string $bucketName The ID of your GCS bucket (e.g. "my-bucket").
 */
function remove_all_bucket_encryption_enforcement_config(string $bucketName): void
{
    $storage = new StorageClient();
    $bucket = $storage->bucket($bucketName);

    // Setting these values to null in an update call will remove the
    // specific enforcement policies from the bucket metadata.
    $options = [
        'encryption' => [
            'defaultKmsKeyName' => null,
            'googleManagedEncryptionEnforcementConfig' => null,
            'customerSuppliedEncryptionEnforcementConfig' => null,
            'customerManagedEncryptionEnforcementConfig' => null,
        ],
    ];

    $bucket->update($options);

    printf('Encryption enforcement configuration removed from bucket %s.' . PHP_EOL, $bucketName);
}
# [END storage_remove_all_encryption_enforcement_config]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
