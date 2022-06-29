<?php

namespace App\Console\Commands;

use App\Models\LeaveQuota;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateLeaveQuota extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CreateLeaveQuota:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create leave quota for member';
    protected $year;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->year = Carbon::createFromFormat('Y-m-d', Carbon::now()->toDateString())->format('Y');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $member = Member::pluck('id')->toArray();

        $checkMonth = LeaveQuota::where('year', 'like', $this->year);

        if ($checkMonth->exists()) {
            $this->updateLeaveQuota($this->year);

            if ($checkMonth->count() < Member::pluck('id')->count()) {
                $memberNew = array_diff($member, $checkMonth->pluck('member_id')->toArray());
                $this->createLeaveQuota($memberNew);
            }
            
            return 0;
        } else {
            return $this->createLeaveQuota($member);
        }
    }

    public function createLeaveQuota($member = [])
    {
        foreach ($member as $member_id) {
            $leaveQuota = new LeaveQuota();
            $leaveQuota->member_id = $member_id;
            $leaveQuota->year = $this->year;
            $leaveQuota->quota = 1;
            $leaveQuota->remain = 1;

            $leaveQuota->save();
        }
    }

    public function updateLeaveQuota($year)
    {
        DB::statement(" UPDATE leave_quotas 
                        SET quota = quota+1 , remain = remain+1 
                        WHERE year = '$year' ");
    }
}
