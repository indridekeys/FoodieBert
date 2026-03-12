<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 

class RestaurantController extends Controller
{
    /**
     * Display the admin dashboard list (Registry)
     */
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('admin.dashboard', compact('restaurants'));
    }

    /**
     * Display the high-end Bertoua city guide (Public Page)
     */
    public function bertouaGuide()
    {
        $restaurants = Restaurant::all(); 
        return view('restaurants', compact('restaurants'));
    }

    /**
     * Display the single restaurant "Details" / Menu page
     * Updated to find by ID or Slug for the Picker redirection
     */
   public function showMenu($identifier)
{
    // Try to find by slug first, only if the identifier isn't numeric
    // This prevents PGSQL from complaining about type mismatches
    $query = \App\Models\Restaurant::query();

    if (is_numeric($identifier)) {
        $restaurant = $query->where('id', $identifier)->firstOrFail();
    } else {
        $restaurant = $query->where('slug', $identifier)->firstOrFail();
    }

    $menuByCategory = [
        'Chef Specials' => [],
        'Main Courses' => [],
        'Drinks' => []
    ];

    return view('menu', compact('restaurant', 'menuByCategory'));
}

    /**
     * Download a single restaurant record as PDF
     */
    public function downloadPdf($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        
        $pdf = Pdf::loadView('admin.pdf.single_restaurant', compact('restaurant'));
        
        return $pdf->download(str_replace(' ', '_', $restaurant->name) . '_Profile.pdf');
    }

    /**
     * Download the entire registry as a landscape PDF
     */
    public function exportAllPdf()
    {
        $restaurants = Restaurant::all();
        
        $pdf = Pdf::loadView('admin.pdf.all_restaurants', compact('restaurants'))
                  ->setPaper('a4', 'landscape'); 
                  
        return $pdf->download('Restaurant_Registry_' . date('Y-m-d') . '.pdf');
    }
}