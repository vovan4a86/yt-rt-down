<?php

namespace App\Http\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PageController extends Controller
{
    public function ytdlp()
    {
        return view('ytdown');
    }

    public function getName()
    {
        $url = \request('url');

        $process = new Process(array('yt-dlp',
            '--print',
            '"%(title)s"',
            $url
        ));

        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json([
            'success' => true,
            'text' => $process->getOutput()
        ]);
    }

    public function getFile() {
        $url = \request('url');
        $this->deleteFiles();

//        $process = new Process(array('yt-dlp',
//            '--output',
//            'output/%(title)s.%(ext)s',
//            '--write-thumbnail',
//            '--extract-audio',
//            '--audio-format', 'mp3',
//            $url
//        ));

        //yt-dlp -f ba -x --audio-format mp3 --downloader=aria2c --downloader--args '--min-split-size=1M --max-connection-per-server=16 --max-concurrent-downloads=16 --split=16' $URL_HERE
        //sdf
        //https://youtu.be/k9Lzmx_Rflg?si=KTC6AQaXNxOt1efK

        $process = new Process(array('yt-dlp',
            '-x',
            '--audio-format',
            'mp3',
            '--audio-quality',
            '5',
            '--output',
            'output/%(title)s.%(ext)s',
            '--write-thumbnail',
            '--downloader=aria2c',
            '--downloader-args',
            '\'--min-split-size=1M --max-connection-per-server=16 --max-concurrent-downloads=16 --split=16\'',
            $url
        ));
        $process->setTimeout(3600);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $name = null;
        $file = null;
        $thumb = null;
        $ext = '';
        $files = scandir(public_path('/output'));
        foreach ($files as $file_name) {
            if ($file_name != '.' || $file_name != '..') {
                if (preg_match('/\.(mp3)/', $file_name)) {
                    $new_filename = preg_replace("/[^()-+?. a-zа-яё\d]/ui", "", $file_name);
                    rename(public_path('/output/') . $file_name,
                        public_path('/output/') . $new_filename);
                    $file = '/output/' . $new_filename;
                    $name = preg_replace('/\.(mp3)/', '', $new_filename);
                }
                if (preg_match('/\.(jpg|jpeg|webp|png)/', $file_name)) {
                    $new_filename = preg_replace("/[^()-+?. a-zа-яё\d]/ui", "", $file_name);
                    rename(public_path('/output/') . $file_name,
                        public_path('/output/') . $new_filename);
                    $dot_index = mb_strrpos($new_filename, '.');
                    $ext = mb_substr($new_filename, $dot_index);
                    $thumb = '/output/' . $new_filename;
                }
            }
        }
        $webp = $ext == '.webp';
        $newString = mb_convert_encoding([
            'success' => true,
            'file' => $file,
            'name' => $name,
            'thumb' => $thumb,
            'webp' => $webp
        ], "UTF-8", "auto");
        Debugbar::log($newString);
        return response()->json($newString);
    }

    public function deleteFiles() {
        array_map("unlink", glob(public_path('/output/*.*')));

        return ['success' => true];
    }
}
