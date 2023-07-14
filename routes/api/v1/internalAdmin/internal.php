<?php
use App\Domains\Internal\Models\InternalAdmin;
use App\Domains\Internal\Resources\InternalAdminCollection;

Route::group([
    'prefix' => 'internal-admin',
    'as' => 'internal.'
], function () {
    include __DIR__ . '/auth.php';
});
Route::group([
    'prefix' => 'internal-admin',
    'middleware' => 'auth:internalAdmin',
], function () {
    Route::group(['as' => 'internal.'], function () {
        include __DIR__ . '/request.php';
        Route::get('/user', function () {
            $user = Auth::guard('internalAdmin')->user()->id;
            return InternalAdminCollection::collection(InternalAdmin::find($user)->get());
        });
        Route::post('/logout', function () {
            Auth::guard('internalAdmin')->user()->token()->revoke();
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
            // return Auth::guard('internalAdmin')->user();
        });
        // Notification
        Route::get('/notifications', function(){
            return response()->json([
                'unread' => Auth::guard('internalAdmin')->user()->unreadnotifications,
                'all' => Auth::guard('internalAdmin')->user()->notifications()->get(),
            ]);
        });
        Route::get('/mark-as-read', function(){
            return Auth::guard('internalAdmin')->user()->unreadNotifications->markAsRead();
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
