<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoiceTranscriptUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sessionId;
    public $transcript;

    public function __construct($sessionId, $transcript)
    {
        $this->sessionId = $sessionId;
        $this->transcript = $transcript;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('curhat-session.' . $this->sessionId);
    }

    public function broadcastAs()
    {
        return 'voice.transcript.updated';
    }

    public function broadcastWith()
    {
        return [
            'sessionId' => $this->sessionId,
            'transcript' => $this->transcript,
        ];
    }
}
