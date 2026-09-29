<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabSixTest extends TestCase
{
    use RefreshDatabase;

    public function test_hello_route_returns_the_lab_greeting(): void
    {
        $this->get('/hello')
            ->assertOk()
            ->assertSeeText('Xin chào Laravel 12!');
    }

    public function test_sum_route_adds_integer_values_and_rejects_invalid_values(): void
    {
        $this->get('/sum/7/5')->assertOk()->assertSeeText('12');
        $this->get('/sum/7/nope')->assertBadRequest();
    }

    public function test_student_pages_render_and_filter_by_gender(): void
    {
        Student::factory()->create(['name' => 'Nữ sinh viên', 'gender' => 'female', 'age' => 17]);
        Student::factory()->create(['name' => 'Nam sinh viên', 'gender' => 'male', 'age' => 20]);

        $this->get('/students')->assertOk()->assertSeeText('Tĩnh (Array)');
        $this->get('/students/db?gender=female')
            ->assertOk()
            ->assertSeeText('Nữ sinh viên')
            ->assertDontSeeText('Nam sinh viên')
            ->assertSeeText('Under 18');
        $this->get('/students/combined?source=array')->assertOk()->assertSeeText('Nguồn: Mảng tĩnh');
        $this->get('/about')->assertOk()->assertSeeText('Lịch 7 buổi thực hành');
    }

    public function test_student_creation_validates_persists_and_flashes_success(): void
    {
        $this->from('/students/create')->post('/students', [
            'name' => '',
            'email' => 'not-an-email',
            'age' => 15,
            'gender' => 'other',
        ])->assertSessionHasErrors(['name', 'email', 'age', 'gender']);

        $this->post('/students', [
            'name' => 'Nguyễn Mai',
            'email' => 'mai@example.test',
            'age' => 20,
            'gender' => 'female',
            'class_name' => 'CNTT01',
        ])->assertRedirect('/students/db')->assertSessionHas('success', 'Tạo mới thành công');

        $this->assertDatabaseHas('students', [
            'email' => 'mai@example.test',
            'class_name' => 'CNTT01',
        ]);
    }
}
