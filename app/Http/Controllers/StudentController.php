<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;

    $students = Student::query()
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('mobile', 'like', '%' . $search . '%')
                  ->orWhere('course', 'like', '%' . $search . '%')
                  ->orWhere('class', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%');
            });
        })
        ->latest()
        ->paginate(5);

    $students->getCollection()->transform(function ($student) {
        $student->image_url = $student->image
            ? asset('storage/' . $student->image)
            : null;

        return $student;
    });

    return response()->json([
        'success' => true,
        'data' => $students->items(),
        'current_page' => $students->currentPage(),
        'last_page' => $students->lastPage(),
        'per_page' => $students->perPage(),
        'total' => $students->total(),
    ]);
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'mobile' => 'required|string|max:15',
            'course' => 'required|string|max:255',
            'address' => 'required|string',
            'class' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('students', 'public');
        }
                $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $count = 1;

        while (Student::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $validated['slug'] = $slug;
        $student = Student::create($validated);

        $student->image_url = $student->image
            ? asset('storage/' . $student->image)
            : null;

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    }

    public function show(Student $student)
    {
        $student->image_url = $student->image
            ? asset('storage/' . $student->image)
            : null;

        return response()->json([
            'success' => true,
            'data' => $student
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'mobile' => 'required|string|max:15',
            'course' => 'required|string|max:255',
            'address' => 'required|string',
            'class' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {

            if ($student->image) {
                Storage::disk('public')->delete($student->image);
            }

            $validated['image'] = $request->file('image')->store(
                'students',
                'public'
            );
        }
        $baseSlug = Str::slug($validated['name']);
$slug = $baseSlug;
$count = 1;

while (
    Student::where('slug', $slug)
        ->where('id', '!=', $student->id)
        ->exists()
) {
    $slug = $baseSlug . '-' . $count;
    $count++;
}

$validated['slug'] = $slug;

        $student->update($validated);

        $student->image_url = $student->image
            ? asset('storage/' . $student->image)
            : null;

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully',
            'data' => $student
        ]);
    }

    public function showBySlug(string $slug)
{
    $student = Student::where('slug', $slug)->firstOrFail();

    $student->image_url = $student->image
        ? asset('storage/' . $student->image)
        : null;

    return response()->json([
        'success' => true,
        'data' => $student
    ]);
}

    public function destroy(Student $student)
    {
        if ($student->image) {
            Storage::disk('public')->delete($student->image);
        }

        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully'
        ]);
    }
}