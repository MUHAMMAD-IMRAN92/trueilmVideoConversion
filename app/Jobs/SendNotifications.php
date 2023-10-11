<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SendNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $user;
    public $playerId = '';
    public $type;
    public $message;
    // type 1 :  send to all
    // type 0 :  send to specific user
    public function __construct($user, $message, $type)
    {
        $this->user = User::where('_id', $user)->first();
        if ($this->user) {
            $this->playerId = $this->user->player_id ?? '';
        }
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type == 0 && $this->playerId != '') {
            \OneSignal::sendNotificationToUser($this->message,  $this->playerId, $url = null, $data = null);
        } else {
            \OneSignal::sendNotificationToAll(
                $this->message,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null
            );
        }
    }
}
