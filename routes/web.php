<?php

use Illuminate\Foundation\Application;
use App\Http\Controllers\DrivingServiceController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Chat;
use App\Models\Boardentry;
use App\Events\ChatSent;
use App\Http\Resources\Chat as ChatResource;
use App\Http\Resources\Boardentry as BoardentryResource;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/pretix/login', function () {
    return Inertia::render('PretixLogin');
})->name('pretix');


Route::get('/pretix/login/{token}', function ($token) {
    if (empty($token)) {
        return abort(403);
    }
    $user = User::where('token', $token)->first();

    if ($user) {
        Auth::loginUsingId($user->id, true);

        return redirect('/');
    }

    return abort(403);
});

Route::get('/offline', function () {
    return view('offline');
});

Route::get('/site.webmanifest', function () {
    return view('manifest');
});

/* Live */
Route::get('/live', function () {
    return inertia('Live');
})->name('live');


/* --- auth routes --- */

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    /* Project Routes */
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::put('/projects/{project}', [ProjectController::class, 'update']);
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy']);

    /* Fahrdienst */
    Route::get('/driving_services', [DrivingServiceController::class, 'index'])->name("drivings");
    Route::post('/driving_services', [DrivingServiceController::class, 'store']);
    Route::put('/driving_services/{driving_service}', [DrivingServiceController::class, 'update']);
    Route::delete('/driving_services/{driving_service}', [DrivingServiceController::class, 'destroy']);

    /* Chats */
    Route::get('/chats', function () {
        return ChatResource::collection(Chat::with('user')->get());
    });

    Route::post('/chats', function () {
        $message = request()->message;
        if (empty($message))
            return abort(400);
        $chat = new Chat;
        $chat->content = request()->message;
        $chat->user_id = auth()->user()->id;
        $chat->save();

        event(new ChatSent(new ChatResource($chat)));
    });

    /* Pinnwand */
    Route::get('/boardentries', function () {
        return inertia('Boardentries/Index', ['boardentries' => BoardentryResource::collection(Boardentry::with('user')->get())]);
    })->name('boardentries');

    Route::post('/boardentries', function () {
        request()->validate([
            'content' => ['required'],
        ]);

        $chat = new Boardentry;
        $chat->content = request()->content;
        $chat->user_id = auth()->user()->id;
        $chat->save();

        return redirect()->back();
    });

    Route::delete('/boardentries/{boardentry}', function (Boardentry $boardentry) {
        Gate::authorize('delete', $boardentry);
        $boardentry->delete();
        return redirect()->back();
    });

    /* Teilnehmer*innen */
    Route::get(
        '/users',
        function () {
            $users = User::with('projects')->orderBy('name')->get();
            return inertia('Users/Index', ['users' => UserResource::collection($users)]);
        }
    )->name("users");

    Route::get('/user/{user}', function (User $user) {
        return inertia('Users/user', ['vuser' => new UserResource($user)]);
    });

    /* Fahrplan */
    Route::get('/fahrplan', function () {
        return inertia('Pretalx');
    })->name('fahrplan');
});
