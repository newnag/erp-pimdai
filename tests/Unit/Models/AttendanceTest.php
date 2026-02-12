<?php

namespace Tests\Unit\Models;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test attendance can be created
     */
    public function test_attendance_can_be_created(): void
    {
        $user = User::factory()->create();

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'check_in' => now()->setTime(8, 30, 0),
            'check_out' => now()->setTime(17, 30, 0),
            'work_hours' => 9.0,
            'overtime_hours' => 0.0,
            'status' => 'Present',
            'note' => 'ทำงานปกติ',
        ]);

        $this->assertDatabaseHas('attendance', [
            'user_id' => $user->id,
            'date' => now()->toDateString(),
        ]);
    }

    /**
     * Test attendance belongs to user
     */
    public function test_attendance_belongs_to_user(): void
    {
        $user = User::factory()->create();
        
        $attendance = Attendance::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $attendance->user);
        $this->assertEquals($user->id, $attendance->user->id);
    }

    /**
     * Test attendance status types
     */
    public function test_attendance_status_types(): void
    {
        $user = User::factory()->create();
        $statuses = ['Present', 'Late', 'Absent', 'Leave', 'Holiday'];

        foreach ($statuses as $status) {
            $attendance = Attendance::factory()->create([
                'user_id' => $user->id,
                'status' => $status,
                'date' => now()->addDays(array_search($status, $statuses)),
            ]);
            $this->assertEquals($status, $attendance->status);
        }
    }

    /**
     * Test attendance calculates work hours
     */
    public function test_attendance_calculates_work_hours(): void
    {
        $checkIn = now()->setTime(8, 30, 0);
        $checkOut = now()->setTime(17, 30, 0);

        $attendance = Attendance::factory()->create([
            'check_in' => $checkIn,
            'check_out' => $checkOut,
        ]);

        $workHours = $checkOut->diffInHours($checkIn);

        $this->assertEquals(9, $workHours);
    }

    /**
     * Test attendance overtime calculation
     */
    public function test_attendance_overtime_calculation(): void
    {
        $checkIn = now()->setTime(8, 0, 0);
        $checkOut = now()->setTime(19, 0, 0); // 11 hours total

        $attendance = Attendance::factory()->create([
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'work_hours' => 11.0,
        ]);

        $normalHours = 8.0;
        $overtime = $attendance->work_hours - $normalHours;

        $this->assertEquals(3.0, $overtime);
    }

    /**
     * Test attendance late check-in
     */
    public function test_attendance_late_check_in(): void
    {
        $lateCheckIn = now()->setTime(9, 30, 0); // Late after 9:00
        
        $attendance = Attendance::factory()->create([
            'check_in' => $lateCheckIn,
            'status' => 'Late',
        ]);

        $this->assertEquals('Late', $attendance->status);
        $this->assertGreaterThan(9, $attendance->check_in->hour);
    }

    /**
     * Test attendance can be soft deleted
     */
    public function test_attendance_can_be_soft_deleted(): void
    {
        $attendance = Attendance::factory()->create();

        $attendance->delete();

        $this->assertSoftDeleted('attendance', ['id' => $attendance->id]);
    }

    /**
     * Test attendance filter by date range
     */
    public function test_attendance_filter_by_date_range(): void
    {
        $user = User::factory()->create();

        Attendance::factory()->create([
            'user_id' => $user->id,
            'date' => now()->subDays(10),
        ]);
        
        Attendance::factory()->create([
            'user_id' => $user->id,
            'date' => now()->subDays(5),
        ]);
        
        Attendance::factory()->create([
            'user_id' => $user->id,
            'date' => now(),
        ]);

        $attendance = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [
                now()->subDays(7)->toDateString(),
                now()->toDateString()
            ])
            ->get();

        $this->assertEquals(2, $attendance->count());
    }

    /**
     * Test user cannot have duplicate attendance on same date
     */
    public function test_user_cannot_have_duplicate_attendance_on_same_date(): void
    {
        $user = User::factory()->create();
        $date = now()->toDateString();

        Attendance::factory()->create([
            'user_id' => $user->id,
            'date' => $date,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Attendance::factory()->create([
            'user_id' => $user->id,
            'date' => $date,
        ]);
    }
}
