<?php

namespace App\Services;

use App\Models\Request;
use App\Models\Worksheet;
use Illuminate\Support\Facades\Auth;

class RegisterOTService extends BaseService
{
    public function getModel()
    {
        return Request::class;
    }

    public function workSheet($id)
    {
        return Worksheet::where('member_id',Auth::id())->findOrFail($id);
    }

    public function getForm($id)
    {

        $in_office = $this->workSheet($id)->in_office;
        $time = explode(':', $in_office);
        $timeDefault = explode(':', "10:00");
        $actualOT = ($time[0] * 3600 + $time[1] * 60) - ($timeDefault[0] * 3600 - $timeDefault[1] * 60);

        if ($actualOT > 0) {
            $actual_OT = date("H:i", $actualOT);
        }

        $workDate = $this->workSheet($id)->work_date;
        $view = $this->model->where('request_for_date', $workDate)
        ->where('request_type', 5)
        ->first() ?? (object) [];

        $view->workDate = $workDate->format('Y-m-d');
        $view->checkinWorkSheet = $this->workSheet($id)->checkin_original->format('H:i');
        $view->checkoutWorkSheet = $this->workSheet($id)->checkout_original->format('H:i');
        $view->actual_OT = $actual_OT;

        return $view;
    }

    public function create($request, $id)
    {

        $in_office = $this->workSheet($id)->in_office;
        $time = explode(':', $in_office);
        $timeDefault = explode(':', "10:00");
        $actualOT = ($time[0] * 3600 + $time[1] * 60) - ($timeDefault[0] * 3600 - $timeDefault[1] * 60);
        if ($actualOT > 0) {
            $actual_OT = date("H:i", $actualOT);
        }

        $requestOfDay = $this->model->where('request_for_date', $request->request_for_date)->pluck('request_type')->toArray();

        if (in_array(5, $requestOfDay) || $request->request_ot_time > $actual_OT) {
            return [];
        }

        $data = [
            'member_id' => Auth::user()->id,
            'request_type' => 5,
            'request_for_date' => $request->request_for_date,
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'reason' => $request->reason,
            'request_ot_time' => $request->request_ot_time,
        ];

        // return $data;
        return $this->model->fill($data)->save();
    }

    public function update($request, $id)
    {
        $view = $this->getForm($id);

        if (isset($view->status) && $view->status == 0) {
            $data = [
                'checkin' => strtotime($view->request_for_date . $request->checkin),
                'checkout' => strtotime($view->request_for_date . $request->checkout),
                'actual_OT' => $view->actual_OT,
                'request_ot_time' => $request->request_ot_time,
                'reason' => $request->reason,
            ];
            return $this->findOrFail($view->id)->fill($data)->save();
            // return $this->update($viewform->id, $data);
        }
        return [];
    }
}
