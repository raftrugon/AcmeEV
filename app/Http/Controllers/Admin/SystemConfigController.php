<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\InscriptionRepo;
use App\Repositories\SystemConfigRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SystemConfigController extends Controller
{

    protected $systemConfigRepo;
    protected $inscriptionRepo;

    public function __construct(SystemConfigRepo $systemConfigRepo, InscriptionRepo $inscriptionRepo){
        $this->systemConfigRepo = $systemConfigRepo;
        $this->inscriptionRepo = $inscriptionRepo;
    }


    public function getEditSystemConfig(){
        $system_config = $this->systemConfigRepo->getSystemConfig();
        return view('site.admin.systemConfig.edit', compact('system_config'));
    }

    public function postSaveSystemConfig(Request $request){
        $validator = Validator::make($request->all(),[
            'max_summons_number'=>'required|integer|min:1',
            'max_annual_summons_number'=>'required|integer|min:1',
            'secretariat_open_time'=>'required|date_format:H:i:s',
            'secretariat_close_time'=>'required|date_format:H:i:s|after:secretariat_open_time',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('error',__('systemConfig.error'));
        }

        DB::beginTransaction();
        try {
            $systemConfig = array(
                'max_summons_number' => $request->input('max_summons_number'),
                'max_annual_summons_number' => $request->input('max_annual_summons_number'),
                'secretariat_open_time' => $request->input('secretariat_open_time'),
                'secretariat_close_time' => $request->input('secretariat_close_time'),
            );

            $systemConfigDB = $this->systemConfigRepo->findOrFail($request->input('id'));
            $this->systemConfigRepo->update($systemConfigDB, $systemConfig);

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return redirect()->action('Admin\SystemConfigController@getEditSystemConfig')->with('success',__('systemConfig.success'));
    }

    public function postInscriptionBatch(){
        try {
            $this->inscriptionRepo->inscriptionBatch();
            return 'true';
        }catch(\Exception $e){
            return 'false';
        }catch(\Throwable $t){
            return 'false';
        }
    }
}
