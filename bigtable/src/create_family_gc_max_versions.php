<?php

/**
 * Copyright 2019 Google LLC.
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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/bigtable/README.md
 */

// Include Google Cloud dependencies using Composer
require_once __DIR__ . '/../vendor/autoload.php';

if (count($argv) != 4) {
    return printf("Usage: php %s PROJECT_ID INSTANCE_ID TABLE_ID" . PHP_EOL, __FILE__);
}
list($_, $projectId, $instanceId, $tableId) = $argv;

// [START bigtable_create_family_gc_max_versions]

use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest\Modification;
use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\ColumnFamily;
use Google\Cloud\Bigtable\Admin\V2\GcRule;

/** Uncomment and populate these variables in your code */
// $projectId = 'The Google project ID';
// $instanceId = 'The Bigtable instance ID';
// $tableId = 'The Bigtable table ID';

$tableAdminClient = new BigtableTableAdminClient();

$tableName = $tableAdminClient->tableName($projectId, $instanceId, $tableId);


print('Creating column family cf2 with max versions GC rule...' . PHP_EOL);
$columnFamily2 = new ColumnFamily();
$maxVersionRule = (new GcRule)->setMaxNumVersions(2);
$columnFamily2->setGCRule($maxVersionRule);

$columnModification = new Modification();
$columnModification->setId('cf2');
$columnModification->setCreate($columnFamily2);
$tableAdminClient->modifyColumnFamilies($tableName, [$columnModification]);

print('Created column family cf2 with Max Versions GC Rule.' . PHP_EOL);

// [END bigtable_create_family_gc_max_versions]
