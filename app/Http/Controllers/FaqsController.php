<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FaqsController extends Controller
{
    /**
     * Display FAQs in a DataTable (AJAX support)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Faq::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-info editFaq"
                            data-id="' . $row->id . '"
                            data-question="' . e($row->question) . '"
                            data-answer="' . e($row->answer) . '">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteFaq"
                            data-id="' . $row->id . '">
                            <i class="bi bi-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('faqs.index');
    }

    /**
     * Store a newly created FAQ.
     */
    public function store(StoreFaqRequest $request)
    {
        Faq::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'FAQ added successfully!'
        ]);
    }

    /**
     * Update an existing FAQ.
     */
    public function update(UpdateFaqRequest $request, Faq $faq)
    {
        $faq->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'FAQ updated successfully!'
        ]);
    }

    /**
     * Delete an FAQ.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->json([
            'success' => true,
            'message' => 'FAQ deleted successfully!'
        ]);
    }
}
