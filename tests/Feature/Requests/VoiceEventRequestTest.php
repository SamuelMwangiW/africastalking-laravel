<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use SamuelMwangiW\Africastalking\Events\CallRecordingDownloaded;
use SamuelMwangiW\Africastalking\Events\RecordingDownloadFailed;
use SamuelMwangiW\Africastalking\Http\Requests\VoiceEventRequest;
use SamuelMwangiW\Africastalking\Jobs\DownloadCallRecording;

use Symfony\Component\HttpFoundation\Response;

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
        callback: fn(DownloadCallRecording $job) => $job->url === data_get($notification, 'recordingUrl') &&
            $job->callSessionId === data_get($notification, 'sessionId')
    );
})->with('voice-event-notification-with-recording');

it('does not download recording when call duration is zero', function (array $notification): void {
    Bus::fake();
    Route::post('call', function (VoiceEventRequest $request) {
        $request->downloadRecording();

        return 'OK';
    });

    post('/call', $notification);
    Bus::assertNothingDispatched();
})->with('voice-event-notification-with-0-duration');

it('does not download recording when recordingUrl is empty', function (array $notification): void {
    Bus::fake();
    Route::post('call', function (VoiceEventRequest $request) {
        $request->downloadRecording();

        return 'OK';
    });

    post('/call', $notification);
    Bus::assertNothingDispatched();
})->with('voice-event-notification-with-empty-recordingUrl');

it('downloads a recording', function (string $url): void {
    Storage::fake();
    Http::fake();

    Storage::deleteDirectory('call-recordings');

    DownloadCallRecording::dispatch($url, 'sessionId');

    Storage::assertExists('call-recordings')
        ->assertExists('call-recordings/Free_Test_Data_100KB_MP3.mp3');
})->with([
    'https://example.com/Free_Test_Data_100KB_MP3.mp3',
]);

it('downloads a recording to disk', function (string $url): void {
    Storage::fake('s3');
    Http::fake();

    Storage::deleteDirectory('call-recordings');

    DownloadCallRecording::dispatch($url, 'sessionId', 's3');

    Storage::disk('s3')
        ->assertExists('call-recordings')
        ->assertExists('call-recordings/Free_Test_Data_100KB_MP3.mp3');
})->with([
    fn() => 'https://example.com/Free_Test_Data_100KB_MP3.mp3',
]);

it('downloads a recording to a specified path on disk', function (string $url): void {
    Storage::fake('s3');
    Http::fake();

    Storage::deleteDirectory('call-recordings');

    DownloadCallRecording::dispatch($url, 'sessionId', 's3', 'path/to/file/example.mp3');

    Storage::disk('s3')
        ->assertExists('path/to/file')
        ->assertExists('path/to/file/example.mp3');
})->with([
    fn() => 'https://example.com/Free_Test_Data_100KB_MP3.mp3',
]);

it('can fail to downloads a recording to disk', function (string $url): void {
    Storage::fake('s3');
    Http::fake([
        '*' => Http::response(null, Response::HTTP_NOT_FOUND),
    ]);

    Storage::deleteDirectory('call-recordings');

    DownloadCallRecording::dispatch($url, 's3');

    Storage::disk('s3')->assertMissing('call-recordings');
})->with([
    fn() => 'https://example.com/Free_Test_Data_100KB_MP3.mp3',
]);

it('dispatches an event after downloading a recording', function (string $url): void {
    Storage::fake();
    Event::fake([CallRecordingDownloaded::class]);
    Http::fake();

    Storage::deleteDirectory('call-recordings');

    DownloadCallRecording::dispatch($url, 'sessionId');

    Event::assertDispatched(
        event: CallRecordingDownloaded::class,
        callback: fn(
            CallRecordingDownloaded $event
        ) => $event->recordingUrl === $url && 'sessionId' === $event->sessionId
    );
})->with([
    'https://example.com/Free_Test_Data_100KB_MP3.mp3',
]);

it('dispatches an event after download failed', function (string $url): void {
    Storage::fake();
    Event::fake();
    Http::fake([
        '*' => Http::response(null, Response::HTTP_NOT_FOUND),
    ]);

    Storage::deleteDirectory('call-recordings');

    DownloadCallRecording::dispatch($url, 'sessionId');

    Event::assertDispatched(
        event: RecordingDownloadFailed::class,
        callback: fn(
            RecordingDownloadFailed $event
        ) => $event->recordingUrl === $url && 'sessionId' === $event->sessionId
    );
})->with([
    'https://example.com/Free_Test_Data_100KB_MP3.mp3',
]);
