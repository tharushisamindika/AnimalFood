<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Carbon;

class AuditLogCleanupTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user
        $this->admin = User::factory()->create([
            'role' => 'administrator'
        ]);
    }

    /** @test */
    public function it_can_get_cleanup_estimate()
    {
        // Create some old audit logs
        AuditLog::factory()->count(5)->create([
            'created_at' => Carbon::now()->subDays(200)
        ]);

        // Create some recent audit logs
        AuditLog::factory()->count(3)->create([
            'created_at' => Carbon::now()->subDays(10)
        ]);

        $response = $this->actingAs($this->admin)
            ->getJson('/admin/audit-logs/cleanup-estimate?days=180');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'estimated_count' => 5,
                'days' => 180
            ]);
    }

    /** @test */
    public function it_validates_days_parameter_for_estimate()
    {
        $response = $this->actingAs($this->admin)
            ->getJson('/admin/audit-logs/cleanup-estimate?days=10');

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid number of days. Must be between 30 and 3650 days.'
            ]);
    }

    /** @test */
    public function it_can_cleanup_old_audit_logs()
    {
        // Create some old audit logs
        AuditLog::factory()->count(5)->create([
            'created_at' => Carbon::now()->subDays(200)
        ]);

        // Create some recent audit logs
        AuditLog::factory()->count(3)->create([
            'created_at' => Carbon::now()->subDays(10)
        ]);

        $response = $this->actingAs($this->admin)
            ->postJson('/admin/audit-logs/cleanup', [
                'days' => 180
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'deleted_count' => 5
            ]);

        // Verify only old logs were deleted
        $this->assertEquals(3, AuditLog::count());
    }

    /** @test */
    public function it_validates_days_parameter_for_cleanup()
    {
        $response = $this->actingAs($this->admin)
            ->postJson('/admin/audit-logs/cleanup', [
                'days' => 10
            ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid number of days. Must be between 30 and 3650 days.'
            ]);
    }

    /** @test */
    public function it_requires_days_parameter()
    {
        $response = $this->actingAs($this->admin)
            ->postJson('/admin/audit-logs/cleanup', []);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Number of days is required.'
            ]);
    }

    /** @test */
    public function it_returns_success_when_no_logs_to_delete()
    {
        // Create only recent audit logs
        AuditLog::factory()->count(3)->create([
            'created_at' => Carbon::now()->subDays(10)
        ]);

        $response = $this->actingAs($this->admin)
            ->postJson('/admin/audit-logs/cleanup', [
                'days' => 180
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'deleted_count' => 0
            ]);

        // Verify no logs were deleted
        $this->assertEquals(3, AuditLog::count());
    }
}
