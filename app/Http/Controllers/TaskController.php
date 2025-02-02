<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Project $project)
{
    return Inertia::render('Projects/Tasks/Index', [
        'project' => $project,
        'tasks' => $project->tasks()->with('user')->latest()->get()
    ]);
}
}
