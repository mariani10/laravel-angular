<?php

namespace App\Listeners;

use Auth;
use App\User;
use App\AclLogin;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogLockout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Lockout  $event
     * @return void
     */
    public function handle(Lockout $event)
    {
        $user_id = User::where('email', $event->request->email)->select('id')->first();
        $login = new AclLogin;

        $login->login_tipo_id = 3;
        $login->user_id = $user_id ? $user_id->id : NULL;
        $login->user_ip = ip2long($event->request->getClientIp());
        $login->user_agent = $event->request->server('HTTP_USER_AGENT');
        $login->user_origen = $event->request->server('HTTP_REFERER');

        $login->save();
    }
}
