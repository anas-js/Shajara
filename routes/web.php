<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\profileController;
use App\Http\Middleware\Auth;
use App\Http\Middleware\Registered;
use App\Http\Middleware\subdomain;
use App\Http\Middleware\Viewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;





// Route::domain("{username}.".env('APP_DOMAIN','shajara.juzr.sa'))->middleware(subdomain::class)->group(function () {
//     Route::middleware(Viewer::class)->get('/',[profileController::class, 'view']);
// });


Route::middleware([Auth::class])->group(function () {

    Route::middleware(Registered::class)->prefix('dashboard')->group(function () {
        Route::get('/', function (Request $request) {
            $info = $request->user()->regInfo;
            return Inertia::render('dashboard', [
                'views' => $info->page_views,
                'clicks' => $info->links_clicks
            ]);
        });

        Route::prefix('links')->group(function () {

            Route::get('/', function (Request $request) {

                $user = $request->user();
                $request->validate([
                    'per' => ['int','in:10,20,30'],
                    'page' => ['int','max:100']
                ]);

                $per = $request->get('per',"10");
                $page = $request->get('page',"1");
                // dd($user->links()->simplePaginate($per)->count());
                return Inertia::render('links', [
                    'links' => $user->links()->simplePaginate($per)->items(),
                    'total_links' => $user->links()->count(),
                    'per' => $per,
                    'page' => $page
                ]);
            });



            Route::get('/{id}/edit', function (Request $request, $id) {
                $user = $request->user();
                $link = $user->links()->find($id);
                if ($link) {
                    return Inertia::render('links/edit', [
                        'link' => $link
                    ]);
                }

                return abort(404);
            });

            Route::get('/create', function () {
                return Inertia::render('links/create');
            });
        });
    });

    Route::get('/registration', function (Request $request) {
        if ($request->user()->isRegistered()) {
            return redirect('/dashboard');
        }
        return Inertia::render('registration');
    });
});


Route::middleware(Viewer::class)->get('/{username}', [profileController::class, 'view'])->where("username", "^@[A-Za-z0-9\_]{3,9}$");

Route::get('/',function () {
    return Inertia::render('index');
});

