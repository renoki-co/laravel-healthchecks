<?php

namespace RenokiCo\LaravelHealthchecks\Test\Http\Controllers;

use Illuminate\Http\Request;
use RenokiCo\LaravelHealthchecks\Http\Controllers\HealthcheckController;

class TestSuccessfulController extends HealthcheckController
{
    public function registerHealthchecks(Request $request)
    {
        $this->addHealthcheck('test1', function (Request $request) {
            return true;
        });

        $this->addHealthcheck('test2', function (Request $request) {
            return true;
        });

        $this->addHealthcheck('test3', function (Request $request) {
            return true;
        });
    }
}
