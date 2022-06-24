<?php

namespace App\Services;

use App\Models\LeaveQuota;
use Illuminate\Support\Facades\Auth;
use App\Models\Request;
use App\Models\Worksheet;
use Carbon\Carbon;
use Illuminate\Http\Response;

class RegisterLeaveService extends BaseService
{
    public function getModel()
    {
        return Request::class;
    }

    public function createLeave($request)
    {
        $valueRequest = array_map('trim', $request->all());
        $valueRequest['member_id'] = Auth::user()->id;

        $request = $this->model->where('request_for_date', 'like', $valueRequest['request_for_date'])
            ->where('member_id', Auth::user()->id)
            ->whereIn('request_type', [2, 3])
            ->doesntExist();
        if ($request) {
            $this->store($valueRequest);

            return $this->successResponse(null, "Create request leave successfully !");
        }

        return $this->errorResponse("Only 1 request of the same type is allowed per day !", Response::HTTP_UNAUTHORIZED);
    }

    public function updateLeave($request)
    {
        $valueRequest = array_map('trim', $request->all());

        $request = $this->model->where('request_for_date', 'like', $valueRequest['request_for_date'])
            ->where('member_id', Auth::user()->id)
            ->whereIn('request_type', [2, 3])
            ->whereIn('status', [-1, 1, 2])
            ->doesntExist();

        if ($request) {
            $updateRequest = $this->model->where('request_for_date', 'like', $valueRequest['request_for_date'])
                ->where('member_id', Auth::user()->id)
                ->whereIn('request_type', [2, 3])
                ->first();

            if ($updateRequest) {
                $updateRequest->fill($valueRequest);
                $updateRequest->save();

                return $this->successResponse(null, "Update request leave successfully !");
            }

            return $this->errorResponse("Request leave does not exist", Response::HTTP_NOT_FOUND);
        }

        return $this->errorResponse("Your request is in confirmed or approved status, so it cannot be edited !", Response::HTTP_UNAUTHORIZED);
    }
}
