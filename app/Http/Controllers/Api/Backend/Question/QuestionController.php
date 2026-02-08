<?php

namespace App\Http\Controllers\Api\Backend\Question;

use App\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function filter(Request $request)
    {
        $query = Question::with([
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

    public function destroy(Question $question)
    {
        return Question::destroy($question->id);
    }

    public function toggle(Request $request, Question $question)
    {
        $question->published = !$question->published;
        $question->save();

        return 'ok';
    }
}
