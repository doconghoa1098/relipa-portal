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
       // return Worksheet::where('member_id',Auth::id())->findOrFail($id);
        return  Worksheet::where('member_id', Auth::id())->find($id);
    }

    public function getForm($id)
    {

        $workSheet = $this->workSheet($id);
        if (empty($workSheet)) {
            return [];
        };
        $in_office = $workSheet->in_office;
        $actual_OT = gmdate("H:i",(strtotime($in_office) - strtotime('10:00')));
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

        $worksheet = $this->getForm($id);
        if (empty($worksheet)) {
            return '403_FORBIDDEN';
        };
        $in_office = $this->workSheet($id)->in_office;
        $actual_OT = gmdate("H:i",(strtotime($in_office) - strtotime('10:00')));
        $requestOfDay = $this->model->where('request_for_date', $worksheet->workDate)->pluck('request_type')->toArray();
        if (in_array(5, $requestOfDay)) {
            return [];
        }else if($request->request_ot_time > $actual_OT){
            return 'validator';
        }

        $data = [
            'member_id' => Auth::user()->id,
            'request_type' => 5,
            'request_for_date' => $worksheet->workDate,
            'checkin' => strtotime(  $worksheet->workDate . $worksheet->checkinWorkSheet),
            'checkout' => strtotime(  $worksheet->workDate . $worksheet->checkoutWorkSheet),
            'reason' => $request->reason,
            'request_ot_time' => $request->request_ot_time,
        ];

        // return $data;
        return $this->model->fill($data)->save();
    }

    public function update($request, $id)
    {
        $worksheet = $this->getForm($id);
        if (empty($worksheet)) {
            return '403_FORBIDDEN';
        };

        $view = $this->model->where('request_for_date', $worksheet->workDate)
        ->where('request_type', 5)
        ->first();

        $in_office = $this->workSheet($id)->in_office;
        $actual_OT = gmdate("H:i",(strtotime($in_office) - strtotime('10:00')));
        if (isset($view->status) && $view->status == 0) {
            if($request->request_ot_time > $actual_OT){
                return 'validator';
            }
            $data = [
                'request_ot_time' => $request->request_ot_time,
                'reason' => $request->reason,
            ];
            return $this->findOrFail($view->id)->fill($data)->save();
            // return $this->update($viewform->id, $data);
        }
        return [];
    }
}
