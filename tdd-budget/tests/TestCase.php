<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Exceptions\Handler;
use Exception;

abstract class TestCase extends BaseTestCase{
    use CreatesApplication;

    /**
     * Laravel's default exception handler
     *
     * @var \Symfony\Component\Debug\ExceptionHandler
     */
    private $oldExceptionHandler;

    protected function setUp(){
        parent::setUp();
        $this->disableExceptionHandling();
    }

    private function disableExceptionHandling(){
        $this->oldExceptionHandler = app()->make(ExceptionHandler::class);
        app()->instance(ExceptionHandler::class, new NullHandler);
    }

    protected function withExceptionHandling(){
        app()->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }
}

class NullHandler extends Handler{
    public function __construct(){}

    public function report(Exception $e){}

    public function render($request, Exception $e){
        throw $e;
    }
}