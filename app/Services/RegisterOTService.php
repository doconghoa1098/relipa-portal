<?php

namespace App\Services;

use App\Models\Request;
use App\Models\Worksheet;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RegisterOTService extends BaseService
{
    public function getModel()
    {
        return Request::class;
    }

    public function create($request)
    {
        $valueRequest = array_map('trim', $request->all());
        $valueRequest['member_id'] = Auth::user()->id;
        $valueRequest['request_type'] = 5;

        $request = $this->model->where('request_for_date', 'like', $valueRequest['request_for_date'])
            ->where('member_id', Auth::user()->id)
            ->where('request_type', 5)
            ->doesntExist();

        if ($request) {
            $this->store($valueRequest);

            return $this->successResponse(null, "Create request overtime successfully !");
        }

        return $this->errorResponse("Only 1 request of the same type is allowed per day !", Response::HTTP_UNAUTHORIZED);
    }

    public function updateOvertime($request)
    {
        $valueRequest = array_map('trim', $request->all());

        $request = $this->model->where('request_for_date', 'like', $valueRequest['request_for_date'])
            ->where('member_id', Auth::user()->id)
            ->where('request_type', 5)
            ->whereIn('status', [-1, 1, 2])
            ->doesntExist();

        if ($request) {
            $updateRequest = $this->model->where('request_for_date', 'like', $valueRequest['request_for_date'])
                ->where('member_id', Auth::user()->id)
                ->where('request_type', 5)
                ->first();

            if ($updateRequest) {
                $updateRequest->fill($valueRequest);
                $updateRequest->save();

                return $this->successResponse(null, "Update request overtime successfully !");
            }

            return $this->errorResponse("Request overtime does not exist", Response::HTTP_NOT_FOUND);
        }

        return $this->errorResponse("Your request is in confirmed or approved status, so it cannot be edited !", Response::HTTP_UNAUTHORIZED);
    }
}
