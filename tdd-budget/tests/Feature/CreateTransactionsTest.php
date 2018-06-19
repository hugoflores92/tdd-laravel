<?php

namespace Tests\Feature;

use App\Transaction;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateTransactionsTest extends TestCase{
    use DatabaseMigrations;

    /**
     * @test
     * @return void
     */
    public function it_can_create_transactions(){
        $transaction = factory(Transaction::class)->make();

        $this->post('/transactions', $transaction->toArray())
            ->assertRedirect('/transactions');
        $this->get('/transactions')
            ->assertSee($transaction->description);
    }
}