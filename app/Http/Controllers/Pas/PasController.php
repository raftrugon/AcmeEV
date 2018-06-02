<?php

namespace App\Http\Controllers\Pas;

use App\Repositories\DegreeRepo;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasController extends Controller
{
    protected $degreeRepo;

    public function __construct(DegreeRepo $degreeRepo)
    {
        $this->degreeRepo = $degreeRepo;
    }

    public function getPrintAllLists(Request $request)
    {
        try {
            $degrees = $this->degreeRepo->getDegreesWithAcceptedRequests(explode(',', $request->input('degree_ids')));
            return PDF::loadView('site.pas.pdf.inscription-list', compact('degrees'))->download('inscriptions.pdf');
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }
    }

    public function getDashboard()
    {
        return view('site.pas.dashboard');
    }


}
