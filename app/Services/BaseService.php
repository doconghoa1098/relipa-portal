<?php

namespace App\Services;

use App\Models\MemberRequestQuota;
use App\Traits\UploadableTrait;
use App\Traits\ResfulResourceTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

abstract class BaseService
{
    use UploadableTrait, ResfulResourceTrait;

    protected $model;

    public function __construct()
    {
        return $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function get()
    {
        return $this->model->latest()->get();
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($values = [])
    {
        $this->model->fill($values);

        return $this->model->save();
    }

    public function update($id, $value)
    {
        $this->findOrFail($id);
        $this->model->fill($value);

        return $this->model->save();
    }

    public function delete($id)
    {
        $this->findOrFail($id);

        return $this->model->delete();
    }

    public function storeMemberRequestQuota($value = [])
    {
        $memberRequestQuota = new MemberRequestQuota();
        $memberRequestQuota->fill($value);

        return $memberRequestQuota->save();
    }

    public function checkRequestQuota($date)
    {
        $dateRequest = Carbon::createFromFormat('Y-m-d', $date)->format('Y-m');
        $checkExistRequestQuota = MemberRequestQuota::where('month', $dateRequest);

        if ($checkExistRequestQuota->doesntExist()) {
            $value = [
                'member_id' => Auth::user()->id,
                'month' => $dateRequest
            ];

            $this->storeMemberRequestQuota($value);
        }

        return $checkExistRequestQuota->where('remain', '>', 0)->first();
    }
}
