<?php

namespace App\Http\Controllers\superadmin;
// use Illuminate\Http\RedirectResponse;
// use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\MasterUser;
use App\Http\Controllers\Controller;

class BusinessDetailController extends Controller
{
    public function index(): View
    {
        //
       
        $MasterUser = MasterUser::all();
        // dd($MasterUser);
        return view('superadmin.businessdetails.index')->with('MasterUser',$MasterUser);
    }

}
