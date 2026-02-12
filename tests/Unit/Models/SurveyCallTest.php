<?php

namespace Tests\Unit\Models;

use App\Models\Customer;
use App\Models\SurveyCall;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SurveyCallTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test survey call can be created
     */
    public function test_survey_call_can_be_created(): void
    {
        $customer = Customer::factory()->create();
        $user = User::factory()->create();

        $survey = SurveyCall::create([
            'survey_no' => 'SV-2026-001',
            'survey_date' => now(),
            'customer_id' => $customer->id,
            'customer_name' => $customer->customer_name,
            'contact_person' => 'นายลูกค้า ทดสอบ',
            'phone' => '0812345678',
            'satisfaction_score' => 5,
            'product_quality_score' => 5,
            'service_quality_score' => 4,
            'delivery_score' => 5,
            'price_score' => 4,
            'overall_feedback' => 'พอใจมากในคุณภาพสินค้าและบริการ',
            'suggestion' => 'หวังว่าจะมีโปรโมชั่นบ่อยๆ',
            'will_recommend' => true,
            'status' => 'Completed',
            'surveyed_by' => $user->id,
        ]);

        $this->assertDatabaseHas('survey_calls', [
            'survey_no' => 'SV-2026-001',
            'customer_id' => $customer->id,
        ]);
    }

    /**
     * Test survey call belongs to customer
     */
    public function test_survey_call_belongs_to_customer(): void
    {
        $customer = Customer::factory()->create();
        
        $survey = SurveyCall::factory()->create([
            'customer_id' => $customer->id,
        ]);

        $this->assertInstanceOf(Customer::class, $survey->customer);
        $this->assertEquals($customer->id, $survey->customer->id);
    }

    /**
     * Test survey call number is unique
     */
    public function test_survey_call_number_must_be_unique(): void
    {
        SurveyCall::factory()->create(['survey_no' => 'SV-2026-001']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        SurveyCall::factory()->create(['survey_no' => 'SV-2026-001']);
    }

    /**
     * Test survey call satisfaction scores validation
     */
    public function test_survey_call_satisfaction_scores_validation(): void
    {
        $survey = SurveyCall::factory()->create([
            'satisfaction_score' => 5,
            'product_quality_score' => 4,
            'service_quality_score' => 5,
            'delivery_score' => 4,
            'price_score' => 3,
        ]);

        $this->assertGreaterThanOrEqual(1, $survey->satisfaction_score);
        $this->assertLessThanOrEqual(5, $survey->satisfaction_score);
    }

    /**
     * Test survey call calculates average score
     */
    public function test_survey_call_calculates_average_score(): void
    {
        $survey = SurveyCall::factory()->create([
            'product_quality_score' => 5,
            'service_quality_score' => 4,
            'delivery_score' => 5,
            'price_score' => 4,
        ]);

        $averageScore = (
            $survey->product_quality_score +
            $survey->service_quality_score +
            $survey->delivery_score +
            $survey->price_score
        ) / 4;

        $this->assertEquals(4.5, $averageScore);
    }

    /**
     * Test survey call status types
     */
    public function test_survey_call_status_types(): void
    {
        $statuses = ['Scheduled', 'In Progress', 'Completed', 'Cancelled'];

        foreach ($statuses as $status) {
            $survey = SurveyCall::factory()->create(['status' => $status]);
            $this->assertEquals($status, $survey->status);
        }
    }

    /**
     * Test survey call belongs to surveyor
     */
    public function test_survey_call_belongs_to_surveyor(): void
    {
        $user = User::factory()->create();
        
        $survey = SurveyCall::factory()->create([
            'surveyed_by' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $survey->surveyor);
        $this->assertEquals($user->id, $survey->surveyor->id);
    }

    /**
     * Test survey call can be soft deleted
     */
    public function test_survey_call_can_be_soft_deleted(): void
    {
        $survey = SurveyCall::factory()->create();

        $survey->delete();

        $this->assertSoftDeleted('survey_calls', ['id' => $survey->id]);
    }

    /**
     * Test high satisfaction surveys
     */
    public function test_high_satisfaction_surveys(): void
    {
        SurveyCall::factory()->create(['satisfaction_score' => 5]);
        SurveyCall::factory()->create(['satisfaction_score' => 4]);
        SurveyCall::factory()->create(['satisfaction_score' => 2]);

        $highSatisfaction = SurveyCall::where('satisfaction_score', '>=', 4)->get();

        $this->assertEquals(2, $highSatisfaction->count());
    }
}
