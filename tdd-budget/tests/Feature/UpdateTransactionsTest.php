<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Transaction;

class UpdateTransactionsTest extends TestCase
{
    use DatabaseMigrations;

    const BASE_URL = '/transactions';

    /**
     * @test
     * @return void
     */
    public function it_can_update_transactions(){
        $transaction = $this->create(Transaction::class);
        $newTransaction = $this->make(Transaction::class);

        $this->put(self::BASE_URL . "/{$transaction->id}", $newTransaction->toArray())
            ->assertRedirect(self::BASE_URL);

        $this->get(self::BASE_URL)
            ->assertSee($newTransaction->description);
    }

    /**
     * @test
     * @return void
     */
    public function it_cannot_update_transactions_without_a_description(){
        $this->putTransaction(['description' => null])
            ->assertSessionHasErrors('description');
    }

    /**
     * @test
     * @return void
     */
    public function it_cannot_update_transactions_without_an_amount(){
        $this->putTransaction(['amount' => null])
            ->assertSessionHasErrors('amount');
    }

    /**
     * @test
     * @return void
     */
    public function it_cannot_update_transactions_without_a_numeric_amount(){
        $this->putTransaction(['amount' => 'abc'])
            ->assertSessionHasErrors('amount');
    }

    /**
     * @test
     * @return void
     */
    public function it_cannot_update_transactions_without_a_category(){
        $this->putTransaction(['category_id' => null])
            ->assertSessionHasErrors('category_id');
    }

    private function putTransaction(array $overrideParams = []){
        $transaction = $this->create(Transaction::class);
        $newTransaction = $this->make(Transaction::class, $overrideParams);

        return $this->withExceptionHandling()
            ->put(self::BASE_URL . "/{$transaction->id}", $newTransaction->toArray());
    }
}
