<?php
/**
 * Copyright 2018 Google Inc.
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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/firestore/README.md
 */

namespace Google\Cloud\Samples\Firestore;

use Google\Cloud\Firestore\FirestoreClient;

/**
 * Define field start point for a query.
 * ```
 * query_cursor_start_at_field_value_single('your-project-id');
 * ```
 */
function query_cursor_start_at_field_value_single($projectId)
{
    // Create the Cloud Firestore client
    $db = new FirestoreClient([
        'projectId' => $projectId,
    ]);
    $citiesRef = $db->collection('samples/php/cities');
    # [START fs_start_at_field_query_cursor]
    # [START firestore_query_cursor_start_at_field_value_single]
    $query = $citiesRef
        ->orderBy('population')
        ->startAt([1000000]);
    # [END firestore_query_cursor_start_at_field_value_single]
    # [END fs_start_at_field_query_cursor]
    $snapshot = $query->documents();
    foreach ($snapshot as $document) {
        printf('Document %s returned by start at population 1000000 field query cursor.' . PHP_EOL, $document->id());
    }
}

require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
