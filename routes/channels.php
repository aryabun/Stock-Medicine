<?php
use App\Domains\External\Models\ExternalAdmin;
use App\Domains\Internal\Models\InternalAdmin;
use App\Domains\Stock_Management\Models\RequestTransfer;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
Broadcast::channel('users.notification.{id}', function ($user, $id) {
    return (string) $user->code === (string) $id;
}, ['guard' => ['internalAdmin', 'externalAdmin']]);
Broadcast::channel('request.approved.{orderId}', function ($user, string $request_id) {
    return $user->code === RequestTransfer::findOrFail($request_id)->user_id;
});
Broadcast::channel('request.submit.{id}', function ($id) {
    return (string) $id->code === InternalAdmin::findOrFail($id->code);
});
// Broadcast::channel('request_submit');
//Broadcast::channel('App.Domains.Auth.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});
