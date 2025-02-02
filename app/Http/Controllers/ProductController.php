<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Project;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Project $project)
    {
        return Inertia::render('Projects/Products/Index', [
            'project' => $project->load('products'),
            'products' => $project->products()->latest()->get()
        ]);
    }

    public function create(Project $project)
    {
        return Inertia::render('Projects/Products/Create', [
            'project' => $project
        ]);
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'cost' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product = $project->products()->create($validated);

        return redirect()->route('projects.products.show', [$project, $product]);
    }

    public function show(Project $project, Product $product)
    {
        return Inertia::render('Projects/Products/Show', [
            'project' => $project,
            'product' => $product
        ]);
    }

    public function destroy(Project $project, Product $product)
    {
        // Authorization check
        if ($product->project_id !== $project->id) {
            abort(403);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
