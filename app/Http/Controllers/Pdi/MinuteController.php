<?php

namespace App\Http\Controllers\Pdi;

use App\Http\Controllers\Controller;
use App\Minute;
use App\Repositories\MinuteRepo;
use App\User;
use Illuminate\Http\Request;

class MinuteController extends Controller
{

    protected $minuteRepo;

    public function __construct(MinuteRepo $minuteRepo)
    {
        $this->minuteRepo = $minuteRepo;
    }

    public function getMinutesForStudent(User $user)
    {
        try {
            $academic_years = $this->minuteRepo->getMinutesForStudent($user,0)->get()->groupBy('academic_year');
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }

        return view('site.pas.student-minutes', compact('academic_years'));
    }

    public function updateMinutes(Request $request)
    {
        try {
            $ids = $request->input('ids');
            $qualifications = $request->input('qualifications');
            for ($i = 0; $i < count($ids); $i++) {
                $minute = Minute::where('id', $ids[$i])->first();
                $minute->setQualification($qualifications[$i]);
                $this->minuteRepo->updateWithoutData($minute);
            }
        } catch (\Exception $e) {
            return 'false';
        } catch (\Throwable $t) {
            return 'false';
        }

        return 'true';
    }
}