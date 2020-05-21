<?php

namespace RenokiCo\LaravelHealthchecks\Http\Controllers;

use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RenokiCo\LaravelHealthchecks\Contracts\Healthcheckable;

class HealthcheckController extends Controller implements Healthcheckable
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * The list of healthchecks by name and
     * the closures to run.
     *
     * @var array
     */
    protected $healthchecks = [];

    /**
     * Wether the output should be JSON-encoded
     * with the names of each healthcheck
     * and their tru/false response.
     *
     * @var bool
     */
    protected $withOutput = false;

    /**
     * The HTTP code to send on passing all healthchecks.
     *
     * @var int
     */
    protected $passingHttpCode = 200;

    /**
     * The HTTP code to send on failing one of the healthchecks.
     *
     * @var int
     */
    protected $failingHttpCode = 500;

    /**
     * Add a new closure for the healthchecks.
     *
     * @param  string  $name
     * @param  Closure  $callable
     * @return $this
     */
    public function addHealtcheck(string $name, Closure $callable)
    {
        $this->healthchecks[$name] = $callable;

        return $this;
    }

    /**
     * Enable the output as JSON.
     *
     * @param  bool  $enabled
     * @return $this
     */
    public function withOutput(bool $enabled = true)
    {
        $this->withOutput = true;

        return $this;
    }

    /**
     * Set the passing HTTP code.
     *
     * @param  int  $code
     * @return $this
     */
    public function setPassingHttpCode(int $code)
    {
        $this->passingHttpCode = $code;

        return $this;
    }

    /**
     * Set the failing HTTP code.
     *
     * @param  int  $code
     * @return $this
     */
    public function setFailingHttpCode(int $code)
    {
        $this->failingHttpCode = $code;

        return $this;
    }

    /**
     * Register the healthchecks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function registerHealthchecks(Request $request)
    {
        //
    }

    /**
     * Run all the closures and return false on fail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function runHealthchecks(Request $request): array
    {
        $healthchecks = $this->healthchecks;

        foreach ($healthchecks as $name => &$closure) {
            $hasPassed = call_user_func($closure, $request);

            $closure = $hasPassed;
        }

        return $healthchecks;
    }

    /**
     * Pass an array of name => true/false and check if the
     * healthchecks passed.
     *
     * @param  array  $healthchecks
     * @return bool
     */
    protected function healthchecksHavePassed(array $healthchecks): bool
    {
        foreach ($healthchecks as $name => $hasPassed) {
            if (! $hasPassed) {
                return false;
            }
        }

        return true;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        $this->registerHealthchecks($request);

        $ranHealthchecks = $this->runHealthchecks($request);

        $healthchecksPassed = $this->healthchecksHavePassed($ranHealthchecks);

        $code = $healthchecksPassed ? $this->passingHttpCode : $this->failingHttpCode;
        $message = $healthchecksPassed ? 'OK' : 'FAIL';

        if ($this->withOutput) {
            return response()->json($ranHealthchecks, $code);
        }

        return response($message, $code);
    }
}
