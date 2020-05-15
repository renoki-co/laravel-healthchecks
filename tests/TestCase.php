<?php

namespace RenokiCo\LaravelHealthchecks\Test;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Set up the tests.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Get the package providers.
     *
     * @param  mixed  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            //
        ];
    }

    /**
     * Set up the environment.
     *
     * @param  mixed  $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        //
    }
}
