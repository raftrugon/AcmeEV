<?php

namespace App\Repositories;

use App\Inscription;
use App\SystemConfig;
use App\User;

class UserRepo extends BaseRepo
{
    protected $subjectRepo;
    protected $enrollmentRepo;

    public function __construct(SubjectRepo $subjectRepo, EnrollmentRepo $enrollmentRepo)
    {
        $this->subjectRepo = $subjectRepo;
        $this->enrollmentRepo = $enrollmentRepo;
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
        $inscriptions = Inscription::join('requests', 'inscription.id', '=', 'requests.inscription_id')
            ->where('requests.accepted', 1)
            ->select('inscriptions.*')
            ->groupBy('inscriptions.id')
            ->get();
    }

}