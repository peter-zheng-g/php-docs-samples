<?php

/**
 * Copyright 2015 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Silex\WebTestCase;

class mailgunTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../src/app.php';

        // set some parameters for testing
        $app['session.test'] = true;
        $app['debug'] = true;
        $projectId = getenv('GOOGLE_PROJECT_ID');

        // set your Mailgun domain name and API key
        $mailgunDomain = getenv('MAILGUN_DOMAIN');
        $mailgunApiKey = getenv('MAILGUN_APIKEY');

        if (empty($projectId) || empty($mailgunDomain) || empty($mailgunApiKey)) {
            $this->markTestSkipped('set the GOOGLE_PROJECT_ID, MAILGUN_DOMAIN and MAILGUN_APIKEY environment variables');
        }

        $app['project_id'] = $projectId;
        $app['mailgun.domain'] = $mailgunDomain;
        $app['mailgun.api_key'] = $mailgunApiKey;

        // prevent HTML error exceptions
        unset($app['exception_handler']);

        return $app;
    }

    public function testHome()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testSimpleEmail()
    {
        $client = $this->createClient();

        $crawler = $client->request('POST', '/', [
            'recipient' => 'fake@example.com',
            'submit' => 'Send simple email',
        ]);

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Mail sent', $response->getContent());
    }

    public function testComplexEmail()
    {
        $client = $this->createClient();

        $crawler = $client->request('POST', '/', [
            'recipient' => 'fake@example.com',
            'submit' => 'Send complex email',
        ]);

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Mail sent', $response->getContent());
    }
}
