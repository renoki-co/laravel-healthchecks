<?php

namespace RenokiCo\LaravelHealthchecks\Test\Http\Controllers;

use Illuminate\Http\Request;
use RenokiCo\LaravelHealthchecks\Http\Controllers\HealthcheckController;

class TestSuccessfulController extends HealthcheckController
{
    public function registerHealthchecks(Request $request)
    {
        $this->addHealtcheck('test1', function (Request $request) {
            return true;
        });

        $this->addHealtcheck('test2', function (Request $request) {
            return true;
        });

        $this->addHealtcheck('test3', function (Request $request) {
            return true;
        });
    }
}
