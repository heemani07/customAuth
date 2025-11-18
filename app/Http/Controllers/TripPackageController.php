<?php

namespace App\Http\Controllers;

use App\Models\TripPackage;
use App\Models\TripPackageImage;
use App\Models\Destination;
use App\Models\Category;
use App\Http\Requests\TripPackageRequest;
use Illuminate\Support\Facades\Storage;

class TripPackageController extends Controller
{
    public function index()
    {
        $packages = TripPackage::with(['destination', 'category'])->latest()->paginate(10);
        return view('trip-packages.index', compact('packages'));
    }

    public function create()
    {
        $destinations = Destination::all();
        $categories = Category::all();
        return view('trip-packages.create', compact('destinations', 'categories'));
    }

    public function store(TripPackageRequest $request)
    {
        $package = TripPackage::create([
            'destination_id' => $request->destination_id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'overview' => $request->overview,
            'terms_and_conditions' => $request->terms_and_conditions,
            'itinerary' => $request->itinerary,
            'status' => $request->status ?? 'active',
            'inclusions' => $request->filled('inclusions')
                ? $request->inclusions
                : [],
        ]);


        if ($request->has('uploaded_images')) {
            foreach ($request->uploaded_images as $tempFile) {
                $tempPath = "trip-packages-temp/{$tempFile}";
                $newPath = "trip-packages/{$tempFile}";

                if (Storage::disk('public')->exists($tempPath)) {
                    Storage::disk('public')->move($tempPath, $newPath);

                    TripPackageImage::create([
                        'trip_package_id' => $package->id,
                        'image' => $newPath,
                    ]);
                }
            }
        }

        return redirect()->route('trip-packages.index')->with('success', 'Trip Package created successfully!');
    }

    public function edit(TripPackage $tripPackage)
    {
        $destinations = Destination::all();
        $categories = Category::all();
        $tripPackage->load('images');
        return view('trip-packages.edit', compact('tripPackage', 'destinations', 'categories'));
    }

    public function update(TripPackageRequest $request, TripPackage $tripPackage)
    {
        $tripPackage->update([
            'destination_id' => $request->destination_id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'overview' => $request->overview,
            'terms_and_conditions' => $request->terms_and_conditions,
            'itinerary' => $request->itinerary,
            'status' => $request->status ?? 'active',
            'inclusions' => $request->filled('inclusions')
                ? $request->inclusions
                : [],
        ]);


        if ($request->has('uploaded_images')) {
            foreach ($request->uploaded_images as $tempFile) {
                $tempPath = "trip-packages-temp/{$tempFile}";
                $newPath = "trip-packages/{$tempFile}";

                if (Storage::disk('public')->exists($tempPath)) {
                    Storage::disk('public')->move($tempPath, $newPath);

                    TripPackageImage::create([
                        'trip_package_id' => $tripPackage->id,
                        'image' => $newPath,
                    ]);
                }
            }
        }

        return redirect()->route('trip-packages.index')->with('success', 'Trip Package updated successfully!');
    }

    public function destroy(TripPackage $tripPackage)
    {
        foreach ($tripPackage->images as $image) {
            if (Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
            $image->delete();
        }

        $tripPackage->delete();

        return redirect()->route('trip-packages.index')->with('success', 'Trip Package deleted successfully!');
    }

    public function destroyImage($id)
    {
        $image = TripPackageImage::findOrFail($id);
        if (Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }
        $image->delete();
        return back()->with('success', 'Image deleted successfully!');
    }

    public function uploadImage(\Illuminate\Http\Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('trip-packages-temp', 'public');
            return response()->json([
                'success' => true,
                'filename' => basename($path)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded']);
    }

    // Show packages for a destination
public function listByDestination($destinationId)
{
    $destination = Destination::findOrFail($destinationId);

    $packages = TripPackage::where('destination_id', $destinationId)
        ->with('images')
        ->get();

    return view('frontend.packages.index', compact('packages', 'destination'));
}



// Show single package
public function showPackage($id)
{
    $package = TripPackage::with(['images', 'destination', 'category'])
        ->findOrFail($id);

    return view('frontend.packages.show', compact('package'));
}

}
