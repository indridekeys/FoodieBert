@include('components.header')

<style>
    .reg-section { background: #0a192f; color: white; padding: 100px 0; min-height: 100vh; font-family: 'Plus Jakarta Sans', sans-serif; }
    .reg-card { max-width: 650px; margin: 0 auto; background: rgba(255,255,255,0.03); padding: 40px; border: 1px solid #C5A059; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
    .form-label { color: #C5A059; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; display: block; margin-bottom: 8px; }
    .form-control { width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); padding: 12px; color: white; border-radius: 6px; margin-bottom: 5px; outline: none; transition: 0.3s; }
    .form-control:focus { border-color: #C5A059; background: rgba(255,255,255,0.08); }
    .error-msg { color: #ff4d4d; font-size: 0.75rem; margin-bottom: 15px; display: block; }
    .btn-submit { background: #C5A059; color: white; width: 100%; padding: 15px; border: none; font-weight: 800; cursor: pointer; border-radius: 6px; transition: 0.3s; margin-top: 10px; text-transform: uppercase; letter-spacing: 1px; }
    .btn-submit:hover { background: #fff; color: #0a192f; transform: translateY(-2px); }
    
    /* Enhanced Success Message */
    .success-msg { background: #1a2e23; color: #4ade80; padding: 20px; border-radius: 8px; margin-bottom: 25px; text-align: center; border: 1px solid #22543d; border-left: 5px solid #4ade80; }
    .success-msg i { font-size: 1.5rem; margin-bottom: 10px; display: block; }
    .success-msg strong { display: block; margin-bottom: 5px; color: white; }
</style>

<section class="reg-section">
    <div class="reg-card">
        <h2 style="font-family: 'Playfair Display'; font-size: 2.2rem; text-align: center; margin-bottom: 10px;">Establishment Application</h2>
        <p style="text-align: center; color: #a0aec0; margin-bottom: 40px;">Submit your details. Your restaurant will be registered once approved.</p>

        {{-- Success Message with Gmail Verification Notice --}}
        @if(session('success'))
            <div class="success-msg">
                <i class="fas fa-envelope-open-text"></i>
                <strong>Application Sent Successfully!</strong>
                <p style="margin: 0; font-size: 0.9rem;">Please <b>check your Gmail</b> for updates regarding your matriculation and dashboard access.</p>
            </div>
        @endif

        {{-- Added enctype for image uploads --}}
        <form action="{{ route('register.restaurant.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label class="form-label">Establishment Name</label>
            <input type="text" name="establishment_name" class="form-control" value="{{ old('establishment_name') }}" placeholder="e.g. FoodieBert Central" required>
            @error('establishment_name') <span class="error-msg">{{ $message }}</span> @enderror

            <label class="form-label">Proprietor Name</label>
            <input type="text" name="proprietor_name" class="form-control" value="{{ old('proprietor_name') }}" placeholder="Full Name of Owner" required>
            @error('proprietor_name') <span class="error-msg">{{ $message }}</span> @enderror

            <label class="form-label">Owner Email</label>
            <input type="email" name="owner_email" class="form-control" value="{{ old('owner_email') }}" placeholder="email@example.com" required>
            @error('owner_email') <span class="error-msg">{{ $message }}</span> @enderror

            <label class="form-label">Location Address (Bertoua)</label>
            <input type="text" name="location_address" class="form-control" value="{{ old('location_address', 'Bertoua, ') }}" required>
            @error('location_address') <span class="error-msg">{{ $message }}</span> @enderror

            <label class="form-label">Category</label>
            <select name="category" class="form-control" required style="appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23C5A059%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.4-12.8z%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 0.65rem auto;">
                <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select Category</option>
                <option value="Fine Dining" {{ old('category') == 'Fine Dining' ? 'selected' : '' }}>Fine Dining</option>
                <option value="Cafe" {{ old('category') == 'Cafe' ? 'selected' : '' }}>Cafe</option>
                <option value="Casual Eateries" {{ old('category') == 'Casual Eateries' ? 'selected' : '' }}>Casual Eateries</option>
                <option value="Snack Bars" {{ old('category') == 'Snack Bars' ? 'selected' : '' }}>Snack Bars</option>
                <option value="Fast Food" {{ old('category') == 'Fast Food' ? 'selected' : '' }}>Fast Food</option>
            </select>
            @error('category') <span class="error-msg">{{ $message }}</span> @enderror

            <label class="form-label" style="margin-top: 15px;">Restaurant Cover Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
            <small style="color: #a0aec0; font-size: 0.7rem; display: block; margin-bottom: 5px;">Max file size: 2MB (JPG, PNG, WebP)</small>
            @error('image') <span class="error-msg">{{ $message }}</span> @enderror

            <label class="form-label" style="margin-top: 15px;">Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Briefly describe your services..." required>{{ old('description') }}</textarea>
            @error('description') <span class="error-msg">{{ $message }}</span> @enderror

            <button type="submit" class="btn-submit">SUBMIT APPLICATION</button>
        </form>
    </div>
</section>

@include('components.footer')