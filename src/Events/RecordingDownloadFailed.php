<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecordingDownloadFailed
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public readonly string $sessionId,
        public readonly string $recordingUrl,
        public readonly string $disk,
    ) {
    }
}
