<?php

namespace Tests\Feature;

use App\Transaction;
use App\Category;
use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewTransactionsTest extends TestCase{
    use DatabaseMigrations;

    const BASE_URL = '/transactions';

    /**
     * @test
     * @return void
     */
    public function it_allow_only_authenticated_users(){
        $this->signOut()
            ->withExceptionHandling()
            ->get(self::BASE_URL)
            ->assertRedirect('/login');
    }

    /**
     * @test
     * @return void
     */
    public function it_only_display_transactions_that_belong_to_the_currently_logged_in_user(){
        $otherUser = factory(User::class)->create();
        $transaction = factory(Transaction::class)->create([
            'user_id' => $this->user->id
        ]);
        $otherTransaction = factory(Transaction::class)->create([
            'user_id' => $otherUser->id
        ]);

        $this->get(self::BASE_URL)
            ->assertSee($transaction->description)
            ->assertDontSee($otherTransaction->description);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_display_all_transactions(){
        $transaction = $this->create(Transaction::class);

        $this->get(self::BASE_URL)
            ->assertSee($transaction->description)
            ->assertSee($transaction->category->name);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_filter_transactions_by_category(){
        $category = factory(Category::class)->create();
        $transaction = $this->create(Transaction::class, ['category_id' => $category->id]);
        $otherTransaction = $this->create(Transaction::class);
        
        $targetUrl = self::BASE_URL . "/{$category->slug}";

        $this->get($targetUrl)
            ->assertSee($transaction->description)
            ->assertDontSee($otherTransaction->description);
    }
}
