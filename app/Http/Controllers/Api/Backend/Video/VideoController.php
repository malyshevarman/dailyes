<?php

namespace App\Http\Controllers\Api\Backend\Video;

use App\Http\Controllers\Controller;
use App\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function storeMultiple(Request $request)
    {
        $videos = [];
        foreach ($request->videos as $video) {
            $video = Video::create(['link' => $video]);
            $videos[] = $video;
        }

        return $videos;
    }
}
