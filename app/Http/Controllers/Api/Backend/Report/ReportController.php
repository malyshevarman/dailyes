<?php

namespace App\Http\Controllers\Api\Backend\Report;

use App\Report;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function filter(Request $request)
    {
        $query = Report::with([
            'user',
            'reportable'
        ]);
        if ($request->type == 'company') {
            $query = $query->whereHasMorph(
                'reportable',
                'App\Company'
            );
        } else {
            $query = $query->whereHasMorph(
                'reportable',
                'App\Event'
            );
        }
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

    public function moderate(Request $request, Report $report) {
        $report->update([
            'is_moderated' => true
        ]);

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
