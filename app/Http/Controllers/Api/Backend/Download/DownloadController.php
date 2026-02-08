<?php

namespace App\Http\Controllers\Api\Backend\Download;

use App\Download;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class DownloadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // так сделал, чтобы нормально сохранял svg файлы и другие
        $path = Storage::putFileAs('uploads', $request->file, time() . rand(1111, 9999) . '.' . $request->file->getClientOriginalExtension());

        $download = Download::create([
            'path' => $path,
            'original_name' => $request->file->getClientOriginalName(),
            'mime_type' => $request->file->getMimeType(),
            'size' => $request->file->getSize()
        ]);

        return $download;
    }

    // TODO по сути метод создания надо отсюда убрать, дабы избежать копипаста в store()
    public function storeMultiple(Request $request)
    {
        $downloads = [];
        foreach ($request->file('files') as $file) {
            // так сделал, чтобы нормально сохранял svg файлы и другие
            $path = Storage::putFileAs('uploads', $file, time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension());

            $download = Download::create([
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize()
            ]);

            $downloads[] = $download;
        }

        return $downloads;
    }

    /**
     * Display the specified resource.
     *
     * @param Download $download
     * @return \Illuminate\Http\Response
     */
    public function show(Download $download)
    {
        return $download;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Download $download
     * @return int
     * @throws \Exception
     */
    public function destroy(Download $download)
    {
        Storage::disk('public')->delete($download->path);
        $download->delete();

        return ['result' => true];
    }
}
