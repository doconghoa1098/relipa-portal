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
        $valueRequest['request_type'] = $request->request_type;
        $valueRequest['checkin'] = strtotime($request->request_for_date . $request->checkin);
        $valueRequest['checkout'] = strtotime($request->request_for_date . $request->checkout);

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
            ->whereIn('status', [1, 2])
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


    public function storeLeaveQuota($value = [])
    {
        $LeaveQuota = new LeaveQuota();
        $LeaveQuota->fill($value);

        return $LeaveQuota->save();
    }

    public function checkLeaveQuota($request)
    {
        dd($request);
        $date = $request['request_for_date'];
        $dateRequest = Carbon::createFromFormat('Y-m-d', $date)->format('Y');
        $checkExistRequestQuota = LeaveQuota::where('year', $dateRequest);

        if ($checkExistRequestQuota->doesntExist()) {
            $value = [
                'member_id' => Auth::user()->id,
                'year' => $dateRequest,
                'paid_leave' => $request->paid_leave,
                'unpaid_leave' => $request->unpaid_leave,
                'remain' => $request->remain,
            ];

            $this->storeLeaveQuota($value);
        }

        return $checkExistRequestQuota->where('remain', '>', 0)->first();
    }
}
