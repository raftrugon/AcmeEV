<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SystemConfigRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SystemConfigController extends Controller
{

    protected $systemConfigRepo;

    public function __construct(SystemConfigRepo $systemConfigRepo){
        $this->systemConfigRepo = $systemConfigRepo;
    }


    public function getEditSystemConfig(){
        $system_config = $this->systemConfigRepo->getSystemConfig();
        return view('site.admin.systemConfig.edit', compact('system_config'));
    }

    public function postSaveSystemConfig(Request $request){
        $validator = Validator::make($request->all(),[
            'max_summons_number'=>'required',
            'max_annual_summons_number'=>'required',
            'secretariat_open_time'=>'required',
            'secretariat_close_time'=>'required',
            'inscriptions_start_date'=>'required',
            'first_provisional_inscr_list_date'=>'required',
            'second_provisional_inscr_list_date'=>'required',
            'final_inscr_list_date'=>'required',
            'enrolment_start_date'=>'required',
            'enrolment_end_date'=>'required',
            'provisional_minutes_date'=>'required',
            'final_minutes_date'=>'required',
            'academic_year_end_date'=>'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $systemConfig = array(
                'max_summons_number' => $request->input('max_summons_number'),
                'max_annual_summons_number' => $request->input('max_annual_summons_number'),
                'secretariat_open_time' => $request->input('secretariat_open_time'),
                'secretariat_close_time' => $request->input('secretariat_close_time'),
                'inscriptions_start_date' => $request->input('inscriptions_start_date'),
                'first_provisional_inscr_list_date' => $request->input('first_provisional_inscr_list_date'),
                'second_provisional_inscr_list_date' => $request->input('second_provisional_inscr_list_date'),
                'final_inscr_list_date' => $request->input('final_inscr_list_date'),
                'enrolment_start_date' => $request->input('enrolment_start_date'),
                'enrolment_end_date' => $request->input('enrolment_end_date'),
                'provisional_minutes_date' => $request->input('provisional_minutes_date'),
                'final_minutes_date' => $request->input('final_minutes_date'),
                'academic_year_end_date' => $request->input('academic_year_end_date'),
            );

            $systemConfigDB = $this->systemConfigRepo->findOrFail($request->input('id'));
            $this->systemConfigRepo->update($systemConfigDB, $systemConfig);

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return redirect()->action('Admin\SystemConfigController@getEditSystemConfig');
    }
}
