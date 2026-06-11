<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

class ProjectQuestionsController extends Controller
{
    public function index()
    {
        $filePath = base_path('docs/project_questions_answers.md');
        abort_unless(is_file($filePath), 404);

        $markdown = file_get_contents($filePath);
        $contentHtml = Str::markdown($markdown, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return view('public.project-questions', [
            'contentHtml' => $contentHtml,
        ]);
    }
}
