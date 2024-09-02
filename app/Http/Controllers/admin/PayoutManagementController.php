<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayoutManagementController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth'); 
        
    }
    public function payoutList(){
        $data['title']='Payout Request List';
        return view('admin.pages.payout.list',$data);
    }
}
