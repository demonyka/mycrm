<?php

namespace App\Http\Middleware;

use App\Models\Staff\User;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        /* @var User $user */
        $user = $request->user();
        return [
            ...parent::share($request),
            'csrf_token' => csrf_token(),
            'auth' => [
                'user' => $user->append('permissions'),
            ],
            'app' => [
                'name' => config('app.name'),
            ],
        ];
    }
}
