<?php

namespace App\Services;

use App\Http\Resources\WorksheetResource;
use App\Models\Request;
use App\Models\Worksheet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class WorksheetService extends BaseService
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

        $perpage = $request->perpage ?? 10;

        return WorksheetResource::collection($worksheet->paginate(((int) $perpage)));
    }

    public function getRequest($id, $type)
    {
        if ($type < 1 || $type > 5) {
            return $this->errorResponse("This request type does not exist !", Response::HTTP_NOT_FOUND);
        }

        $worksheet = $this->model->where('id', $id)
            ->where('member_id', Auth::id())
            ->first();

        if ($this->model->find($id)) {
            if ($worksheet) {
                $findRequest = $this->findRequest($worksheet->work_date, $type);

                return  $this->successResponse((!$findRequest) ? $worksheet : $findRequest);
            }

            return $this->errorResponse("You cannot access other people's worksheets !", Response::HTTP_FORBIDDEN);
        }

        return $this->errorResponse("This worksheet does not exist !", Response::HTTP_NOT_FOUND);
    }

    public function findRequest($date, $type)
    {
        return Request::where('member_id', Auth::user()->id)
            ->where('request_for_date', $date)
            ->where('request_type', $type)
            ->first();
    }
}
