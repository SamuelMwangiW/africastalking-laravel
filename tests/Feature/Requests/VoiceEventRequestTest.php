<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use SamuelMwangiW\Africastalking\Http\Requests\VoiceEventRequest;

use SamuelMwangiW\Africastalking\Jobs\DownloadCallRecording;

use function Pest\Laravel\post;

it('Downloading recording dispatches DownloadCallRecording job', function (array $notification): void {
    Bus::fake([DownloadCallRecording::class]);
    Route::post('call', function (VoiceEventRequest $request) {
        $request->downloadRecording();

        return 'OK';
    });

    post('/call', $notification);
    Bus::assertDispatched(
        command: DownloadCallRecording::class,
        callback: fn (DownloadCallRecording $job) => $job->url === data_get($notification, 'recordingUrl')
    );
})->with('voice-event-notification-with-recording');

it('downloads a file', function (string $url): void {
    Storage::fake();
    Http::fake();

    Storage::deleteDirectory('call-recordings');

    DownloadCallRecording::dispatch($url);

    Storage::assertExists('call-recordings')
        ->assertExists('call-recordings/Free_Test_Data_100KB_MP3.mp3');
})->with([
    'https://example.com/Free_Test_Data_100KB_MP3.mp3',
]);

it('downloads a file to disk', function (string $url): void {
    Storage::fake('s3');
    Http::fake();

    Storage::deleteDirectory('call-recordings');

    DownloadCallRecording::dispatch($url, 's3');

    Storage::disk('s3')
        ->assertExists('call-recordings')
        ->assertExists('call-recordings/Free_Test_Data_100KB_MP3.mp3');
})->with([
    fn () => 'https://example.com/Free_Test_Data_100KB_MP3.mp3',
]);
