<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\User;
use App\Models\UserDevices;
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
    public $playerId;
    public $type;
    public $message;
    // type 0 :  send to all
    // type 1 :  send to specific user
    public function __construct($user, $message, $type)
    {
        $this->user = User::where('_id', $user)->first();
        if ($this->user) {
            $devices = UserDevices::where('user_id')->pluck('player_id');
            $this->playerId = $devices;
        } else {
            $this->playerId = [];
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
        if ($this->type == 1) {
            if (count($this->playerId) > 0) {

                foreach ($this->playerId as $player) {
                    \OneSignal::sendNotificationToUser($this->message,  $player, $url = null, $data = null);

                    $notification = new Notification();
                    $notification->user_id = $this->user->_id;
                    $notification->notification = $this->message;
                    $notification->is_read = 0;
                    $notification->send_to = 1;
                    $notification->save();
                }
            }
        } else {

            \OneSignal::sendNotificationToAll(
                $this->message,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null
            );
            $notification = new Notification();
            $notification->user_id = 0;
            $notification->notification = $this->message;
            $notification->is_read = 0;
            $notification->send_to = 0;
            $notification->save();
        }
    }
}
