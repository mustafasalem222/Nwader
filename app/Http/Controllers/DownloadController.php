<?php

namespace App\Http\Controllers;

use App\Models\Telaawah;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download(Telaawah $telaawah)
    {
        $url = $telaawah->audio_url;
        $disk = Storage::disk('public');
        $storagePrefix = rtrim($disk->url(''), '/');

        $relativePath = null;
        if (str_starts_with($url, $storagePrefix)) {
            $relativePath = ltrim(substr($url, strlen($storagePrefix)), '/');
        }

        $extension = $relativePath
            ? pathinfo($relativePath, PATHINFO_EXTENSION)
            : (pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'mp3');

        $filename = $telaawah->name . '.' . $extension;
        $headers = ['Content-Disposition' => "attachment; filename*=UTF-8''" . rawurlencode($filename)];

        if ($relativePath && $disk->exists($relativePath)) {
            $headers['Content-Type'] = $disk->mimeType($relativePath) ?: 'application/octet-stream';
            $headers['Content-Length'] = $disk->size($relativePath);
            return response()->stream(function () use ($disk, $relativePath) {
                $stream = $disk->readStream($relativePath);
                if ($stream) {
                    fpassthru($stream);
                    fclose($stream);
                }
            }, 200, $headers);
        }

        try {
            $response = Http::withOptions(['stream' => true])->get($url);
            $headers['Content-Type'] = $response->header('Content-Type') ?: 'application/octet-stream';
            $length = $response->header('Content-Length');
            if ($length) {
                $headers['Content-Length'] = $length;
            }
            return response()->stream(function () use ($response) {
                $body = $response->toPsrResponse()->getBody();
                while (!$body->eof()) {
                    echo $body->read(8192);
                }
            }, 200, $headers);
        } catch (\Exception $e) {
            return redirect($url);
        }
    }
}
