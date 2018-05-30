<?php

namespace App\Repositories;

use App\Inscription;
use App\Request;
use App\SystemConfig;
use App\User;
use Illuminate\Support\Facades\DB;

class UserRepo extends BaseRepo
{
    protected $subjectRepo;
    protected $enrollmentRepo;
    protected $inscriptionRepo;
    protected $requestRepo;

    public function __construct(SubjectRepo $subjectRepo, EnrollmentRepo $enrollmentRepo, InscriptionRepo $inscriptionRepo, RequestRepo $requestRepo)
    {
        $this->subjectRepo = $subjectRepo;
        $this->enrollmentRepo = $enrollmentRepo;
        $this->inscriptionRepo = $inscriptionRepo;
        $this->requestRepo = $requestRepo;
    }

    public function getModel()
    {
        return new User;
    }

    public function isUserFinished()
    {
        try {
            return $this->subjectRepo->getMyNonPassedSubjects()->count() == 0;
        } catch (\Exception $e) {
            return null;
        } catch (\Throwable $t) {
            return null;
        }
    }

    public function isUserEnrolledThisYear()
    {
        try {
            return !($this->enrollmentRepo->getMyActualEnrollments()->count() == 0);
        } catch (\Exception $e) {
            return null;
        } catch (\Throwable $t) {
            return null;
        }
    }

    public function canUserEnroll()
    {
        try {
            return !$this->isUserEnrolledThisYear() && !$this->isUserFinished();
        } catch (\Exception $e) {
            return false;
        } catch (\Throwable $t) {
            return false;
        }
    }

    public function createBatchFromInscriptions()
    {
        //Accepted inscriptions with accepted requests
        $inscriptions = Inscription::join('requests', 'inscriptions.id', '=', 'requests.inscription_id')
            ->join('degrees', 'requests.degree_id', '=', 'degrees.id')
            ->where('requests.accepted', 1)
            ->where('inscriptions.agreed', 1)
            ->select('inscriptions.*','degrees.id as degree_id')
            ->get();


        try {
            DB::beginTransaction();

            foreach ($inscriptions as $inscription){
                try {

                    //Email is generated with the first part of the users personal email
                    $split_email = explode('@',$inscription->email);


                    //Student creation
                    $student_array = array(
                        'name' => $inscription->name,
                        'surname' => $inscription->surname,
                        'password' => $inscription->password,
                        'id_number' => $inscription->id_number,
                        'address' => $inscription->address,
                        'phone_number' => $inscription->phone_number,
                        'personal_email' => $inscription->email,
                        'degree_id' => $inscription->degree_id,

                        'email' => $split_email[0].'@alum.us.es',
                    );

                    $student = $this->create($student_array);


                    //Roles and permissions
                    $student->assignRole('student');
                    $student->givePermissionTo('new');



                }catch(\Exception $e){
                    DB::rollBack();
                    throw $e;
                }
            }



            //Soft delete de las inscriptions
            $all_inscriptions = Inscription::all();
            foreach ($all_inscriptions as $inscription){
                $this->inscriptionRepo->delete($inscription);
            }

            //Soft delete de las requests
            $all_requests = Request::all();
            foreach ($all_requests as $request){
                $this->requestRepo->delete($request);
            }


            DB::commit();


            return true;

        }catch(\Exception $e){
            DB::rollBack();
            return false;
        }



    }



}