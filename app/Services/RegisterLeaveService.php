<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Request;
use App\Models\Worksheet;
use Carbon\Carbon;

class RegisterLeaveService extends BaseService
{
    public function getModel()
    {
        return Request::class;
    }

    public function workSheet($id)
    {
        return  Worksheet::where('member_id', Auth::id())->find($id);
    }

    public function getForm($id)
    {
        $workSheet = $this->workSheet($id);
        if (empty($workSheet)) {
            return [];
        };
        $workDate = $workSheet->work_date;
        $view = $this->model->where('request_for_date', $workDate)
            ->where('request_type', 2)
            ->orWhere('request_type', 3)
            ->first() ?? (object) [];

        $view->workDate = $workDate->format('Y-m-d');
        $view->checkInWorkSheet = $workSheet->checkin_original->format("H:i");
        $view->checkOutWorkSheet = $workSheet->checkout_original->format("H:i");
        $view->workTime = $workSheet->late->format("H:i");
        $view->lackTime = $workSheet->early->format("H:i");
        $view->in_office = $workSheet->in_office->format("H:i");
        return $view;
    }

    public function create($id, $request)
    {
        $worksheet = $this->getForm($id);
        if (empty($worksheet)) {
            return '403_FORBIDDEN';
        };
        $requestOfDay = $this->model->where('request_for_date', $worksheet->workDate)->pluck('request_type')->toArray();

        // $leave_quota =
        if (in_array(2, $requestOfDay) || in_array(3, $requestOfDay) ) {
            return [];
        }

        $data = [
            'member_id' => Auth::id(),
            'request_type' => $request->request_type,
            'request_for_date' =>  $worksheet->workDate,
            'checkin' => strtotime(  $worksheet->workDate . $worksheet->checkinWorkSheet),
            'checkout' => strtotime(  $worksheet->workDate . $worksheet->checkoutWorkSheet),
            'reason' => $request->reason,
            'range' => $request->range,
            'leave_all_day' => $request->leave_all_day,
        ];



        return $this->store($data);
    }

    public function updateRegisterLeave($id, $request)
    {
        $workSheet = $this->getForm($id);
        if (empty($workSheet)) {
            return '403_FORBIDDEN';
        };

        $viewform = $this->model->where('request_for_date', $workSheet->workDate)
                                ->where('request_type', 1)
                                ->first();

        if (isset($viewform->status) && $viewform->status == 0) {

            $data = [
                'checkin' => strtotime($viewform->request_for_date . $request->checkin),
                'checkout' => strtotime($viewform->request_for_date . $request->checkout),
                'special_reason' => $request->special_reason,
                'reason' => $request->reason,
            ];

            return $viewform->fill($data)->save();
        }
        return [];
    }
}
