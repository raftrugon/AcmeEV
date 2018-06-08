<?php

namespace App\Http\Controllers;

use App\Degree;
use App\Repositories\DegreeRepo;
use App\Repositories\SystemConfigRepo;
use App\Repositories\UserRepo;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DegreeController extends Controller
{

    protected $degreeRepo;
    protected $systemConfigRepo;

    public function __construct(DegreeRepo $degreeRepo, SystemConfigRepo $systemConfigRepo)
    {
        $this->degreeRepo = $degreeRepo;
        $this->systemConfigRepo = $systemConfigRepo;
    }

    public function getAllButSelected(Request $request)
    {
        try {
            return $this->degreeRepo->getAllButSelected($request->input('ids'))->get();
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }
    }

    public function getAll()
    {
        try {
            $degrees = Degree::where('deleted', 0)->get();
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }

        return view('site.degree.all', compact('degrees'));

    }

    public function getNewDegree()
    {
        return view('site.degree.create-edit');
    }

    public function getEditDegree(Degree $degree)
    {
        return view('site.degree.create-edit', compact('degree'));
    }

    public function postSaveDegree(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:1',
            'new_students_limit' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $degree = array(
                'name' => $request->input('name'),
                'new_students_limit' => $request->input('new_students_limit'),
            );

            if ($request->input('id')) {
                $degreeBD = $this->degreeRepo->findOrFail($request->input('id'));
                $this->degreeRepo->update($degreeBD, $degree);
            } else {
                //Random Code Generation (ABC123456)
                $random = $random_string = chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(48, 57)) . chr(rand(48, 57)) . chr(rand(48, 57)) . chr(rand(48, 57)) . chr(rand(48, 57)) . chr(rand(48, 57));
                $degree['code'] = $random;
                $this->degreeRepo->create($degree);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('global.post.error'));
        } catch (\Throwable $t) {
            DB::rollBack();
            return redirect()->back()->with('error', __('global.post.error'));
        }

        return redirect()->action('DegreeController@getAll');
    }

    public function displayDegree(Degree $degree)
    {
        try {
            $school_years = Subject::where('degree_id', $degree->getId())->orderBy('school_year')->get()->groupBy('school_year');
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }

        return view('site.degree.display', compact('degree', 'school_years'));
    }


}
