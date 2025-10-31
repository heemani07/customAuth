<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }


    public function create()
    {
        return view('category.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Category::create([
            'category_name' => $request->category_name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully.');
    }


    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }


    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $category->update($request->only(['category_name', 'description']));

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }
}
