<?php

namespace App\Http\Controllers\Api\Backend\Event\GalleryItem;

use App\Download;
use App\Event;
use App\Http\Controllers\Controller;
use App\Video;
use Illuminate\Http\Request;
use Storage;

class GalleryItemController extends Controller
{
    /**
     * @param Request $request
     * @param Event $event
     * @return
     * @throws \Illuminate\Validation\ValidationException
     */
    public function video(Request $request, Event $event)
    {
        $validData = $this->validate($request, [
            'link' => 'required|string'
        ]);

        $video = Video::create($validData);

        return $video->gallery_items()->save(
            $event->gallery_items()->make([
                'sort' => 9999
            ])
        )->load('attachable');
    }

    /**
     * @param Request $request
     * @param Event $event
     * @return
     */
    public function photo(Request $request, Event $event)
    {
        $photos = [];
        foreach ($request->files as $key => $files) {
            if ($key == 'files') {
                foreach ($files as $file) {
                    // так сделал, чтобы нормально сохранял svg файлы и другие
                    $path = Storage::putFileAs('uploads', $file, time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension());

                    $photo = Download::create([
                        'path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize()
                    ]);

                    $photos[] = $photo->gallery_items()->save(
                        $event->gallery_items()->make([
                            'sort' => 9999
                        ])
                    )->load('attachable');
                }
            }
        }

        return $photos;
    }
}
