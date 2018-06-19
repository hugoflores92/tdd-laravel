<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Exceptions\Handler;
use Exception;
use App\User;

abstract class TestCase extends BaseTestCase{
    use CreatesApplication;

    /**
     * Laravel's default exception handler
     *
     * @var \Symfony\Component\Debug\ExceptionHandler
     */
    private $oldExceptionHandler;

    protected $user;

    protected function setUp(){
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->signIn($this->user)
            ->disableExceptionHandling();
    }

    private function disableExceptionHandling(){
        $this->oldExceptionHandler = app()->make(ExceptionHandler::class);
        app()->instance(ExceptionHandler::class, new NullHandler);
    }

    protected function withExceptionHandling(){
        app()->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }

    protected function signIn(User $user){
        $this->actingAs($user);
        return $this;
    }

    protected function signOut(){
        $this->post('/logout');
        return $this;
    }

    protected function make(string $class, array $overrides = [], int $times = null){
        return factory($class, $times)
            ->make(array_merge(['user_id' => $this->user->id], $overrides));
    }

    protected function create(string $class, array $overrides = [], int $times = null){
        return factory($class, $times)
            ->create(array_merge(['user_id' => $this->user->id], $overrides));
    }
}

class NullHandler extends Handler{
    public function __construct(){}

    public function report(Exception $e){}

    public function render($request, Exception $e){
        throw $e;
    }
}