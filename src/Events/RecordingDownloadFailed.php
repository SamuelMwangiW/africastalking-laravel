<?php

namespace SamuelMwangiW\Africastalking\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecordingDownloadFailed
{
    use Dispatchable;
    use SerializesModels;
    use InteractsWithSockets;

    public function __construct(
        public readonly string $sessionId,
        public readonly string $recordingUrl,
        public readonly string $disk,
    )
    {
    }
}
