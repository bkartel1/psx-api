<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2018 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Api\Tests\Generator;

use Doctrine\Common\Annotations\SimpleAnnotationReader;
use PSX\Api\Generator\Swagger;

/**
 * SwaggerTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SwaggerTest extends GeneratorTestCase
{
    public function testGenerate()
    {
        $reader = new SimpleAnnotationReader();
        $reader->addNamespace('PSX\\Schema\\Parser\\Popo\\Annotation');

        $generator = new Swagger($reader, 1, 'http://api.phpsx.org', 'http://foo.phpsx.org');

        $actual = $generator->generate($this->getResource());
        $expect = file_get_contents(__DIR__ . '/resource/swagger.json');

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testGenerateAll()
    {
        $reader = new SimpleAnnotationReader();
        $reader->addNamespace('PSX\\Schema\\Parser\\Popo\\Annotation');

        $generator = new Swagger($reader, 1, 'http://api.phpsx.org', 'http://foo.phpsx.org');

        $actual = $generator->generateAll($this->getResourceCollection());
        $expect = file_get_contents(__DIR__ . '/resource/swagger_collection.json');

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testGenerateSecurity()
    {
        $reader = new SimpleAnnotationReader();
        $reader->addNamespace('PSX\\Schema\\Parser\\Popo\\Annotation');

        $generator = new Swagger($reader, 1, 'http://api.phpsx.org', 'http://foo.phpsx.org');
        $generator->setAuthorizationFlow('OAuth2', Swagger::FLOW_AUTHORIZATION_CODE, 'http://api.phpsx.org/authorization', 'http://api.phpsx.org/token', ['foo' => 'Foo sope', 'bar' => 'Bar scope']);

        $actual = $generator->generate($this->getSecurityResource());
        $expect = file_get_contents(__DIR__ . '/resource/swagger_security.json');

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }
}
