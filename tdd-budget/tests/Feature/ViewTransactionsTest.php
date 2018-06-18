<?php

namespace Tests\Feature;

use App\Transaction;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewTransactionsTest extends TestCase{
    use DatabaseMigrations;

    /**
     * @test
     * @return void
     */
    public function it_can_display_all_transactions(){
        $transaction = factory(Transaction::class)->create();

        $this->get('/transactions')
            ->assertSee($transaction->description);
    }
}
