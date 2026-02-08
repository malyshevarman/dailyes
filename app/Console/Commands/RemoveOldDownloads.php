<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Download;
use App\Company;
use App\Event;
// use App\EventCategory;
use App\Category as Category;
use App\Tile;
use App\Banner;
use App\Article;
use App\Slide;
use App\GalleryItem;
use Storage;
use File;
// use App\
class RemoveOldDownloads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:remove-downloads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $slides = Slide::with('image')->get();
        // $companies = Company::with(['image', 'background'])->get();
        // $companyCategories = Category::with('background')->get();
        // $events = Event::with(['background', 'image'])->get();
        // // $eventCategories = EventCategory::with('background')->get();
        // $tiles = Tile::with('image')->get();
        // $articles = Article::with(['preview', 'background'])->get();
        // $banners = Banner::with(['download', 'mobile'])->get();
        // $galleryItems = GalleryItem::get();
        // // dd($galleryItems->pluck('attachable')->toArray());
        // $result = array_merge(
        //     $articles->pluck('preview', 'background')->toArray(), 
        //     $slides->pluck('image')->toArray(),
        //     $companies->pluck('image', 'background')->toArray(),
        //     $companyCategories->pluck('background')->toArray(),
        //     $events->pluck('image', 'background')->toArray(),
        //     // $eventCategories->pluck('background')->toArray(),
        //     $tiles->pluck('image')->toArray(),
        //     $banners->pluck('download', 'mobile')->toArray(),
        //     $galleryItems->pluck('attachable')->toArray()
        // );
        // $result = collect($result)->pluck('path')->toArray();
        $downloads = Download::all()->pluck('path')->toArray();
        // dd($downloads);
        $path = storage_path('app/public/uploads/');
        $files = File::files($path);
        // dd($files[0]->getFilename());
        $count = 0;
        foreach ($files as $key => $file) {
            if (!in_array('uploads/'.$file->getFilename(), $downloads)) {
                $count += 1;
                File::delete($path.$file->getFilename());
                // dd($key . ' ' . $file->getFilename() . ' не найден в базе картинок');
            }
            // if (!in_array('uploads/'.$file->getFilename(), $result)) {
            //     File::delete($path.$file->getFilename());
            // }
        }
        dd($count);
    }
}
