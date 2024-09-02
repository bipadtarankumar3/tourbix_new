<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use League\CommonMark\Node\Block\Document;

class EnquiryController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth'); 
        
    }
    public function enquiry(){
        $data['enquiry']= Enquiry::get()->toArray();
        return view('admin.pages.enquiry.enquiry',$data);
    }

    public function enquiry_delete(Request $request,$id){
        $Enquiry = Enquiry::find($id);
        if ($Enquiry) {
            $Enquiry->delete();
            $message = 'Enquiry deleted successfully';
        } else {
            $message = 'Enquiry not found';
        }

        $request->session()->flash('success',  $message);
        return redirect()->back();
    }

}
