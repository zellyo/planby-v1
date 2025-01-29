<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', auth()->id())->get();
        return Inertia::render('Projects/Index', ['projects' => $projects]);
    }

    // Create (Form)
    public function create()
    {
        return Inertia::render('Projects/Create');
    }

    // Store (Save Project)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('dashboard'); // Redirect to main dashboard
    }

    // Show (Project Dashboard)
    public function show(Project $project)
    {
        return Inertia::render('Projects/Show', [
            'project' => $project,
        ]);
    }
    // Edit (Form)
    public function edit(Project $project)
    {
        return Inertia::render('Projects/Edit', ['project' => $project]);
    }

    // Update
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($request->all());
        return redirect()->route('projects.index');
    }

    // Delete
    public function destroy(Project $project)
    {
        // Authorization check
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }
        $project->delete();
        return redirect()->route('projects.index');
    }
}
