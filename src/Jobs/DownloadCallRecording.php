<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use SamuelMwangiW\Africastalking\Events\CallRecordingDownloaded;
use SamuelMwangiW\Africastalking\Events\RecordingDownloadFailed;
use Throwable;

class DownloadCallRecording implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly string $url,
        public readonly string $callSessionId,
        public readonly string|null $disk = null
    ) {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $file = Http::get($this->url)
            ->throw()
            ->body();

        $path = 'call-recordings/'.basename($this->url);

        Storage::disk(
            $this->disk()
        )->put($path, $file);

        CallRecordingDownloaded::dispatch($this->callSessionId, $this->url, $path, $this->disk());
    }

    public function uniqueId(): string
    {
        return $this->url;
    }

    public function backoff(): array
    {
        return [1, 10, 50, 120];
    }

    public function failed(Throwable $exception): void
    {
        RecordingDownloadFailed::dispatch($this->callSessionId, $this->url, $this->disk());
    }

    public function disk(): string
    {
        return $this->disk ?? strval(config('filesystems.default', 'local'));
    }
}
