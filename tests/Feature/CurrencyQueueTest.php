<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CurrencyReport;
use Carbon\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Traits\HasAuthenticatedUser;
use App\Models\User;

class CurrencyQueueTest extends TestCase
{
    use HasAuthenticatedUser;
    protected User $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->getUser();
    }

    public function testStoreOneYearOneMonth()
    {
        $this->actingAs($this->user)
            ->postJson('/api/currencies/queue', [
                'report_uid' => "ONE_YEAR_ONE_MONTH",
                'currency' => 'CAD'
            ])
            ->assertCreated();
        $report = CurrencyReport::where('report_uid', '=', "ONE_YEAR_ONE_MONTH")->latest()->first();
        $this->assertCount(13, $report->result);
        $this->assertValidReport($report);
    }

    public function testStoreSixMonthsOneWeek()
    {
        $this
            ->actingAs($this->user)
            ->postJson('/api/currencies/queue', [
                'report_uid' => "SIX_MONTHS_ONE_WEEK",
                'currency' => 'EUR'
            ])
            ->assertCreated();
        $report = CurrencyReport::where('report_uid', '=', "SIX_MONTHS_ONE_WEEK")->latest()->first();
        $this->assertGreaterThanOrEqual(6 * 4, count($report->result));
        $this->assertLessThanOrEqual(6 * 5, count($report->result));
        $this->assertValidReport($report);
    }

    public function testConversionsUnauthorized()
    {
        $this->getJson('/api/currencies/list')
            ->assertUnauthorized();
    }

    public function testStoreUnauthorized()
    {
        $this
            ->postJson('/api/currencies/queue', [
                'report_uid' => "SIX_MONTHS_ONE_WEEK",
                'currency' => 'EUR'
            ])
            ->assertUnauthorized();
    }

    public function testStoreOneMonthOneDay()
    {
        $this->actingAs($this->user)
            ->postJson('/api/currencies/queue', [
                'report_uid' => "ONE_MONTH_ONE_DAY",
                'currency' => 'GBP'
            ])
            ->assertCreated();
        $report = CurrencyReport::where('report_uid', '=', "ONE_MONTH_ONE_DAY")->latest()->first();
        $this->assertGreaterThanOrEqual(28, count($report->result));
        $this->assertLessThanOrEqual(31, count($report->result));
        $this->assertValidReport($report);
    }

    private function assertValidReport(CurrencyReport $report)
    {
        $this->assertIsArray($report->result);
        $this->assertIsFloat($report->result[0]['average']);
    }

    public function testStoreUnprocessable()
    {
        $this->actingAs($this->user)
            ->postJson('/api/currencies/queue', [
                'uid' => "sdfdsf"
            ])
            ->assertUnprocessable();
    }

    public function testShowQueueResult()
    {
        $report = CurrencyReport::latest()->whereNotNull('result')->first();
        $this->actingAs($this->user)
            ->getJson('/api/currencies/queue/result/' . $report->id)
            ->assertOk()->AssertJson(
                fn (AssertableJson $json) => $json->first(
                    fn (AssertableJson $innerJson) =>
                    $innerJson->has('average')
                        ->has('date')
                )
            );
    }

    public function testShowQueueResultUnauthorized()
    {
        $report = CurrencyReport::latest()->whereNotNull('result')->first();
        $this
            ->getJson('/api/currencies/queue/result/' . $report->id)
            ->assertUnauthorized();
    }

    public function testIndexQueue()
    {
        $currencyReport = CurrencyReport::first();
        $this->actingAs($this->user)
            ->getJson('/api/currencies/queue')
            ->assertOk()->AssertJson(
                fn (AssertableJson $json) => $json->first(
                    fn (AssertableJson $iJson) => $iJson->first(
                        fn ($innerJson) => $innerJson->where('id', $currencyReport->id)
                            ->where('reportUid', $currencyReport->report_uid)
                            ->where('currency', $currencyReport->currency)
                            ->where('createdAt', $currencyReport->created_at->toJson())
                            ->has('result')->etc()
                    )->etc()
                )->etc()
            );
    }

    public function testIndexQueueUnauthorized()
    {
        $this
            ->getJson('/api/currencies/queue')
            ->assertUnauthorized();
    }
}
