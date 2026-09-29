<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        // Mảng tĩnh (ôn tập PHP mảng)
        $students = [
            ['name' => 'Nguyễn An', 'age' => 19, 'email' => 'an@huit.edu.vn', 'gender' => 'male', 'class_name' => 'CNTT01'],
            ['name' => 'Trần Bình', 'age' => 18, 'email' => 'binh@huit.edu.vn', 'gender' => 'male', 'class_name' => 'CNTT01'],
            ['name' => 'Lê Chi', 'age' => 17, 'email' => 'chi@huit.edu.vn', 'gender' => 'female', 'class_name' => 'CNTT02'],
            ['name' => 'Phạm Dũng', 'age' => 20, 'email' => 'dung@huit.edu.vn', 'gender' => 'male', 'class_name' => 'CNTT02'],
            ['name' => 'Đỗ Em', 'age' => 21, 'email' => 'em@huit.edu.vn', 'gender' => 'female', 'class_name' => 'CNTT03'],
        ];

        return view('students.index', compact('students'));
    }

    public function indexDb(Request $request): View
    {
        $gender = $request->query('gender');
        $query = Student::query()->orderBy('id', 'desc');

        if (in_array($gender, ['male', 'female'], true)) {
            $query->where('gender', $gender);
        } else {
            $gender = '';
        }

        $students = $query->paginate(5)->appends(['gender' => $gender]);

        return view('students.index_db', compact('students', 'gender'));
    }

    public function combine(Request $request): View
    {
        $static = [
            ['name' => 'Nguyễn An', 'age' => 19, 'email' => 'an@huit.edu.vn',
                'gender' => 'male', 'class_name' => 'CNTT01'],
            ['name' => 'Trần Bình', 'age' => 18, 'email' => 'binh@huit.edu.vn',
                'gender' => 'male', 'class_name' => 'CNTT01'],
            ['name' => 'Lê Chi', 'age' => 17, 'email' => 'chi@huit.edu.vn',
                'gender' => 'female', 'class_name' => 'CNTT02'],
        ];
        $db = Student::query()->orderBy('id', 'desc')->paginate(5);

        // Lấy nguồn từ query param ?source=array|db (mặc định db)
        $source = $request->query('source', 'db');
        $source = in_array($source, ['array', 'db'], true) ? $source : 'db';

        return view('students.combined', compact('static', 'db', 'source'));
    }

    public function create(): View
    {
        return view('students.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'age' => ['nullable', 'integer', 'min:16'],
            'gender' => ['required', 'in:male,female'],
            'class_name' => ['nullable', 'string', 'max:255'],
        ]);

        Student::query()->create($validated);

        return redirect()->route('students.db')->with('success', 'Tạo mới thành công');
    }
}
