<?php

namespace App\Http\Controllers\Student;

use App\ControlCheckInstance;
use App\Http\Controllers\Controller;
use App\Repositories\ControlCheckInstanceRepo;
use App\Repositories\ControlCheckRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControlCheckController extends Controller
{

    protected $controlCheckRepo;
    protected $controlCheckInstanceRepo;

    public function __construct(ControlCheckRepo $controlCheckRepo, ControlCheckInstanceRepo $controlCheckInstanceRepo)
    {
        $this->controlCheckRepo = $controlCheckRepo;
        $this->controlCheckInstanceRepo = $controlCheckInstanceRepo;
    }

    public function uploadControlCheck(Request $request) {
        try{
            $controlCheckInstance = ControlCheckInstance::findOrFail($request->input('id'));
            $relativeUrl = Storage::putFile('controlChecks/'.$controlCheckInstance->getControlCheck->getId()
                ,$request->file('url'));
            $url = Storage::url($relativeUrl);
            $controlCheckInstance->setURL($url);
            $this->controlCheckInstanceRepo->updateWithoutData($controlCheckInstance);
            return 'true';
        }catch(\Exception $e){
            return 'false';
        }
    }
}