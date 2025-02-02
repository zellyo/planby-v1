<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Order;
use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Project $project)
    {
        return Inertia::render('Projects/Orders/Index', [
            'project' => $project->load('orders'),
            'orders' => $project->orders()->latest()->get()
        ]);
    }

    public function create(Project $project)
    {
        return Inertia::render('Projects/Orders/Create', [
            'project' => $project->load('products'),
            'products' => $project->products
        ]);
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'order_number' => 'required|unique:orders',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'shipping_amount' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0'
        ]);

        $order = $project->orders()->create($validated);

        return redirect()->route('projects.orders.show', [$project, $order]);
    }

    public function show(Project $project, Order $order)
    {
        // Load product details for the order
        $productIds = collect($order->products)->pluck('id');

        $order->products = Product::whereIn('id', $productIds)
            ->get()
            ->map(function ($product) use ($order) {
                return [
                    'product' => $product,
                    'quantity' => collect($order->products)
                        ->firstWhere('id', $product->id)['quantity']
                ];
            });

        return Inertia::render('Projects/Orders/Show', [
            'project' => $project,
            'order' => $order
        ]);
    }
}
