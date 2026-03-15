<?php

namespace Tests\Unit;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_bill_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $bill = Bill::create([
            'user_id' => $user->id,
            'provider' => 'dewa',
            'amount' => 350.00,
            'bill_date' => now(),
        ]);

        $this->assertSame($user->id, $bill->user_id);
        $this->assertTrue($bill->user->is($user));
    }
}
