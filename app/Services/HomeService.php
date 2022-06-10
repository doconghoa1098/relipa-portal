<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Notification;
use App\Services\BaseService;
use Illuminate\Http\Request;


class HomeService extends BaseService
{
    public function getModel()
    {
        return Notification::class;
    }

    public function home($request)
    {
        $limit = $request->get('limit') ?? config('common.default_page_size');
        $orderBy = $request->get('sort');
        $divisionId = Member::where('id', auth()->id())->with('divisions')->first();
        $divisionId = $divisionId->divisions->first()->id;
        $query = Notification::whereJsonContains('published_to', [$divisionId])
            ->orwhereJsonContains('published_to', ["all"]);
        $query->created_by = Notification::find(auth()->id())->authorInfo->full_name;

        if ($orderBy) {
            $query->orderBy('id', $orderBy);
        }

        return $query->paginate($limit);
    }
}
