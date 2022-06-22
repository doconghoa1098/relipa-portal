<?php

namespace App\Services;

use App\Http\Resources\NotificationResource;
use App\Models\Member;
use App\Models\Notification;
use App\Services\BaseService;
use Symfony\Component\HttpFoundation\Response;

class HomeService extends BaseService
{
    public function getModel()
    {
        return Notification::class;
    }

    public function home($request)
    {
        $divisionId = Member::where('id', auth()->id())->with('divisions')->first();
        $divisionId = $divisionId->divisions->first()->id;
        $query = Notification::whereJsonContains('published_to', [$divisionId])
            ->orwhereJsonContains('published_to', ["all"]);

        $query->orderBy('published_date', $request->get('sort') ?? 'desc')
            ->orderBy('subject', $request->get('sortSubject') ?? 'asc')
            ->orderBy('created_by', $request->get('sortAuthor') ?? 'desc')
            ->orderBy('published_to', $request->get('sortTo') ?? 'asc');
        $perpage = $request->perpage ?? 10;

        return NotificationResource::collection($query->paginate(((int) $perpage)));
    }
    public function showNotice($id)
    {
        $member = Member::where('id', auth()->id())->with('divisions')->first();
        $divisionName = $member->divisions->first()->division_name;
        $notice = Notification::findOrFail($id);
        $publishedTo = $notice->published_to;

        $array = [];
        if ($publishedTo != '["all"]') {
            foreach ($publishedTo as $val) {
                array_push($array, $val->division_name);
            }
        }

        if (in_array($divisionName, $array) || $publishedTo == '["all"]') {

            return new NotificationResource($notice);
        } else {

            return $this->errorResponse(trans('message.error'),  Response::HTTP_FORBIDDEN);
        }
    }

    public function updateNotification($id, $request)
    {
        $notice = $this->findOrFail($id);
        $notice->fill($request->all());
        $notice->attachment = $this->uploadNotice($notice, 'attachment', $request);

        return  $notice->update();
    }

    public function isFileAttachment($file)
    {
        $divisionId = Member::where('id', auth()->id())->with('divisions')->first();
        $divisionId = $divisionId->divisions->first()->id;
        $query = Notification::whereJsonContains('published_to', [$divisionId])
            ->orwhereJsonContains('published_to', ["all"])
            ->pluck('attachment')
            ->toArray();

        return in_array($file, $query);
    }
}
