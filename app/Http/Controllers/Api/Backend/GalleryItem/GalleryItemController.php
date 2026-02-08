<?php

namespace App\Http\Controllers\Api\Backend\GalleryItem;

use App\Download;
use App\GalleryItem;
use App\Http\Controllers\Controller;
use App\Video;
use Illuminate\Http\Request;
use Storage;

class GalleryItemController extends Controller
{
    /**
     * @param Request $request
     * @return
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeMultiple(Request $request)
    {
        $validData = $this->validate($request, [
            'downloads' => 'array',
            'videos' => 'array'
        ]);

        $galleryItems = collect();
        foreach ($validData['downloads'] ?? [] as $file) {
            // так сделал, чтобы нормально сохранял svg файлы и другие
            $path = Storage::putFileAs('uploads', $file, time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension());

            $galleryItems->push(Download::create([
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize()
            ])->gallery_items()->save(
                GalleryItem::make()
            )->load('attachable'));
        }
        foreach ($validData['videos'] ?? [] as $video) {
            $galleryItems->push(Video::create(['link' => $video])->gallery_items()->save(
                GalleryItem::make()
            )->load('attachable'));
        }

        return $galleryItems;
    }

    public function removeMultiple(GalleryItem $galleryItem)
    {
        // $validData = $this->validate($request, [
        //     'downloads' => 'array',
        //     'videos' => 'array'
        // ]);
        // dd($galleryItem);
        $download = Download::find($galleryItem->attachable_id);
        Storage::disk('public')->delete($download->path);
        $download->delete();
        $galleryItem->delete();

        return ['result' => true];
    }
}
