<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Http\Requests\FaqRequest;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    /**
     * Display all FAQs
     */
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('faqs.index', compact('faqs'));
    }

    /**
     * Store a newly created FAQ
     */
    public function store(FaqRequest $request)
    {
        try {
            Faq::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'FAQ added successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified FAQ
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        try {
            $faq->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'FAQ updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed. Please try again.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified FAQ
     */
    public function destroy(Faq $faq)
    {
        try {
            $faq->delete();

            return response()->json([
                'success' => true,
                'message' => 'FAQ deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete FAQ. Please try again.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
