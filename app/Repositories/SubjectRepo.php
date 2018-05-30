<?php

namespace App\Repositories;

use App\ControlCheck;
use App\Folder;
use App\Subject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SubjectRepo extends BaseRepo {

    public function __construct()
    {

    }

    public function getModel() {
        return new Subject;
    }

    public function getSubjectsForTeacher(){
        $subjects = Subject::join('subject_instances','subjects.id','=','subject_instances.subject_id')
            ->leftJoin('groups','subject_instances.id','=','groups.subject_instance_id')
            ->where('subject_instances.academic_year',Carbon::now()->year)
            ->where(function ($query){
                $query->where('groups.theory_lecturer_id',Auth::id())
                    ->orWhere('groups.practice_lecturer_id',Auth::id())
                    ->orWhere('subjects.coordinator_id',Auth::id());
            })
            ->select('subjects.*')
            ->groupBy('subjects.id');
        return $subjects;
    }

    public function getFoldersAndFiles($subjectId,$folderId){
        $folders = Folder::join('subject_instances','folders.subject_instance_id','=','subject_instances.id')
            ->where('subject_instances.subject_id',$subjectId)->where('parent_id',$folderId)->orderBy('folders.updated_at','desc')->select('folders.*')->get();
        $folderId != null ? $files = Folder::findOrFail($folderId)->getFiles()->orderBy('updated_at','desc')->get() : $files = array();
        return compact('files','folders');
    }

    public function getMyNonPassedSubjects(){

        $passed_subjects_ids = Subject::join('subject_instances', 'subjects.id', '=', 'subject_instances.subject_id')       //Une a subjects la tabla subject_instances
        ->join('enrollments', 'subject_instances.id', '=', 'enrollments.subject_instance_id')                               //Une con la tabla enrollments
        ->where('enrollments.user_id', Auth::id())                                                                          //Filtra a las asignaturas con enrollments del estudiante
        ->join('minutes', 'enrollments.id', '=', 'minutes.enrollment_id')                                                   //Une con la tabla minutes
        ->where('minutes.qualification', '>=', 5)                                                                           //Filtra a las asignaturas con enrollments con minutes aprobados
        ->select('subjects.*')->distinct()->get()->pluck('id')->toArray();                                                  //Extrae los IDs de esas asignaturas

        $non_passed_subjects = Subject::join('subject_instances', 'subjects.id', '=', 'subject_instances.subject_id')       //Une a subjects la tabla subject_instances
        ->join('enrollments', 'subject_instances.id', '=', 'enrollments.subject_instance_id')                               //Une con la tabla enrollments
        ->where('subjects.degree_id', Auth::user()->getDegree->getId())                                                                          //Filtra a las asignaturas con enrollments del estudiante
        ->whereNotIn('subjects.id', $passed_subjects_ids)                                                                   //Elimina las aprobadas
        ->select('subjects.*')->distinct();

        return $non_passed_subjects;
    }
}