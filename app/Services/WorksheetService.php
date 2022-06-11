<?php

namespace App\Services;

use App\Models\Worksheet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class WorkSheetService extends BaseService
{
    public function getModel()
    {
        return Worksheet::class;
    }

    public function list($request, $member_id)
    {
        $worksheet = $this->model->where('member_id', $member_id);

        if (trim((string)$request->start_date) !== "") {
            $worksheet = $worksheet->where('work_date', '>=', $request->start_date ?? "");
        }

        if (trim((string)$request->end_date) !== "") {
            $worksheet = $worksheet->where('work_date', '<=', $request->end_date ?? "");
        }

        if (trim((string)$request->work_date) !== "") {
            $worksheet = $worksheet->orderBy('work_date', $request->work_date);
        } else {
            $worksheet = $worksheet->orderBy('work_date', 'desc');
        }

        return $worksheet->paginate(15);
    }

    public function getRequest($request)
    {
    }
}
