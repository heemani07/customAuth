<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Testimonial;

class HomeController extends Controller
{
    /**
     * Only protect internal dashboard, not the landing page.
     */
    public function __construct()
    {
        // Apply 'auth' middleware only to index (dashboard), not landing page
        $this->middleware('auth')->only('index');
    }

    /**
     * Show the authenticated user's dashboard (after login)
     */
    public function index()
    {
        return view('dashboard'); // use dashboard.blade.php if available
          $testimonials = Testimonial::latest()->get();

    return view('landing.index', compact('testimonials'));
    }

    /**
     * Show the public landing page for the travel site
     */
public function showLanding()
    {
        $destinations = Destination::latest()->take(6)->get();
        $testimonials = Testimonial::latest()->get();

        return view('landing', compact('destinations', 'testimonials'));
    }





}
