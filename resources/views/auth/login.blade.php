<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:18px;">
        @csrf

        <!-- Email -->
        <div>
            <div class="auth-input-wrap">
                <span class="auth-input-icon">
                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.761 0 5-2.239 5-5s-2.239-5-5-5-5 2.239-5 5 2.239 5 5 5zm0 2c-3.315 0-10 1.655-10 5v1h20v-1c0-3.345-6.685-5-10-5z"/>
                    </svg>
                </span>
                <input
                    id="email"
                    class="auth-input"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Email Address"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" style="color:#f87171;font-size:12px;" />
        </div>

        <!-- Password -->
        <div>
            <div class="auth-input-wrap">
                <span class="auth-input-icon">
                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 1C8.676 1 6 3.676 6 7v1H4v15h16V8h-2V7c0-3.324-2.676-6-6-6zm0 2c2.276 0 4 1.724 4 4v1H8V7c0-2.276 1.724-4 4-4zm0 9a2 2 0 110 4 2 2 0 010-4z"/>
                    </svg>
                </span>
                <input
                    id="password"
                    class="auth-input"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Password"
                />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" style="color:#f87171;font-size:12px;" />
        </div>

        <!-- Remember Me -->
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <label for="remember_me" style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                <input id="remember_me" type="checkbox" name="remember" style="accent-color:#20b2aa;width:14px;height:14px;">
                <span style="font-size:12px;color:rgba(148,163,184,0.8);">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:12px;color:rgba(32,178,170,0.85);text-decoration:underline;">
                    Forgot Password?
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="login-btn">
            Login
        </button>

    </form>

</x-guest-layout>
