<?php

namespace App\Http\Controllers\Api\Backend\Company\GalleryItem;

use App\Download;
use App\Company;
use App\Http\Controllers\Controller;
use App\Video;
use Illuminate\Http\Request;
use Storage;

class GalleryItemController extends Controller
{
    /**
     * @param Request $request
     * @param Company $company
     * @return
     * @throws \Illuminate\Validation\ValidationException
     */
    public function video(Request $request, Company $company)
    {
        $validData = $this->validate($request, [
            'link' => 'required|string'
        ]);

        $video = Video::create($validData);

        return $video->company_gallery_items()->save(
            $company->gallery_items()->make([
                'sort' => 9999
            ])
        )->load('attachable');
    }

    /**
     * @param Request $request
     * @param Company $company
     * @return
     */
    public function photo(Request $request, Company $company)
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

                    $photos[] = $photo->company_gallery_items()->save(
                        $company->gallery_items()->make([
                            'sort' => 9999
                        ])
                    )->load('attachable');
                }
            }
        }

        return $photos;
    }
}
