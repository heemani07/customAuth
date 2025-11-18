<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TripPackage;
use App\Models\Destination;

use App\Http\Requests\StoreDestinationRequest;

class DestinationController extends Controller
{
    /**
     * Show the destination form
     */
    public function index()
{
    $destinations = Destination::with('categories')->latest()->get();
    return view('destination.index', compact('destinations'));
}


    public function create()
    {
        $categories = Category::all(); // Fetch all categories for dropdown
        return view('destination.create', compact('categories'));
    }

    /**
     * Store a new destination
     */
    public function store(StoreDestinationRequest $request)
    {

       // $validated = $request->validated();
   //   dd($request->hasFile('image'));
        // Handle image upload if present
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('destinations', 'public');
        }
     // dd($imagePath);
        // Create the destination record
        $destination = Destination::create([
            'name' => $request->name,
        'description' => $request->description,
        'image' => $imagePath,
        'status' => $request->status,]);

        // Attach selected categories (if any)
        if (!empty($request->categories)) {
            $destination->categories()->attach($request->categories);
        }

        // Redirect with success message
        return redirect()->route('destinations.index')
            ->with('success', 'Destination created successfully!');
    }

    public function edit($id)
{
    $destination = Destination::with('categories')->findOrFail($id);
    $categories = Category::all();
    return view('destination.edit', compact('destination', 'categories'));
}

public function update(StoreDestinationRequest $request, $id)
{
    $destination = Destination::findOrFail($id);

    $imagePath = $destination->image;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('destinations', 'public');
    }

    $destination->update([
        'name' => $request->name,
        'description' => $request->description,
        'image' => $imagePath,
        'status' => $request->status,
    ]);

    // Sync categories (update pivot table)
    $destination->categories()->sync($request->categories);

    return redirect()->route('destinations.index')->with('success', 'Destination updated successfully!');
}

public function destroy(Destination $destination)
{
    // Delete image from storage if exists
    if ($destination->image && \Storage::disk('public')->exists($destination->image)) {
        \Storage::disk('public')->delete($destination->image);
    }

    // Detach categories (pivot table cleanup)
    $destination->categories()->detach();

    // Delete the destination
    $destination->delete();

    return redirect()->route('destinations.index')->with('success', 'Destination deleted successfully!');
}
public function packages($id)
{
    $destination = Destination::findOrFail($id);

    // Fetch packages for this destination
    $packages = TripPackage::where('destination_id', $id)->get();

    return view('trip-packages.destination-packages', compact('destination', 'packages'));
}



}
