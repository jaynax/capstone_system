<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\FishCatchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Registration form
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Registration handler
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        'role' => 'required|in:BFAR_PERSONNEL,REGIONAL_ADMIN',
    ]);
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);
    Auth::login($user);
    return redirect('/dashboard');
});

// Login form
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Login handler
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    $user = User::where('email', $request->email)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Invalid credentials')->withInput();
    }
    Auth::login($user);
    return redirect('/dashboard');
});

// Dashboard redirection based on role
Route::middleware('auth')->get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'BFAR_PERSONNEL') {
        return redirect('/dashboard/personnel');
    } elseif ($user->role === 'REGIONAL_ADMIN') {
        return redirect('/dashboard/admin');
    }
    abort(403);
});

// BFAR Personnel dashboard
Route::middleware(['auth', 'role:BFAR_PERSONNEL'])->get('/dashboard/personnel', function () {
    return view('personnel-dashboard');
})->name('personnel-dashboard');

// Regional Office Admin dashboard
Route::middleware(['auth', 'role:REGIONAL_ADMIN'])->get('/dashboard/admin', function () {
    return view('admin-dashboard');
})->name('admin-dashboard');

// Admin routes for managing data and users
Route::middleware(['auth', 'role:REGIONAL_ADMIN'])->group(function () {
    Route::get('/admin/catches', function () {
        $catches = \App\Models\FishCatch::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.catches', compact('catches'));
    })->name('admin.catches');
    
    Route::get('/admin/users', function () {
        $users = \App\Models\User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users', compact('users'));
    })->name('admin.users');
    
    Route::get('/admin/reports', function () {
        $totalCatches = \App\Models\FishCatch::count();
        $totalUsers = \App\Models\User::count();
        $recentCatches = \App\Models\FishCatch::with('user')->latest()->take(10)->get();
        return view('admin.reports', compact('totalCatches', 'totalUsers', 'recentCatches'));
    })->name('admin.reports');
});

// Profile edit form
Route::middleware('auth')->get('/profile/edit', function () {
    return view('layouts.users.profile');
})->name('profile.edit');

// Profile update handler
Route::middleware('auth')->put('/profile/update', function (Request $request) {
    $user = Auth::user();
    $request->validate([
        'name' => 'required',
        'address' => 'nullable|string',
        'phone' => 'nullable|string',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    $user->name = $request->name;
    $user->address = $request->address;
    $user->phone = $request->phone;
    if ($request->hasFile('profile_image')) {
        $image = $request->file('profile_image');
        $imageName = time().'_'.$image->getClientOriginalName();
        $image->storeAs('public/profile_images', $imageName);
        $user->profile_image = $imageName;
    }
    $user->save();
    return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
})->name('profile.update');

// Login history route (placeholder)
Route::middleware('auth')->get('/login-history', function () {
    // You can replace this with a real view or controller later
    return view('layouts.users.login-history');
})->name('login.history');

// Fish catch entry form
Route::middleware('auth')->get('/catch/create', function () {
    return view('catch.create');
})->name('catch.create');

// Store fish catch
Route::middleware('auth')->post('/catch/store', [FishCatchController::class, 'store'])->name('catch.store');

// View catches
Route::middleware('auth')->get('/catches', [FishCatchController::class, 'index'])->name('catches.index');
Route::middleware('auth')->get('/catches/{catch}', [FishCatchController::class, 'show'])->name('catches.show');
Route::middleware('auth')->get('/catches/{catch}/pdf', [FishCatchController::class, 'generatePdf'])->name('catches.pdf');

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::post('/predict', [FishCatchController::class, 'predict'])->name('predict');

// Test route to verify database structure
Route::get('/test-db', function() {
    $catch = new \App\Models\FishCatch();
    $fillable = $catch->getFillable();
    echo "Fillable fields: " . implode(', ', $fillable) . "\n";
    
    // Test database connection
    try {
        \DB::connection()->getPdo();
        echo "Database connection: OK\n";
        
        // Check if catches table exists
        $columns = \DB::select('SHOW COLUMNS FROM catches');
        echo "Database columns: " . count($columns) . " columns found\n";
        
        return "Database test completed successfully!";
    } catch (\Exception $e) {
        return "Database error: " . $e->getMessage();
    }
});
