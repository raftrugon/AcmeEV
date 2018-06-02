<?php

namespace App\Http\Controllers\Pdi;


use App\Http\Controllers\Controller;
use App\Repositories\AnnouncementRepo;
use App\SubjectInstance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{

    protected $announcementRepo;

    public function __construct(AnnouncementRepo $announcementRepo){
        $this->announcementRepo = $announcementRepo;
    }

    public function getCreateAnnouncement(SubjectInstance $subjectInstance){
        $subject_instance_id = $subjectInstance->getId();
        return view('site.pdi.announcement.edit', compact('subject_instance_id'));
    }

    public function postSaveAnnouncement(Request $request){
        $validator = Validator::make($request->all(),[
            'title'=>'required|max:40',
            'body'=>'required|max:500',
            'subject_instance_id'=>'required|integer'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $announcement = array(
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'creation_moment' => Carbon::now(),
                'subject_instance_id' => $request->input('subject_instance_id')
            );

            $this->announcementRepo->create($announcement);

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error',__('global.post.error'));
        }catch(\Throwable $t){
            DB::rollBack();
            return redirect()->back()->with('error',__('global.post.error'));
        }

        $subject_instance_id = $request->input('subject_instance_id');
        return redirect()->action('Logged\AnnouncementController@getAllBySubjectInstance', compact('subject_instance_id'));
    }

}
