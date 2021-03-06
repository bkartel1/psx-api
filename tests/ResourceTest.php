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

namespace PSX\Api\Tests;

use PSX\Api\Resource;
use PSX\Schema\Property;

/**
 * ResourceTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class ResourceTest extends \PHPUnit_Framework_TestCase
{
    public function testResource()
    {
        $resource = new Resource(Resource::STATUS_ACTIVE, '/foo');
        $resource->setTitle('foobar');
        $resource->setDescription('foobar');
        $resource->addPathParameter('foo', Property::getString());
        $resource->addMethod(Resource\Factory::getMethod('GET'));

        $this->assertEquals(Resource::STATUS_ACTIVE, $resource->getStatus());
        $this->assertTrue($resource->isActive());
        $this->assertFalse($resource->isDeprecated());
        $this->assertFalse($resource->isClosed());
        $this->assertEquals('/foo', $resource->getPath());
        $this->assertEquals('foobar', $resource->getTitle());
        $this->assertEquals('foobar', $resource->getDescription());
        $this->assertInstanceOf('PSX\Schema\PropertyInterface', $resource->getPathParameters());
        $this->assertInstanceOf('PSX\Api\Resource\MethodAbstract', $resource->getMethod('GET'));
        $this->assertEquals(['GET' => $resource->getMethod('GET')], $resource->getMethods());
        $this->assertEquals(['GET'], $resource->getAllowedMethods());
        $this->assertTrue($resource->hasMethod('GET'));
        $this->assertFalse($resource->hasMethod('POST'));
        $this->assertTrue($resource->hasPathParameters());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetMethodInvalid()
    {
        $resource = new Resource(Resource::STATUS_ACTIVE, '/foo');
        $resource->getMethod('GET');
    }
}
