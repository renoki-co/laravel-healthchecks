<?php

namespace RenokiCo\LaravelHealthchecks\Test;

use Illuminate\Http\Request;

class ControllerTest extends TestCase
{
    public function test_successful_healthcheck()
    {
        $request = Request::create('/', 'GET');

        $controller = new Http\Controllers\TestSuccessfulController;

        $response = $controller->handle($request);

        $this->assertEquals(
            200,
            $response->getStatusCode()
        );
    }

    public function test_failing_healthcheck()
    {
        $request = Request::create('/', 'GET');

        $controller = new Http\Controllers\TestFailingController;

        $response = $controller->handle($request);

        $this->assertEquals(
            500,
            $response->getStatusCode()
        );
    }

    public function test_healthcheck_output()
    {
        $request = Request::create('/', 'GET');

        $controller = new Http\Controllers\TestOutputController;

        $response = $controller->handle($request);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals(
            500,
            $response->getStatusCode()
        );

        $this->assertEquals([
            'test1' => true,
            'test2' => true,
            'test3' => false,
        ], $content);
    }
}
