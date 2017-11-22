<?php

namespace App\Listeners;

use App\AclLogin;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Failed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogFailedLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        $login = new AclLogin;

        $login->login_tipo_id = 2;
        $login->user_id = $event->user ? $event->user->id : NULL;
        $login->user_ip = ip2long($this->request->getClientIp());
        $login->user_agent = $this->request->server('HTTP_USER_AGENT');
        $login->user_origen = $this->request->server('HTTP_REFERER');

        $login->save();
    }
}
