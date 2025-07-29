<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FishCatch;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FishCatchController extends Controller
{
    public function store(Request $request)
    {
        // Check if we're in automatic mode (image is provided) or manual mode
        $isAutoMode = $request->hasFile('image') && $request->file('image')->isValid();
        
        $validationRules = [
            // General Information
            'region' => 'required|string|max:255',
            'landing_center' => 'required|string|max:255',
            'date_sampling' => 'required|date',
            'time_landing' => 'required|date_format:H:i',
            'enumerators' => 'required|string|max:255',
            'fishing_ground' => 'required|string|max:255',
            'weather_conditions' => 'required|string|max:255',
            
            // Boat Information
            'boat_name' => 'required|string|max:255',
            'boat_type' => 'required|string|max:255',
            'boat_length' => 'required|numeric|min:0',
            'boat_width' => 'required|numeric|min:0',
            'boat_depth' => 'required|numeric|min:0',
            'gross_tonnage' => 'nullable|numeric|min:0',
            'horsepower' => 'nullable|integer|min:0',
            'engine_type' => 'nullable|string|max:255',
            'fishermen_count' => 'required|integer|min:1',
            
            // Fishing Operation Details
            'fishing_gear_type' => 'required|string|max:255',
            'gear_specifications' => 'nullable|string',
            'hooks_hauls' => 'nullable|integer|min:0',
            'net_line_length' => 'nullable|numeric|min:0',
            'soaking_time' => 'nullable|numeric|min:0',
            'mesh_size' => 'nullable|numeric|min:0',
            'days_fished' => 'required|integer|min:1',
            'fishing_location' => 'nullable|string|max:255',
            'payao_used' => 'nullable|string|max:255',
            'fishing_effort_notes' => 'nullable|string',
            
            // Catch Information
            'catch_type' => 'required|string|max:255',
            'total_catch_kg' => 'required|numeric|min:0',
            'subsample_taken' => 'nullable|string|max:255',
            'subsample_weight' => 'nullable|numeric|min:0',
            'below_legal_size' => 'nullable|string|max:255',
            'below_legal_species' => 'nullable|string|max:255',
            
            // AI Species Recognition & Size Estimation
            'species' => 'required|string|max:255',
            'scientific_name' => 'nullable|string|max:255',
            'length_cm' => 'required|numeric|min:0',
            'weight_g' => 'required|numeric|min:0',
            'confidence_score' => 'nullable|string|max:255',
            'detection_confidence' => 'nullable|string|max:255',
            'bbox_width' => 'nullable|integer|min:0',
            'bbox_height' => 'nullable|integer|min:0',
            'pixels_per_cm' => 'nullable|numeric|min:0',
        ];

        // Add image validation only if in automatic mode
        if ($isAutoMode) {
            $validationRules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:10240'; // 10MB max
        }

        $data = $request->validate($validationRules);

        // Set user ID
        $data['user_id'] = auth()->id();

        // Handle image upload only if in automatic mode
        if ($isAutoMode && $request->hasFile('image')) {
            $imagePath = $request->file('image')->store('catches', 'public');
            $data['image_path'] = $imagePath;
        }

        // Set catch_datetime from date_sampling and time_landing
        $data['catch_datetime'] = $data['date_sampling'] . ' ' . $data['time_landing'];

        // Create the fish catch record
        $fishCatch = FishCatch::create($data);

        return redirect()->route('personnel-dashboard')->with('success', 'Fish catch report submitted successfully!');
    }

    public function predict(Request $request)
    {
        $image = $request->file('image');
        $response = Http::attach(
            'image', file_get_contents($image), $image->getClientOriginalName()
        )->post('http://localhost:5000/predict');

        return $response->json();
    }

    public function index()
    {
        $catches = FishCatch::with('user')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('catches.index', compact('catches'));
    }

    public function show(FishCatch $catch)
    {
        // Ensure user can only view their own catches
        if ($catch->user_id !== auth()->id() && auth()->user()->role !== 'REGIONAL_ADMIN') {
            abort(403);
        }
        
        return view('catches.show', compact('catch'));
    }

    public function generatePdf(FishCatch $catch)
    {
        // Ensure user can only generate PDF for their own catches
        if ($catch->user_id !== auth()->id() && auth()->user()->role !== 'REGIONAL_ADMIN') {
            abort(403);
        }

        // For now, return the PDF view as HTML that can be printed
        return view('catches.pdf', compact('catch'));
    }
}
