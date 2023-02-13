<?php
namespace App\Http\Controllers\Auth;

use App\Domains\Users\Models\User;
use App\Domains\Users\Repositories\ApiTokensRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LocalLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status'           => session('status'),
            'isLocal'          => app()->environment('local'),
        ]);
    }

    public function store(LocalLoginRequest $request): RedirectResponse
    {
        Auth::login(User::find($request->input('userid')));
        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request): RedirectResponse
    {
        app(ApiTokensRepository::class)->destroy(Auth::user());

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
