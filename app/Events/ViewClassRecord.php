<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ViewClassRecord
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $sched_id;
    public $term_id;
    public $p_id;
    public $stud_sched;
    public $lec;
    public $lab;

    public function __construct($sched_id,$term_id,$p_id,$stud_sched,$lec_grade,$lab_grade)
    {
        $this->sched_id = $sched_id;
        $this->term_id  = $term_id;
        $this->p_id     = $p_id;
        $this->stud_sched = $stud_sched;
        $this->lec = $lec_grade;
        $this->lab = $lab_grade;
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
