<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Experiance;
use App\Models\ExperianceAvailable;
use App\Models\experianceAttribute;
use App\Models\experianceCategory;
use Illuminate\Support\Str;
use App\Models\Documents;
use App\Models\Location;
use App\Models\Tour;
use App\Models\Surrounding;
use App\Models\TourAttribute;
use App\Models\TourContent;

use Illuminate\Http\Request;
use Auth;

use DateTime;


class ExperianceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //----------------- Experiance  ------------------
    public function list()
    {
        $lists = Experiance::all();
        return view('admin.pages.common_experiance.list', compact('lists'));
    }
    public function add()
    {
        $data['locations'] = Location::orderBy('id', 'desc')->get();
        $data['categories'] = experianceCategory::orderBy('id', 'desc')->get();
        $list = experianceAttribute::orderBy('id', 'desc')->get();
        $data['top_features'] = $list->where('attribute_type', 'top_feature');
        $data['travel_style'] = $list->where('attribute_type', 'travel_style');
        $data['lists'] = Experiance::all();
        return view('admin.pages.common_experiance.add', $data);
    }

    public function AddAction(Request $request, $exprienceId = null)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
        ]);
        dd($request->all());

        $year_month = explode('-', $request->input('month'));
        $year = $year_month[0];
        $month = $year_month[1];

        $exp = $exprienceId ? Experiance::findOrFail($exprienceId) : new Experiance();
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
            Experiance::where('id', $id)->update([
                'thumbnail' => $feature_image,
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
                        'table_name' => 'experiances',
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

            $ExperianceAvailable = new ExperianceAvailable();
            $ExperianceAvailable->exp_experiance_id = $exp->id;
            $ExperianceAvailable->exp_amount = $request->input('amount');
            $ExperianceAvailable->exp_available_date = $date;
            $ExperianceAvailable->exp_available_month = $request->input('month');
            $ExperianceAvailable->exp_available_status = 'available';
            $ExperianceAvailable->save();
        }

        return redirect('admin/experiance/add_experiance_available/' . $exp->id)->with('success', 'Experience Package created successfully.');
    }

    public function UpdateAction(Request $request, $exprienceId = null)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
        ]);
        // dd($request->all());


        $exp = $exprienceId ? Experiance::findOrFail($exprienceId) : new Experiance();

        // Set attributes
        $exp->title = $request->input('title');
        $exp->description = $request->input('description');
        $exp->amount = $request->input('amount');
        $exp->location_id = $request->input('location_id');
        $exp->category_id = $request->input('category_id');
        $exp->experiance_attribute_features_id = $request->input('top_feature_id');
        $exp->experiance_attribute_style_id = $request->input('travel_style_id');
        $exp->save();

        $id = $exp->id;




        if ($request->hasFile('feature_image')) {
            $thumbnail = $request->file('feature_image');
            $thumbnailName = Str::uuid() . '_' . $thumbnail->getClientOriginalName(); // Unique filename
            $feature_image = '/upload/feature_image/' . $thumbnailName; // Adjust path as needed
            $thumbnail->move(public_path('upload/feature_image'), $thumbnailName);
            Experiance::where('id', $id)->update([
                'thumbnail' => $feature_image,
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
                        'table_name' => 'experiances',
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


        return redirect('admin/experiance/list')->with('success', 'Experience Package created successfully.');
    }


    // public function updateAction(Request $request,$id){

    //         Experiance::where('id',$id)->Update([
    //             'title' => $request->title,
    //             'description' => $request->description,
    //             'amount' => $request->amount,
    //         ]);
    //         return redirect('admin/experiance/list')->with('success', 'Experience Package created successfully.');

    // }

    public function edit($id)
    {
        $data['locations'] = Location::orderBy('id', 'desc')->get();
        $data['categories'] = experianceCategory::orderBy('id', 'desc')->get();
        $list = experianceAttribute::orderBy('id', 'desc')->get();
        $data['top_features'] = $list->where('attribute_type', 'top_feature');
        $data['travel_style'] = $list->where('attribute_type', 'travel_style');
        $data['lists'] = Experiance::all();
        $data['package'] = Experiance::findOrFail($id);
        $data['documents'] = Documents::where('item_id', $id)->where('table_name', 'rooms')->get();
        return view('admin.pages.common_experiance.add', $data);
    }
    public function delete_exp_images($id)
    {
        Documents::where('id', $id)->delete();
    }
    public function destroy($id)
    {
        $package = Experiance::findOrFail($id);
        $package->delete();

        return redirect('admin/experiance/list')->with('success', 'Experience Package deleted successfully.');
    }


    public function add_experiance_available($id)
    {
        $data['lists'] = Experiance::all();
        $data['Experiance'] = Experiance::findOrFail($id);
        $data['documents'] = Documents::where('item_id', $id)->where('table_name', 'rooms')->get();
        $data['ExperianceAvailable'] = ExperianceAvailable::where('exp_experiance_id', $id)->get();
        return view('admin.pages.common_experiance.add_experiance_available', $data);
    }


    public function add_experiance_update_availability(Request $request)
    {
        $id = $request->input('id');
        $amount = $request->input('amount');
        $status = $request->input('status');

        $availability = ExperianceAvailable::find($id);  // Find by ID
        if ($availability) {
            $availability->exp_amount = $amount;
            $availability->exp_available_status = $status;
            $availability->save();

            return response()->json([
                'success' => true,
                'amount' => $amount,
                'status' => $status
            ]);
        }

        return response()->json(['success' => false], 404);
    }

    public function update_experiance_available_month(Request $request)
    {
        $year_month = explode('-', $request->input('month'));
        $experiance_id = $request->input('experiance_id');
        $year = $year_month[0];
        $month = $year_month[1];

        $ExperianceAvailableCheck = ExperianceAvailable::where('exp_experiance_id', $experiance_id)->where('exp_available_month', $request->input('month'))->first();

        if ($ExperianceAvailableCheck) {
            return response()->json([
                'success' => false,
                'message' => 'Already inseted',
            ]);
        }

        $exp = Experiance::findOrFail($experiance_id);
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

            $ExperianceAvailable = new ExperianceAvailable();
            $ExperianceAvailable->exp_experiance_id = $exp->id;
            $ExperianceAvailable->exp_amount = $exp->amount;
            $ExperianceAvailable->exp_available_date = $date;
            $ExperianceAvailable->exp_available_month = $request->input('month');
            $ExperianceAvailable->exp_available_status = 'available';
            $ExperianceAvailable->save();
        }
        return response()->json([
            'success' => true,
            'message' => 'Updated',
        ]);
    }


    //----------------- Experiance End ------------------



    //------------ Tour -------------------------------------
    public function experianceList()
    {
        $data['title'] = 'Experiance List';
        return view('admin.pages.experiance.list', $data);
    }
    public function addNewTour()
    {
        $data['title'] = 'Add New Tour';
        $data['category'] = experianceCategory::all();
        $data['top_feature'] = experianceAttribute::where('attribute_type', 'top_feature')->get();
        $data['property_type'] = experianceAttribute::where('attribute_type', 'property_type')->get();
        $data['travel_style'] = experianceAttribute::where('attribute_type', 'travel_style')->get();
        $data['tour_feature'] = experianceAttribute::where('attribute_type', 'tour_feature')->get();
        $data['facilities'] = experianceAttribute::where('attribute_type', 'facilities')->get();
        return view('admin.pages.experiance.add_new_tour', $data);
    }
    public function submit_tour_form(Request $request)
    {

        // dd($request->all());

        // try {
        $data = array(
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'youtube_video' => $request->youtube_video,
            'minimum_advance' => $request->minimum_advance,
            'duration' => $request->duration,
            'min_people' => $request->min_people,
            'max_people' => $request->max_people,
            'location' => $request->location,
            'real_address' => $request->real_address,
            'map_link' => $request->map_link,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'extra_price' => ($request->extra_price) ? $request->extra_price : '',
            'service_fee' => $request->service_fee,
            'fixed_date' => $request->fixed_date,
            'open_hours' => $request->open_hours,
            'status' => $request->status,
            'user_id' =>  Auth::user()->id,
        );

        // Create the company
        $create = Tour::create($data);

        $faq_title = $request->faq_title;
        $faq_content = $request->faq_content;
        foreach ($faq_title as $key => $value) {
            $create = TourContent::create([
                'tour_id' => $create->id,
                'type' => 'faq',
                'title' => $value,
                'content' => $faq_content[$key],
            ]);
        }

        $include_title = $request->include_title;
        foreach ($include_title as $key => $value) {
            $create = TourContent::create([
                'tour_id' => $create->id,
                'type' => 'include',
                'title' => $value,
            ]);
        }

        $exclude_title = $request->exclude_title;
        foreach ($exclude_title as $key => $value) {
            $create = TourContent::create([
                'tour_id' => $create->id,
                'type' => 'exclude',
                'title' => $value,
            ]);
        }

        $itinerary_title = $request->itinerary_title;
        $itinerary_content = $request->itinerary_content;
        foreach ($itinerary_title as $key => $value) {
            $create = TourContent::create([
                'tour_id' => $create->id,
                'type' => 'faq',
                'title' => $value,
                'content' => $itinerary_content[$key],
            ]);
        }


        $education_name = $request->education_name;
        $education_content = $request->education_content;
        $education_distance = $request->education_distance;
        foreach ($education_name as $key => $value) {
            $create = Surrounding::create([
                'tour_id' => $create->id,
                'type' => 'education',
                'name' => $value,
                'content' => $education_content[$key],
                'distance' => $education_distance[$key],
            ]);
        }
        $health_name = $request->health_name;
        $health_content = $request->health_content;
        $health_distance = $request->health_distance;
        foreach ($health_name as $key => $value) {
            $create = Surrounding::create([
                'tour_id' => $create->id,
                'type' => 'health',
                'name' => $value,
                'content' => $health_content[$key],
                'distance' => $health_distance[$key],
            ]);
        }
        $transportation_name = $request->transportation_name;
        $transportation_content = $request->transportation_content;
        $transportation_distance = $request->transportation_distance;
        foreach ($transportation_name as $key => $value) {
            $create = Surrounding::create([
                'tour_id' => $create->id,
                'type' => 'transportation',
                'name' => $value,
                'content' => $transportation_content[$key],
                'distance' => $transportation_distance[$key],
            ]);
        }
        $adventures_name = $request->adventures_name;
        $adventures_content = $request->adventures_content;
        $adventures_distance = $request->adventures_distance;
        foreach ($adventures_name as $key => $value) {
            $create = Surrounding::create([
                'tour_id' => $create->id,
                'type' => 'adventures',
                'name' => $value,
                'content' => $adventures_content[$key],
                'distance' => $adventures_distance[$key],
            ]);
        }
        $experience_name = $request->experience_name;
        $experience_content = $request->experience_content;
        $experience_distance = $request->experience_distance;
        foreach ($experience_name as $key => $value) {
            $create = Surrounding::create([
                'tour_id' => $create->id,
                'type' => 'experience',
                'name' => $value,
                'content' => $experience_content[$key],
                'distance' => $experience_distance[$key],
            ]);
        }

        $top_feature = $request->top_feature;
        TourAttribute::create([
            'tour_id' => $create->id,
            'type' => 'top_feature',
            'attribute_id' => implode(',', $top_feature),
        ]);
        $property_type = $request->property_type;
        TourAttribute::create([
            'tour_id' => $create->id,
            'type' => 'property_type',
            'attribute_id' => implode(',', $property_type),
        ]);
        $travel_style = $request->travel_style;
        TourAttribute::create([
            'tour_id' => $create->id,
            'type' => 'travel_style',
            'attribute_id' => implode(',', $travel_style),
        ]);
        $tour_feature = $request->tour_feature;
        TourAttribute::create([
            'tour_id' => $create->id,
            'type' => 'tour_feature',
            'attribute_id' => implode(',', $tour_feature),
        ]);
        $facilities = $request->facilities;
        TourAttribute::create([
            'tour_id' => $create->id,
            'type' => 'facilities',
            'attribute_id' => implode(',', $facilities),
        ]);

        $request->session()->flash('success', 'Added success');
        return redirect()->back();

        // return $this->sendResponse($create, 'Tour Added Successfully');
        // } catch (\Exception $e) {
        //     return $this->sendError('Failed to add Tour', $e->getMessage());
        // }
    }
    //------------ Tour End -------------------------------------

    //------------ Category -------------------------------------
    public function category()
    {
        $data['title'] = 'Tour Ctegory';
        $data['lists'] = experianceCategory::where('user_id', Auth::user()->id)->get();
        return view('admin.pages.experiance.tour_category', $data);
    }

    public function categoryEdit($id = null)
    {
        $data['title'] = 'Tour Ctegory Edit';
        $data['lists'] = experianceCategory::where('user_id', Auth::user()->id)->get();
        if ($id) {
            $data['category'] = experianceCategory::findOrFail($id);
        }
        return view('admin.pages.experiance.tour_category', $data);
    }


    public function categoryAddAction(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255',

        ]);

        if ($request->experiance_category == 'add') {
            // Create a new location record
            experianceCategory::create([
                'category_name' => $validatedData['category_name'],

                'user_id' => Auth::user()->id,
                'added_by' => Auth::user()->id,
                'status' => 1
                // Add any additional fields here if needed
            ]);

            // Flash success message to the session
            $request->session()->flash('success', 'Location added successfully');
        } else {

            // Create a new location record
            experianceCategory::where('id', $request->experiance_category_id)->update([
                'category_name' => $validatedData['category_name'],

                'status' => 1
                // Add any additional fields here if needed
            ]);

            // Flash success message to the session
            $request->session()->flash('success', 'Location updated successfully');
        }

        // Redirect back to the location list page
        return redirect()->back();
    }

    public function categoryDelete(Request $request, $id)
    {
        $category = experianceCategory::whereId($id)->delete();
        $request->session()->flash('success', 'Category Deleted successfully');
        return redirect()->back();
    }


    //------------ Category -------------------------------------


    //------------ attributes -------------------------------------
    public function attributes()
    {
        $data['title'] = 'Tour attributes';
        $data['lists'] = experianceAttribute::where('user_id', Auth::user()->id)->get();
        return view('admin.pages.experiance.tour_attributes', $data);
    }

    public function attributeEdit($id = null)
    {
        $data['title'] = 'Tour attributes Edit';
        $data['lists'] = experianceAttribute::where('user_id', Auth::user()->id)->get();
        if ($id) {
            $data['attribute'] = experianceAttribute::findOrFail($id);
        }
        return view('admin.pages.experiance.tour_attributes', $data);
    }


    public function attributeAddAction(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'attribute_type' => 'required',
            'attribute_name' => 'required'
        ]);

        if ($request->experiance_attribute == 'add') {
            // Create a new location record
            experianceAttribute::create([
                'attribute_type' => $request->attribute_type,
                'attribute_name' => $request->attribute_name,
                'icon_class' => $request->icon_class,
                'hide_detail_service' => $request->hide_detail_service,
                'hide_filter_serch' => $request->hide_filter_serch,
                'user_id' => Auth::user()->id,
                'added_by' => Auth::user()->id,
                'status' => 1
                // Add any additional fields here if needed
            ]);

            // Flash success message to the session
            $request->session()->flash('success', 'attributes added successfully');
        } else {

            // Create a new attributes record
            experianceAttribute::where('id', $request->experiance_attribute_id)->update([
                'attribute_type' => $request->attribute_type,
                'attribute_name' => $request->attribute_name,
                'icon_class' => $request->icon_class,
                'hide_detail_service' => $request->hide_detail_service,
                'hide_filter_serch' => $request->hide_filter_serch,
                'updated_by' => Auth::user()->id,
                'status' => 1
                // Add any additional fields here if needed
            ]);

            // Flash success message to the session
            $request->session()->flash('success', 'attributes updated successfully');
        }

        // Redirect back to the attributes list page
        return redirect()->back();
    }

    public function attributeDelete(Request $request, $id)
    {
        $category = experianceAttribute::whereId($id)->delete();
        $request->session()->flash('success', 'attributes Deleted successfully');
        return redirect()->back();
    }
    //------------ attributes end -------------------------------------

}
