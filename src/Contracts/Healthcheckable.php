<?php

namespace RenokiCo\LaravelHealthchecks\Contracts;

use Illuminate\Http\Request;

interface Healthcheckable
{
    /**
     * Register the healthchecks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function registerHealthchecks(Request $request);
}
