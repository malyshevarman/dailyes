<?php

namespace App\Http\Controllers\Api\Backend\Report\Answer;

use App\Report;
use App\ReportsAnswer as Answer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Request $request, Report $report)
    {
        $validData = $this->validate($request, [
            'parent.id' => 'nullable|exists:reports_answers,id',
            'text' => 'required|string'
        ]);

        $answer = Answer::make([
            'text' => $validData['text']
        ]);

        empty($validData['parent']) ?: $answer->parent()->associate($validData['parent']['id']);
        $answer->report()->associate($report);
        $answer->user()->associate(\Auth::user());
        $answer->save();

        return 'ok';
    }
}
