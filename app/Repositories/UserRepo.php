<?php

namespace App\Repositories;

use App\Inscription;
use App\Jobs\EnviarMail;
use App\Request;
use App\SystemConfig;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;

class UserRepo extends BaseRepo
{
    use DispatchesJobs;

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

                    //Email is generated with the first part of the users name and surname (it checks for matches and adds a number to the end)
                    $newEmailTxt = strtolower(substr($inscription->name,0,3)).strtolower(substr($inscription->surname,0,3));
                    $i=1;
                    $newEmail = $newEmailTxt;
                    while(User::where('email',$newEmail.'@alum.us.es')->count() > 0){
                        $newEmail = $newEmailTxt.$i;
                        $i++;
                    }
                    $newEmail = $newEmail.'@alum.us.es';


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
                        'email' => $newEmail,
                    );

                    $student = $this->create($student_array);

                    $nombre = $inscription->name. ' '.$inscription->surname;

                    $contenido=\View::make('mails.usercreation', compact('newEmail', 'nombre'))->render();

                    $datos=[$inscription->email,
                        $nombre,
                        'admisiones@us.es',
                        SystemConfig::first()->getNameEs(),
                        'Admisión '.SystemConfig::first()->getNameEs(),
                        $contenido,
                        null,
                        null];

                    $mail=new EnviarMail($datos);
                    $this->dispatch($mail);


                    //Roles and permissions
                    $student->assignRole('student');
                    $student->givePermissionTo('new');



                }catch(\Exception $e){
                    DB::rollBack();
                    throw $e;
                } catch(\Throwable $t){
                    DB::rollBack();
                    throw $t;
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
            throw $e;
        } catch(\Throwable $t){
            DB::rollBack();
            throw $t;
        }

    }

    public function getStudentsWithStatusZeroMinutes() {
        return User
            ::join('enrollments','enrollments.user_id','=','users.id')
            ->join('minutes','minutes.enrollment_id','=','enrollments.id')
            ->where('minutes.status','0')
            ->select('users.*')
            ->distinct('users.id');
    }
    public function getDataTable($request){
        $query = $this->getModel()
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->join('model_has_permissions','users.id','=','model_has_permissions.model_id')
                ->join('permissions','model_has_permissions.permission_id','=','permissions.id')
                ->groupBy('users.id')
                ->select('users.*',DB::raw('CONCAT(users.name," ",users.surname) as full_name'),DB::raw('GROUP_CONCAT(distinct(roles.name)) as roles'),DB::raw('GROUP_CONCAT(distinct(permissions.name)) as permissions'));

        if($request->input('full_name')){
            $query = $query->where(function($sub) use($request){
                $sub->where('users.name','like','%'.$request->input('full_name').'%')
                    ->orWhere('users.surname','like','%'.$request->input('full_name').'%');
            });
        }
        if($request->input('email')){
            $query = $query->where('email','like','%'.$request->input('email').'%');
        }
        if($request->input('personal_email')){
            $query = $query->where('personal_email','like','%'.$request->input('personal_email').'%');
        }
        if($request->input('address')){
            $query = $query->where('address','like','%'.$request->input('address').'%');
        }
        if($request->input('phone_number')){
            $query = $query->where('phone_number','like','%'.$request->input('phone_number').'%');
        }
        if($request->input('id_number')){
            $query = $query->where('id_number','like','%'.$request->input('id_number').'%');
        }
        if($request->input('roles')){
            $query = $query->whereIn('roles.id',$request->input('roles'));
        }
        if($request->input('permissions')){
            $query = $query->whereIn('permissions.id',$request->input('permissions'));
        }

        return $query;
    }



}