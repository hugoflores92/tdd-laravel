<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Transaction;

class DeleteTransactionsTest extends TestCase{
    use DatabaseMigrations;

    const BASE_URL = '/transactions';

    /**
     * @test
     * @return void
     */
    public function it_can_delete_transactions(){
        $transaction = $this->create(Transaction::class);

        $this->delete(self::BASE_URL . "/{$transaction->id}")
            ->assertRedirect(self::BASE_URL);

        $this->get(self::BASE_URL)
            ->assertDontSee($transaction->description);
    }
}
