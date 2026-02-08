<?php

use App\City;
use App\Event;
use App\Helpers\Frontend\Spravkur\Pular as PularHelper;
use Illuminate\Database\Query\Expression;

/*
 * Global helpers file with misc functions.
 */
if (! function_exists('include_route_files')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function include_route_files($folder)
    {
        try {
            $it = new FilesystemIterator($folder);

            while ($it->valid()) {
                if (! $it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if (!function_exists('city')) {

    function city()
    {
        // return City::when($citySlug = request()->cookie('citySlug'), function ($q) use ($citySlug) {
        //     return $q->where('slug', $citySlug);
        // })->first() ?? City::near()->firstOrFail();
      //  $citySlug = isset($_COOKIE['citySlug']) ? $_COOKIE['citySlug'] : null;
       // return City::where('slug', $citySlug)->first() ?? City::near()->first();


        $url = parse_url(url()->full());
        $cityslug = explode('.', $url['host'])[0];
        $city = City::where('slug', $cityslug)->first();
        if (is_null($city)) {
            $city = City::where('name', 'Москва')->first();
        }
        return $city;

    }
}

// пример форм ['отзыв', 'отзыва', 'отзывов']
if (! function_exists('pular')) {

    /**
     * @param int $number
     * @param array $forms
     * @return string
     */
    function pular(int $number, array $forms)
    {
        $number %= 100;
        if ($number >= 5 && $number <= 20) {
            return $forms[2];
        }
        $number %= 10;
        if ($number == 1) {
            return $forms[0];
        }
        if ($number >= 2 && $number <= 4) {
            return $forms[1];
        }
        return $forms[2];
    }
}

if (!function_exists('recently_events')) {

    function recently_events($currentEvent = null)
    {
        $events = json_decode(\Cookie::get('recently_viewed_events'), TRUE);
        if (empty($events)) {
            return collect();
        }
        krsort($events);

        if (!is_null($currentEvent)) {
            foreach ($events as $key => $event)
            {
                if($event==$currentEvent->id){
                    unset($events[$key]);
                    break;
                }
            }
        }
        if (empty($events)) {
            return collect();
        }
        return \App\Event::whereIn('id', $events)
            ->orderBy(new Expression('FIELD(id,' . implode(',', $events) . ')'))
            ->limit(6)
            ->get();
    }
}

// if (!function_exists('today_events')) {

//     function today_events()
//     {

//         return \App\Event::whereDate('created_at', date('Y-m-d'))->limit(3)->get();
//     }
// }

if (!function_exists('cutter')) {

    function cutter(string $string)
    {
        $string = strip_tags($string);
        $string = substr($string, 0, 100);
        $string = rtrim($string, "!,.-");
        $string = substr($string, 0, strrpos($string, ' '));

        return $string."… ";
    }
}
