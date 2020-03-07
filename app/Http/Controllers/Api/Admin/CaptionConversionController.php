<?php

namespace App\Http\Controllers\Api\Admin;

use App\Propaganda\Caption;
use App\Propaganda\LibraryCaption;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use \Done\Subtitles\Subtitles;


class CaptionConversionController extends Controller
{
    public function get_library_captions()
    {
        $captions = LibraryCaption::all();

        foreach ($captions as $key => $caption) {
            $caption = $this->convert_single_caption($caption);
        }

        dd('complet');
    }

    public function get_captions()
    {
        $captions = Caption::all();

        foreach ($captions as $key => $caption) {
            $caption = $this->convert_single_caption($caption);
        }

        dd('complet');
    }

    // https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
    public function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    // https://github.com/Buzut/srt2vtt/blob/master/srt2vtt.php
    public function convert_single_caption($caption)
    {

        if ($this->endsWith($caption->src, '.srt')) {
            $globalPath = Storage::disk('local')->getDriver()->getAdapter();

            // prendo la path del file
            $file = $caption->src;
            $path = str_replace('/storage', 'public', $file);

            // prendo la path globale del file di origine
            $filePath = $globalPath->applyPathPrefix($path);

            // prendo la path glbale del file di destinazione
            $destPath = str_replace('.srt', '.vtt', $filePath);

            // Read the srt file content into an array of lines
            $subtitles = Subtitles::convert($filePath, $destPath);
            dump('convertito -> '.$caption->src);

            $caption->src = str_replace('.srt', '.vtt', $caption->src);
            dump('verifica   -> '.$caption->src);
            $caption->save();
        }

        return $caption;
    }
}
