<?php
use App\Domains\External\Models\ExternalAdmin;
use App\Domains\External\Resources\ExternalAdminCollection;

Route::group([
    'prefix' => 'external-admin',
    'as' => 'external.'
], function () {
    include __DIR__ . '/auth.php';
});

Route::group([
    'prefix' => 'external-admin',
    'middleware' => 'auth:externalAdmin',
], function () {
    Route::group(['as' => 'external.'], function () {
        include __DIR__ . '/request.php';
        Route::get('/user', function () {
            $user = Auth::guard('externalAdmin')->user()->id;
            return ExternalAdminCollection::collection(ExternalAdmin::find($user)->get());
        });
        Route::post('/logout', function () {
            Auth::guard('externalAdmin')->user()->token()->revoke();
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
            // return Auth::guard('internalAdmin')->user();
        });
        // Notification
        Route::get('/notifications', function(){
            return response()->json([
                'unread' => Auth::guard('externalAdmin')->user()->unreadnotifications,
                'all' => Auth::guard('externalAdmin')->user()->notifications()->get(),
            ]);
        });
        Route::get('/mark-as-read', function(){
            return Auth::guard('externalAdmin')->user()->unreadNotifications->markAsRead();
        });

        Route::group(['prefix' => 'access-denied'], function () {
            Route::get('/', function () {
                return response([
                    'error' => 1,
                    'message' => 'access-denied'
                ], 403);
            })->name('access_denied');
        });
    });

});
