<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Request;
use App\Models\Worksheet;
use Carbon\Carbon;

class RegisterForgetService extends BaseService
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
        $viewform = $this->model->where('request_for_date', $workDate)
            ->where('request_type', 1)
            ->first() ?? (object) [];

        $viewform->workDate = $workDate->format('Y-m-d');
        $viewform->checkInWorkSheet = $workSheet->checkin->format('H:i');
        $viewform->checkOutWorkSheet = $workSheet->checkout->format('H:i');

        return $viewform;
    }

    public function create($id, $request)
    {
        $workSheet = $this->getForm($id);
        if (empty($workSheet)) {
            return '403_FORBIDDEN';
        };
        $requestOfDay = $this->model->where('request_for_date', $workSheet->workDate)->pluck('request_type')->toArray();

        if (in_array(1, $requestOfDay)) {
            return [];
        }

        $data = [
            'member_id' => Auth::id(),
            'request_type' => 1,
            'request_for_date' =>  $workSheet->workDate,
            'checkin' => strtotime($request->request_for_date . $request->checkin),
            'checkout' => strtotime($request->request_for_date . $request->checkout),
            'special_reason' => $request->special_reason,
            'reason' => $request->reason,
        ];

        return $this->store($data);
    }

    public function updateRegisterForget($id, $request)
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
