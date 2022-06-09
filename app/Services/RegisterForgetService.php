<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Request;
use Illuminate\Http\Response;

class RegisterForgetService extends BaseService
{
    public function getModel()
    {
        return Request::class;
    }

    public function create($request)
    {
        $valueRequest = array_map('trim', $request->all());
        $valueRequest['member_id'] = Auth::user()->id;
        $valueRequest['request_type'] = 1;
        $valueRequest['checkin'] = strtotime($request->request_for_date . $request->checkin);
        $valueRequest['checkout'] = strtotime($request->request_for_date . $request->checkout);

        $request = $this->model->where('request_for_date', 'like', $valueRequest['request_for_date'])
            ->where('member_id', Auth::user()->id)
            ->where('request_type', 1)
            ->doesntExist();

        if ($request) {
            $this->store($valueRequest);

            return $this->successResponse(null, "Create request forget check-In/check-Out successfully !");
        }

        return $this->errorResponse("Only 1 request of the same type is allowed per day !", Response::HTTP_UNAUTHORIZED);
    }

    public function updateLateEarly($request)
    {
        $valueRequest = array_map('trim', $request->all());
        $valueRequest['checkin'] = strtotime($request->request_for_date . $request->checkin);
        $valueRequest['checkout'] = strtotime($request->request_for_date . $request->checkout);

        $request = $this->model->where('request_for_date', 'like', $valueRequest['request_for_date'])
            ->where('member_id', Auth::user()->id)
            ->where('request_type', 1)
            ->whereIn('status', [1, 2])
            ->doesntExist();

        if ($request) {
            $updateRequest = $this->model->where('request_for_date', 'like', $valueRequest['request_for_date'])
                ->where('member_id', Auth::user()->id)
                ->where('request_type', 1)
                ->first();

            if ($updateRequest) {
                $updateRequest->fill($valueRequest);
                $updateRequest->save();

                return $this->successResponse(null, "Update request forget check-In/check-Out successfully !");
            }

            return $this->errorResponse("Request forget check-In/check-Out does not exist", Response::HTTP_NOT_FOUND);
        }

        return $this->errorResponse("Your request is in confirmed or approved status, so it cannot be edited !", Response::HTTP_UNAUTHORIZED);
    }
}
