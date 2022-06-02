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
        return Worksheet::where('member_id', Auth::id())->findOrFail($id);
    }

    public function getForm($id)
    {
        $workDate = $this->workSheet($id)->work_date;
        $viewform = $this->model->where('request_for_date', $workDate)
            ->where('request_type', 1)
            ->first() ?? (object) [];

        $viewform->workDate = $workDate->format('Y-m-d');
        $viewform->checkInWorkSheet = $this->workSheet($id)->checkin->format('H:i');
        $viewform->checkOutWorkSheet = $this->workSheet($id)->checkout->format('H:i');

        return $viewform;
    }

    public function create($request)
    {
        $requestOfDay = $this->model->where('request_for_date', $request->request_for_date)->pluck('request_type')->toArray();

        if (in_array(1, $requestOfDay)) {
            return [];
        }

        $data = [
            'member_id' => Auth::id(),
            'request_type' => 1,
            'request_for_date' => $request->request_for_date,
            'checkin' => strtotime($request->request_for_date . $request->checkin),
            'checkout' => strtotime($request->request_for_date . $request->checkout),
            'special_reason' => $request->special_reason,
            'reason' => $request->reason,
        ];

        return $this->store($data);
    }

    public function updateRegisterForget($id, $request)
    {
        $viewform = $this->getForm($id);
 
        if (isset($viewform->status) && $viewform->status == 0) {

            $data = [
                'checkin' => strtotime($viewform->request_for_date . $request->checkin),
                'checkout' => strtotime($viewform->request_for_date . $request->checkout),
                'special_reason' => $request->special_reason,
                'reason' => $request->reason,
            ];
            return $this->findOrFail($viewform->id)->fill($data)->save();
            // return $this->update($viewform->id, $data);
        }
        return [];
    }
}
