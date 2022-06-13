<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorksheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $member_id = Member::pluck('id')->toArray();
        // return [
        //     'member_id' => $this->faker->randomElement($member_id),
        //     'work_date' => $this->faker->date(),
        //     'checkin' => $this->faker->date(),
        //     'checkin_original' => $this->faker->date(),
        //     'checkout'=> $this->faker->date(),
        //     'checkout_original' => $this->faker->date(),
        //     'late' => $this->faker->date('H:i'),
        //     'early' => $this->faker->date('H:i'),
        //     'in_office' => $this->faker->date('H:i'),
        //     'ot_time' => $this->faker->date('H:i'),
        //     'work_time' => $this->faker->date(),
        //     'lack' => $this->faker->date('H:i'),
        //     'compensation' => $this->faker->date('H:i'),
        //     'paid_leave' => $this->faker->date('H:i'),
        //     'unpaid_leave' => $this->faker->date('H:i'),
        //     'note' => $this->faker->name(),
        // ];
        static $id = 0;
        static $day = 30;
        static $month = 5;
        static $year = 2022;
        $workDate = $year.'-'.$month.'-'.$day;
        if ($id == 101) {
            $id = 1;
        }
        if ($id == 100) {
            $day++;
        }
        if ($month % 2 != 0) {
            if ($day == 32) {
                $day = 1;
                $month = $month+1;
            }
        } else {
            if ($month == 2) {
                if ($day >= 29) {
                    if (!checkdate($month, $day, $year)) {
                        $day = 1;
                        $month= $month+1;
                    }
                }
            } else {
                if ($day == 31) {
                    $day = 1;
                    $month= $month+1;
                }
            }

        }

        $start = mktime(8, 30, 0, $month, $day, $year);
        $finish = mktime(17, 30, 0, $month, $day, $year);
        $checkin = mktime(8, random_int(5, 59), random_int(0, 59), $month, $day, $year);
        $checkout = mktime(17, random_int(20, 50), random_int(0, 59), $month, $day, $year);
        $inOffice = date('H:i', ($checkout - $checkin));
        $worktime =  (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? date('H:i', strtotime("-1 hour", ($checkout - $checkin))) : null;
        $timework =  date('H:i', strtotime('-1 hour', ($finish-$start)));
        $lack = strtotime($timework) - strtotime($worktime);

        return [
            'member_id' => $id++ < 100 ? $id : $id=1,
            'work_date' => $workDate,
            'checkin' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? date('Y-m-d H:i:s', $start) : null,
            'checkin_original' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? date('Y-m-d H:i:s', $checkin) : null,
            'checkout' =>(date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? date('Y-m-d H:i:s', $finish) : null,
            'checkout_original' =>(date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ?  date('Y-m-d H:i:s', $checkout) : null,
            'late' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun' && ($checkin > $start) ) ? date('H:i', $checkin - $start) : null,
            'early' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun' && ($checkout < $finish) ) ? date('H:i', $finish - $checkout) : null,
            'in_office' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? $inOffice : null,
            'work_time' => $worktime,
            'lack' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? ((strtotime($worktime) < strtotime($timework)) ? date('H:i', $lack) : null) : null,
        ];
    }
}
