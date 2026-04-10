<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BookingController; 
use App\Http\Controllers\ReviewController;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Owner\MenuController;
use App\Http\Controllers\Owner\GalleryController;
use App\Http\Controllers\Owner\StaffController;
use App\Http\Controllers\RestaurantRegistrationController;

/*
|--------------------------------------------------------------------------
| Public Discovery Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () { 
    $restaurants = Restaurant::all();
    $categoryCounts = $restaurants->mapToGroups(function ($item) {
        return [trim(strtolower($item->category)) => 1];
    })->map->count();

    $stats = [
        'total_spots'  => $restaurants->count(),
        'total_users'  => User::count(),
        'total_orders' => 1240, 
    ];

    $featured = Restaurant::latest()->take(5)->get(); 
    return view('home', compact('stats', 'restaurants', 'featured', 'categoryCounts')); 
})->name('home');

Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', function () { return view('contact'); })->name('contact');
Route::get('/blog', function () { return view('home'); })->name('blog');

Route::get('/restaurants', [RestaurantController::class, 'bertouaGuide'])->name('restaurants.index');
Route::get('/restaurants/all', [RestaurantController::class, 'bertouaGuide'])->name('restaurants');
Route::get('/restaurants/bertoua', [RestaurantController::class, 'bertouaGuide'])->name('restaurants.bertoua'); 
Route::get('/restaurants/{id}/menu', [RestaurantController::class, 'showMenu'])->name('restaurants.menu');

/*
|--------------------------------------------------------------------------
| Authentication & Verification
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegistrationController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/reverify', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('reverify');

/*
|--------------------------------------------------------------------------
| Protected Routes (Requires Auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /**
     * DASHBOARD SYSTEM
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-dashboard', [DashboardController::class, 'index'])->name('dashboard.redirect');
    Route::get('/customer/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');

    // REVIEWS
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/verify-account', [RegistrationController::class, 'showVerifyPage'])->name('verify.page');
    Route::post('/verify-otp', [RegistrationController::class, 'verify'])->name('verify.submit');
    Route::post('/resend-otp', [RegistrationController::class, 'resend'])->name('verify.resend');

    Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::patch('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');

    /* --- 1. SUPER ADMIN SECTION --- */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::patch('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');
        Route::get('/users/{id}/pdf', [AdminController::class, 'downloadUserPdf'])->name('users.pdf');
        
        Route::get('/payouts', [AdminController::class, 'withdrawals'])->name('payouts');
        Route::post('/payouts/{id}/approve', [AdminController::class, 'approveWithdrawal'])->name('payouts.approve');
        Route::get('/messages/count', [AdminController::class, 'getMessageCount'])->name('messages.count');
        Route::post('/messages/reply', [AdminController::class, 'sendReply'])->name('messages.reply');
        Route::patch('/messages/{id}/read', [AdminController::class, 'markAsRead'])->name('messages.read');
        Route::delete('/messages/{id}', [AdminController::class, 'destroyMessage'])->name('messages.destroy');
        Route::post('/users/store', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/export', [AdminController::class, 'exportUsers'])->name('users.export');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy'); 
        Route::post('/restaurants', [AdminController::class, 'storeRestaurant'])->name('restaurants.store');
        Route::put('/restaurants/{id}', [AdminController::class, 'updateRestaurant'])->name('restaurants.update');
        Route::delete('/restaurants/{id}', [AdminController::class, 'destroyRestaurant'])->name('restaurants.destroy');
        Route::get('/table-bookings', [BookingController::class, 'adminIndex'])->name('bookings.index');
        Route::patch('/table-bookings/{id}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');

        // --- UPDATED RESTAURANT APPLICATION ROUTES ---
        Route::get('/applications', [RestaurantRegistrationController::class, 'index'])->name('applications.index');
        Route::post('/restaurants/approve/{id}', [RestaurantRegistrationController::class, 'approve'])->name('restaurants.approve');
        Route::delete('/restaurants/reject/{id}', [RestaurantRegistrationController::class, 'reject'])->name('restaurants.reject');
    });

    /* --- 2. LOGISTICS AGENT SECTION --- */
    Route::prefix('agent')->name('agent.')->group(function () {
        Route::get('/dashboard', function () {
            $user = auth()->user();
            $data = [
                'myMissions' => Order::where('agent_id', $user->id)->latest()->get(),
                'availableQueue' => Order::where('status', 'pending_pickup')->whereNull('agent_id')->latest()->get(),
                'transactions' => Transaction::where('user_id', $user->id)->whereDate('created_at', today())->get(),
            ];
            $orders = $data['myMissions']->merge($data['availableQueue']);
            return view('agent.dashboard', array_merge($data, ['orders' => $orders]));
        })->name('dashboard');

        Route::get('/earnings', [OrderController::class, 'earnings'])->name('earnings');
        Route::post('/withdraw', [OrderController::class, 'withdraw'])->name('withdraw');
        Route::post('/toggle-availability', [OrderController::class, 'toggleAvailability'])->name('toggle_availability');
        Route::post('/orders/{id}/accept', [OrderController::class, 'acceptOrder'])->name('orders.accept');
        Route::post('/orders/{id}/complete', [OrderController::class, 'completeOrder'])->name('orders.complete');
        Route::post('/toggle-status', [OrderController::class, 'toggleAvailability'])->name('toggle-status');
    });

    /* --- 3. OWNER SECTION --- */
    Route::prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', [OwnerController::class, 'index'])->name('dashboard');
        Route::patch('/orders/{id}/status', [OwnerController::class, 'updateOrderStatus'])->name('orders.update-status');
        Route::patch('/profile/update', [OwnerController::class, 'updateProfile'])->name('profile.update');
        Route::patch('/bookings/{id}/status', [OwnerController::class, 'updateBookingStatus'])->name('bookings.update-status');
        Route::delete('/bookings/{id}', [OwnerController::class, 'destroyBooking'])->name('bookings.destroy');
        Route::resource('menus', MenuController::class);
        Route::post('/menu/store', [OwnerController::class, 'storeMenu'])->name('menu.store');
        Route::post('/restaurants/{restaurant}/gallery', [GalleryController::class, 'store'])->name('gallery.store');
        Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
        Route::post('/restaurants/{restaurant}/staff', [StaffController::class, 'store'])->name('staff.store');
        Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
        Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
        Route::post('/owner/orders/{id}/accept', [OwnerController::class, 'acceptOrder'])->name('owner.orders.accept');
        Route::post('/owner/orders/{id}/reject', [OwnerController::class, 'rejectOrder'])->name('owner.orders.reject');
        Route::post('/owner/orders/{id}/assign-agent', [OwnerController::class, 'assignAgent'])->name('owner.orders.assignAgent');
        Route::delete('/owner/menus/{id}', [OwnerController::class, 'destroyMenu'])->name('owner.menus.destroy');
    });

    /* --- 4. CUSTOMER SPECIFIC SECTION --- */
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::patch('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::patch('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
        Route::post('/bookings/{id}/review', [ReviewController::class, 'store'])->name('review.store');
    });

    /* --- 5. GENERAL PROFILE UPDATE --- */
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

}); 

/*
|--------------------------------------------------------------------------
| Additional Exports & Store
|--------------------------------------------------------------------------
*/
Route::get('/admin/restaurants/export/pdf', [RestaurantController::class, 'exportAllPdf'])->name('admin.restaurants.export.pdf');
Route::get('/admin/restaurants/{id}/pdf', [RestaurantController::class, 'downloadPdf'])->name('admin.restaurants.pdf');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/orders/add', [OrderController::class, 'store'])->name('orders.add')->middleware('auth');

Route::get('/checkout', function() { return view('checkout'); })->name('proceed.page');

// --- UPDATED: Using BookingController instead of ReservationController ---
Route::get('/reserve', [BookingController::class, 'index'])->name('bookings.index');

Route::get('/restaurants/{identifier}', [RestaurantController::class, 'showMenu'])->name('restaurants.show');

/* --- RESTAURANT REGISTRATION (GUEST/AUTH) --- */
Route::get('/register/restaurant', [RestaurantRegistrationController::class, 'create'])->name('register.restaurant');
Route::post('/register/restaurant/submit', [RestaurantRegistrationController::class, 'store'])->name('register.restaurant.store');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');