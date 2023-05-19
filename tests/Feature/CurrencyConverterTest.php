<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Traits\HasAuthenticatedUser;
use App\Models\User;

class CurrencyConverterTest extends TestCase
{
    use HasAuthenticatedUser;
    protected User $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->getUser();
    }
    /**
     * testList
     *
     * @return void
     */
    public function testList()
    {
        $response = $this->actingAs($this->user)
            ->getJson('/api/currencies/list')
            ->assertOk()
            ->AssertJson(
                fn (AssertableJson $json) =>
                $json->first(
                    fn (AssertableJson $innerJson) =>
                    $innerJson->where('abbreviation', 'AED')
                        ->etc()
                )
            );
        $responseArray = json_decode($response->getContent(), true);
        $this->assertGreaterThan(165, count($responseArray));
    }

    public function testListUnauthorized()
    {
        $this->getJson('/api/currencies/list')
            ->assertUnauthorized();
    }

    /**
     * testList
     *
     * @return void
     */
    public function testConversions()
    {
        $this->actingAs($this->user)
            ->getJson('/api/currencies/conversions')
            ->assertOk()
            ->AssertJson(
                fn (AssertableJson $json) =>
                $json->has('USDGBP')
                    ->etc()
            );
    }

    public function testConversionsUnauthorized()
    {
        $this->getJson('/api/currencies/list')
            ->assertUnauthorized();
    }
}
