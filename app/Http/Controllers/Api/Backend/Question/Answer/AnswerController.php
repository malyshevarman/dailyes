<?php

namespace App\Http\Controllers\Api\Backend\Question\Answer;

use App\QuestionAnswer as Answer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function filter(Request $request)
    {
        $query = Answer::with([
            'user'
        ]);

        if (!empty($request->search['text'])) {
            $query->where('name', 'LIKE', '%' . $request->search['text'] . '%');
        }
        
        if (!empty($request->search['city'])) {
            $city_name = $request->search['city'];
            if ($city_name !== 0) {
                $query->whereHas('user', function ($q) use ($city_name) {
                    $q->where('city', 'LIKE', '%' . $city_name . '%');
                });
            }
        }

        $items = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            ->paginate($request->input('pagination.per_page'));

        return $items;
    }

    public function destroy(Answer $answer)
    {
        return Answer::destroy($answer->id);
    }

    public function toggle(Request $request, Answer $answer)
    {
        $answer->published = !$answer->published;
        $answer->save();

        return 'ok';
    }
}
