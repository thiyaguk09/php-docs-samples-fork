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

# [START storage_get_bucket_encryption_enforcement_config]
use Google\Cloud\Storage\StorageClient;

/**
 * Retrieves the current encryption enforcement configurations for a bucket.
 *
 * @param string $bucketName The ID of your GCS bucket (e.g. "my-bucket").
 */
function get_bucket_encryption_enforcement_config(string $bucketName): void
{
    $storage = new StorageClient();
    $bucket = $storage->bucket($bucketName);
    $metadata = $bucket->info();

    printf('Encryption enforcement configuration for bucket %s.' . PHP_EOL, $bucketName);

    if (!isset($metadata['encryption'])) {
        print('No encryption configuration found (Default GMEK is active).' . PHP_EOL);
        return;
    }

    $enc = $metadata['encryption'];
    printf('Default KMS Key: %s' . PHP_EOL, $enc['defaultKmsKeyName'] ?? 'None');

    $printConfig = function ($label, $config) {
        if ($config) {
            printf('%s:' . PHP_EOL, $label);
            printf('  Mode: %s' . PHP_EOL, $config['restrictionMode']);
            printf('  Effective: %s' . PHP_EOL, $config['effectiveTime'] ?? 'N/A');
        }
    };

    $printConfig('Google Managed (GMEK) Enforcement', $enc['googleManagedEncryptionEnforcementConfig'] ?? null);
    $printConfig('Customer Managed (CMEK) Enforcement', $enc['customerManagedEncryptionEnforcementConfig'] ?? null);
    $printConfig('Customer Supplied (CSEK) Enforcement', $enc['customerSuppliedEncryptionEnforcementConfig'] ?? null);
}
# [END storage_get_bucket_encryption_enforcement_config]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
