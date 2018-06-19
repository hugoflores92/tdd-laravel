<?php

namespace Tests\Feature;

use App\Transaction;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateTransactionsTest extends TestCase{
    use DatabaseMigrations;

    const BASE_URL = '/transactions';

    /**
     * @test
     * @return void
     */
    public function it_can_create_transactions(){
        $transaction = factory(Transaction::class)->make();

        $this->post(self::BASE_URL, $transaction->toArray())
            ->assertRedirect(self::BASE_URL);
        $this->get(self::BASE_URL)
            ->assertSee($transaction->description);
    }

    /**
     * @test
     * @return void
     */
    public function it_cannot_create_transactions_without_a_description(){
        $this->postTransaction(['description' => null])
            ->assertSessionHasErrors('description');
    }

    /**
     * @test
     * @return void
     */
    public function it_cannot_create_transactions_without_a_category(){
        $this->postTransaction(['category_id' => null])
            ->assertSessionHasErrors('category_id');
    }

    /**
     * @test
     * @return void
     */
    public function it_cannot_create_transactions_without_an_amount(){
        $this->postTransaction(['amount' => null])
            ->assertSessionHasErrors('amount');
    }

    /**
     * @test
     * @return void
     */
    public function it_cannot_create_transactions_without_a_valid_amount(){
        $this->postTransaction(['amount' => 'abc'])
            ->assertSessionHasErrors('amount');
    }

    private function postTransaction(array $overrides = []){
        $transaction = factory(Transaction::class)->make($overrides);

        return $this->withExceptionHandling()
            ->post(self::BASE_URL, $transaction->toArray());
    }
}