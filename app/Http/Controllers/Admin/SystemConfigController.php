<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\InscriptionRepo;
use App\Repositories\SystemConfigRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SystemConfigController extends Controller
{

    protected $systemConfigRepo;
    protected $inscriptionRepo;

    public function __construct(SystemConfigRepo $systemConfigRepo, InscriptionRepo $inscriptionRepo)
    {
        $this->systemConfigRepo = $systemConfigRepo;
        $this->inscriptionRepo = $inscriptionRepo;
    }


    public function getEditSystemConfig()
    {
        try {
            $system_config = $this->systemConfigRepo->getSystemConfig();
            $actual_state = $system_config->getActualState();
            $next_state = $actual_state + 1;
            if ($next_state > 8)
                $next_state = 0;

            $state_actual_title = 'systemConfig.state.' . $actual_state . '.title';
            $state_actual_body = 'systemConfig.state.' . $actual_state . '.body';
            $state_next_title = 'systemConfig.state.' . $next_state . '.title';
            $state_next_body = 'systemConfig.state.' . $next_state . '.body';
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }

        return view('site.admin.systemConfig.edit', compact('system_config', 'state_actual_title', 'state_actual_body', 'state_next_title', 'state_next_body'), $this->systemConfigRepo->getDashboard());
    }

    public function postSaveSystemConfig(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'max_students_per_group' => 'required|integer|min:1',
            'building_open_time' => 'required|date_format:H:i:s',
            'building_close_time' => 'required|date_format:H:i:s|after:building_open_time',
            'name_en'=>'required',
            'name_es'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', __('systemConfig.error'));
        }

        DB::beginTransaction();
        try {
            $systemConfig = array(
                'max_students_per_group' => $request->input('max_students_per_group'),
                'building_open_time' => $request->input('building_open_time'),
                'building_close_time' => $request->input('building_close_time'),
                'name_en'=>$request->input('name_en'),
                'name_es'=>$request->input('name_es'),
            );

            if($request->file('icon')) {
                $iconUrl = Storage::url(Storage::putFile('/',$request->file('icon')));
                $systemConfig['icon'] = $iconUrl;
            }
            if($request->file('banner')) {
                $bannerUrl = Storage::url(Storage::putFile('/',$request->file('banner')));
                $systemConfig['banner'] = $bannerUrl;
            }

            $systemConfigDB = $this->systemConfigRepo->findOrFail($request->input('id'));
            $this->systemConfigRepo->update($systemConfigDB, $systemConfig);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('global.post.error'));
        } catch (\Throwable $t) {
            DB::rollBack();
            return redirect()->back()->with('error', __('global.post.error'));
        }

        return redirect()->action('Admin\SystemConfigController@getEditSystemConfig')->with('success', __('systemConfig.success'));
    }


    public function getIncrementStateMachine()
    {
        try {
            $this->systemConfigRepo->incrementStateMachine();
            return redirect()->back()->with('success', __('systemConfig.increment.success'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('systemConfig.increment.error'));
        } catch (\Throwable $t) {
            return redirect()->back()->with('error', __('systemConfig.increment.error'));
        }
    }


}
