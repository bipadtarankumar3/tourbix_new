<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ExpriencePackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Documents;
use App\Models\Experiance;
use App\Models\experianceAttribute;
use App\Models\ExperianceAvailable;
use App\Models\experianceCategory;
use App\Models\ExpriencePackageAvailableDay;
use App\Models\ExpriencePackageDay;
use App\Models\Location;
use DateTime;
class ExpriencePackageController extends Controller
{
    public function list()
    {
        $data['expriences']=Experiance::all();
        $data['lists'] = ExpriencePackage::all();
        return view('admin.pages.exprience_packages.list',$data);
    }
    public function add()
    {
        $data['locations']=Location::orderBy('id','desc')->get();
        $data['categories']=experianceCategory::orderBy('id','desc')->get();
        $list=experianceAttribute::orderBy('id','desc')->get();
        $data['top_features']=$list->where('attribute_type','top_feature');
        $data['facilities']=$list->where('attribute_type','facilities');
        $data['travel_style']=$list->where('attribute_type','travel_style');
        $data['expriences']=Experiance::all();
        $data['lists'] = ExpriencePackage::all();
        return view('admin.pages.exprience_packages.add',$data);
    }

    public function AddAction(Request $request, $exprienceId = null){
// dd($request->all());
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
        ]);
        $year_month = explode('-', $request->input('month'));
        $year = $year_month[0];
        $month = $year_month[1];
        $facilities = $request->input('facilitie_id'); 

        // Implode the array into a comma-separated string
        $facilitiesString = implode(',', $facilities);
        //    dd( $facilitiesString);
            $exp = $exprienceId ? ExpriencePackage::findOrFail($exprienceId) : new ExpriencePackage();
            $exp->experiance_attribute_facilities_id = $facilitiesString;
            $exp->location_id = $request->input('location_id');
            $exp->category_id = $request->input('category_id');
            $exp->experiance_attribute_features_id = $request->input('top_feature_id');
            $exp->experiance_attribute_style_id = $request->input('travel_style_id');
        // Set attributes
        $exp->title = $request->input('title');
        $exp->description = $request->input('description');
        $exp->amount = $request->input('amount');
        $exp->month = $request->input('month');
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
                        'table_name' => 'exprience',
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
        $package_day = $request->package_day;
        $exprience_id = $request->exprience_id;
        $package_description = $request->package_description;
        if ($package_day != null) {

         
            foreach ($package_day as $key => $package_d) {
               
                   
                    $packageData[] = [
                        'exprience_package_id' => $id,
                        'package_day' => isset($package_day[$key]) ? $package_day[$key] : '',
                        'exprience_id' => isset($exprience_id[$key]) ? $exprience_id[$key] : '',
                        'package_description' => isset($package_description[$key]) ? $package_description[$key] : '',
                        
                    ];
               
            }
            ExpriencePackageDay::insert($packageData);
           
           
        }
          
        }
           // Create a DateTime object for the first day of the given month
        $startDate = new DateTime("$year-$month-01");
        // Clone the DateTime object and set it to the first day of the next month
        $endDate = clone $startDate;

        $endDate->modify('first day of next month');
        
        // Initialize an array to store all dates in the month
        $dates = [];
        while ($startDate < $endDate) {
            $dates[] = $startDate->format('Y-m-d');
            $startDate->modify('+1 day');
        }

        foreach ($dates as $date) {
            
            $ExperiancepackAvailable = new ExpriencePackageAvailableDay();
            $ExperiancepackAvailable->exprience_package_id = $id;
            $ExperiancepackAvailable->exprience_package_amount = $request->input('amount');
            $ExperiancepackAvailable->exprience_package_available_date = $date;
            $ExperiancepackAvailable->exprience_package_available_month =$request->input('month');
            $ExperiancepackAvailable->exprience_package_available_status = 'available';
            $ExperiancepackAvailable->save();
        }

        return redirect('admin/experiance-package/add_experiance_package_available/'.$id)->with('success', 'Experience Package created successfully.');
       
    }
    public function add_experiance_package_available($id)
    {

        // dd($id);

        $data['lists'] = ExpriencePackage::all();
        $data['Experiance'] = ExpriencePackage::findOrFail($id);
        $data['documents'] = Documents::where('item_id', $id)->where('table_name', 'rooms')->get();
        $data['ExperianceAvailable'] = ExpriencePackageAvailableDay::where('exprience_package_id', $id)->get();

        // dd($data['ExperianceAvailable'] );

        return view('admin.pages.exprience_packages.add_experiance_available',$data);
    }


        
    public function add_experiance_package_update_availability(Request $request)
    {
        $id = $request->input('id');
        $amount = $request->input('amount');
        $status = $request->input('status');

        $availability = ExpriencePackageAvailableDay::find($id);  // Find by ID
        if ($availability) {
            $availability->exprience_package_amount = $amount;
            $availability->exprience_package_available_status = $status;
            $availability->save();

            return response()->json([
                'success' => true,
                'amount' => $amount,
                'status' => $status
            ]);
        }

        return response()->json(['success' => false], 404);
    }

    public function update_experiance_package_available_month(Request $request)
    {
        $year_month = explode('-', $request->input('month'));
        $experiance_id = $request->input('experiance_id');
        $year = $year_month[0];
        $month = $year_month[1];

        $ExperianceAvailableCheck = ExpriencePackageAvailableDay::where('exprience_package_id',$experiance_id)->where('exprience_package_available_month',$request->input('month'))->first();

        if ($ExperianceAvailableCheck) {
            return response()->json([
                'success' => false,
                'message' => 'Already inseted',
            ]);
        }
           
        $exp = ExpriencePackage::findOrFail($experiance_id);
        $exp->month = $request->input('month');
        $exp->save();

        $id = $exp->id;
                
        // Create a DateTime object for the first day of the given month
        $startDate = new DateTime("$year-$month-01");
        // Clone the DateTime object and set it to the first day of the next month
        $endDate = clone $startDate;

        $endDate->modify('first day of next month');
        
        // Initialize an array to store all dates in the month
        $dates = [];
        while ($startDate < $endDate) {
            $dates[] = $startDate->format('Y-m-d');
            $startDate->modify('+1 day');
        }

        foreach ($dates as $date) {
            
            $ExpriencePackageAvailableDay = new ExpriencePackageAvailableDay();
            $ExpriencePackageAvailableDay->exprience_package_id = $exp->id;
            $ExpriencePackageAvailableDay->exprience_package_amount = $exp->amount;
            $ExpriencePackageAvailableDay->exprience_package_available_date = $date;
            $ExpriencePackageAvailableDay->exprience_package_available_month =$request->input('month');
            $ExpriencePackageAvailableDay->exprience_package_available_status = 'available';
            $ExpriencePackageAvailableDay->save();
        }
        return response()->json([
            'success' => true,
            'message' => 'Updated',
        ]);
    }



    public function edit($id)
    {
        $data['locations']=Location::orderBy('id','desc')->get();
        $data['categories']=experianceCategory::orderBy('id','desc')->get();
        $list=experianceAttribute::orderBy('id','desc')->get();
        $data['top_features']=$list->where('attribute_type','top_feature');
        $data['facilities']=$list->where('attribute_type','facilities');
        $data['travel_style']=$list->where('attribute_type','travel_style');
        $data['expriences']=Experiance::all();
        $data['lists'] = ExpriencePackage::all();
        $data['package'] = ExpriencePackage::findOrFail($id);
        $data['documents'] = Documents::where('item_id', $id)->where('table_name', 'rooms')->get();
        $data['exp_pack_days'] = ExpriencePackageDay::where('exprience_package_id', $id)->get();
        return view('admin.pages.exprience_packages.add',$data);
    }
    public function delete_exp_images($id)
    {
        Documents::where('id', $id)->delete();
    }
    public function delete_experiance_package($id)
    {
        $package = ExpriencePackage::findOrFail($id);
        $package->delete();

        return redirect('admin/experiance-package/list')->with('success', 'Experience Package deleted successfully.');
    }
}
