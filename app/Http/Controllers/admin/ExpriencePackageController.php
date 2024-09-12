<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ExpriencePackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Documents;
class ExpriencePackageController extends Controller
{
    public function list()
    {
        $lists = ExpriencePackage::all();
        return view('admin.pages.exprience_packages.list', compact('lists'));
    }
    public function add()
    {
        $lists = ExpriencePackage::all();
        return view('admin.pages.exprience_packages.add', compact('lists'));
    }

    public function AddAction(Request $request, $exprienceId = null){
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
        ]);
        // dd($request->all());
       
           
            $exp = $exprienceId ? ExpriencePackage::findOrFail($exprienceId) : new ExpriencePackage();

        // Set attributes
        $exp->title = $request->input('title');
        $exp->description = $request->input('description');
        $exp->amount = $request->input('amount');
       
        $exp->save();

        $id = $exp->id;

       


        if ($request->hasFile('feature_image')) {
            $thumbnail = $request->file('feature_image');
            $thumbnailName = Str::uuid() . '_' . $thumbnail->getClientOriginalName(); // Unique filename
            $feature_image = '/upload/feature_image/' . $thumbnailName; // Adjust path as needed
            $thumbnail->move(public_path('upload/feature_image'), $thumbnailName);
            ExpriencePackage::where('id', $id)->update([
                'feature_image' => $feature_image,
            ]);
        }

        $document = $request->document;
        $document_text_name = $request->document_text_name;
        if ($document != null) {

            $uploadSuccess = true;
            foreach ($document as $key => $file) {
                if ($file && $file->isValid()) {
                    $milisecond = round(microtime(true) * 1000);
                    $name = $file->getClientOriginalName();
                    $actual_name = str_replace(" ", "_", $name);
                    $uploadName = $milisecond . "_" . $actual_name;
                    $file->move(public_path('upload'), $uploadName);

                    $documentData[] = [
                        'image_name' => $uploadName,
                        'table_name' => 'rooms',
                        'item_id' => $id,
                        'text_name' => isset($document_text_name[$key]) ? $document_text_name[$key] : '',
                    ];
                } else {
                    // If any file is invalid, set $uploadSuccess to false
                    $uploadSuccess = false;
                }
            }

            // Insert all document data into the database in one go
            if ($uploadSuccess) {
                Documents::insert($documentData);
            }
        }
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
        $data['lists'] = ExpriencePackage::all();
        $data['package'] = ExpriencePackage::findOrFail($id);
        $data['documents'] = Documents::where('item_id', $id)->where('table_name', 'rooms')->get();
        return view('admin.pages.exprience_packages.add',$data);
    }
    public function delete_exp_images($id)
    {
        Documents::where('id', $id)->delete();
    }
    public function destroy($id)
    {
        $package = ExpriencePackage::findOrFail($id);
        $package->delete();

        return redirect('admin/experiance-package/list')->with('success', 'Experience Package deleted successfully.');
    }
}
