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
namespace Google\Cloud\Samples\Iot;

# [START iot_create_rsa_device]
use Google\Cloud\Iot\V1\DeviceManagerClient;
use Google\Cloud\Iot\V1\Device;
use Google\Cloud\Iot\V1\DeviceCredential;
use Google\Cloud\Iot\V1\PublicKeyCredential;
use Google\Cloud\Iot\V1\PublicKeyFormat;

/**
 * Create a new device with the given id, using RS256 for
 * authentication.
 *
 * @param string $registryId IOT Device Registry ID
 * @param string $deviceId IOT Device ID
 * @param string $certificateFile Path to RS256 certificate file.
 * @param string $projectId (optional) Google Cloud project ID
 * @param string $location (Optional) Google Cloud region
 */
function create_rsa_device(
    $registryId,
    $deviceId,
    $certificateFile,
    $projectId,
    $location = 'us-central1'
) {
    print('Creating new RS256 Device' . PHP_EOL);

    // Instantiate a client.
    $deviceManager = new DeviceManagerClient();
    $registryName = $deviceManager->registryName($projectId, $location, $registryId);

    $publicKey = (new PublicKeyCredential())
        ->setFormat(PublicKeyFormat::RSA_X509_PEM)
        ->setKey(file_get_contents($certificateFile));

    $credential = (new DeviceCredential())
        ->setPublicKey($publicKey);

    $device = (new Device())
        ->setId($deviceId)
        ->setCredentials([$credential]);

    $device = $deviceManager->createDevice($registryName, $device);

    printf('Device: %s : %s' . PHP_EOL,
        $device->getNumId(),
        $device->getId());
}
# [END iot_create_rsa_device]

require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
