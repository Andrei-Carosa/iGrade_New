<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ViewFRS
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $sched_id;
    public $ay_id;
    public $sem_id;
    public $stud_sched;
    public $p_id;
    public $course_id;

    public function __construct($sched_id,$ay_id,$sem_id,$stud_sched,$p_id,$course_id)
    {

        $this->sched_id = $sched_id;
        $this->ay_id = $ay_id;
        $this->sem_id = $sem_id;
        $this->stud_sched = $stud_sched;
        $this->p_id = $p_id;
        $this->course_id = $course_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
