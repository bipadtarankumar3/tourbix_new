<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ExpriencePackage;
use Illuminate\Http\Request;

class ExpriencePackageController extends Controller
{
    public function list()
    {
        $lists = ExpriencePackage::all();
        return view('admin.pages.exprience_packages.list', compact('lists'));
    }

    public function AddAction(Request $request){
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
        ]);

       
            ExpriencePackage::create([
                'title' => $request->title,
                'description' => $request->description,
                'amount' => $request->amount,
            ]);
            return redirect('admin/experiance-package/list')->with('success', 'Experience Package created successfully.');
       
    }
    public function updateAction(Request $request,$id){
      
            ExpriencePackage::where('id',$id)->Update([
                'title' => $request->title,
                'description' => $request->description,
                'amount' => $request->amount,
            ]);
            return redirect()->with('success', 'Experience Package created successfully.');
     
    }

    public function edit($id)
    {
        $lists = ExpriencePackage::all();
        $package = ExpriencePackage::findOrFail($id);
        return view('admin.pages.exprience_packages.list', compact('package','lists'));
    }

    public function destroy($id)
    {
        $package = ExpriencePackage::findOrFail($id);
        $package->delete();

        return redirect('admin/experiance-package/list')->with('success', 'Experience Package deleted successfully.');
    }
}
