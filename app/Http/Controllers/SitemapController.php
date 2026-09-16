<?php

namespace App\Http\Controllers;

use App\Models\Student;

class SitemapController extends Controller
{
    public function index()
    {
        $students = Student::whereNotNull('slug')->get();

        return response()
            ->view('sitemap', compact('students'))
            ->header('Content-Type', 'text/xml');
    }
}