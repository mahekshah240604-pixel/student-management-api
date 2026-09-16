<?php

namespace App\Console\Commands;

use App\Models\Student;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateStudentSlugs extends Command
{
    protected $signature = 'students:generate-slugs';

    protected $description = 'Generate SEO-friendly slugs for existing students';

    public function handle()
    {
        $students = Student::whereNull('slug')
            ->orWhere('slug', '')
            ->get();

        foreach ($students as $student) {

            $baseSlug = Str::slug($student->name);
            $slug = $baseSlug;
            $count = 1;

            while (Student::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }

            $student->slug = $slug;
            $student->save();

            $this->info(
                "Student {$student->id}: {$slug}"
            );
        }

        $this->info('All student slugs generated successfully.');

        return Command::SUCCESS;
    }
}