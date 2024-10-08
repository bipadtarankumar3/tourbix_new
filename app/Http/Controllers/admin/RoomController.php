<?php

namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use League\CommonMark\Node\Block\Document;
use App\Models\RoomAmenities;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Documents;
use App\Models\Hotel;
use App\Models\RoomAvailable;
use App\Models\RoomAvailableDate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use DateTime;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function roomamenities()
    {
        $data['title'] = 'Hotel Amenities';
        $data['amenities'] = RoomAmenities::where('user_id', Auth::user()->id)->get();
        return view('admin.pages.room.amenities', $data);
    }

    public function amenityEdit($id = null)
    {
        $data['title'] = $id ? 'Edit Amenity' : 'Add New Amenity';
        $data['amenities'] = RoomAmenities::where('user_id', Auth::user()->id)->get();
        $data['amenity'] = $id ? RoomAmenities::find($id) : null;
        return view('admin.pages.room.amenities', $data);
    }

    public function updateOrAddAmenity(Request $request, $id = null)
    {
        $validatedData = $request->validate([
            'icon' => 'required|string|max:255',
            'amenities_name' => 'required|string|max:255'
        ]);

        $data = [
            'icon' => $validatedData['icon'],
            'name' => $validatedData['amenities_name'],
            'user_id' => Auth::user()->id,
            'status' => 'publish' // Assuming default status is 'publish'
        ];

        if ($id) {
            $amenity = RoomAmenities::find($id);
            if ($amenity) {
                $amenity->update($data);
                $message = 'Amenity updated successfully';
            } else {
                $message = 'Amenity not found';
            }
        } else {
            RoomAmenities::create($data);
            $message = 'Amenity added successfully';
        }

        $request->session()->flash('success', 'added success');
        return redirect()->back();
    }

    public function amenityDelete(Request $request, $id)
    {
        $amenity = RoomAmenities::find($id);
        if ($amenity) {
            $amenity->delete();
            $message = 'Amenity deleted successfully';
        } else {
            $message = 'Amenity not found';
        }

        $request->session()->flash('success',  $message);
        return redirect()->back();
    }

    // List all room types
    public function roomTypes()
    {
        $data['title'] = 'Room Types';
        $data['roomTypes'] = RoomType::where('user_id', Auth::user()->id)->get();
        return view('admin.pages.room.roomtype', $data);
    }

    // Edit a specific room type or add a new one
    public function roomTypeEdit($id = null)
    {
        $data['title'] = $id ? 'Edit Room Type' : 'Add New Room Type';
        $data['roomTypes'] = RoomType::where('user_id', Auth::user()->id)->get();
        $data['roomType'] = $id ? RoomType::find($id) : null;
        return view('admin.pages.room.roomtype', $data);
    }

    // Update or add a new room type
    public function roomTypeUpdateOrAdd(Request $request, $id = null)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'status' => 'required|string|max:255'
        ]);

        $data = [
            'type' => $validatedData['type'],
            'status' => $validatedData['status'],
            'user_id' => Auth::user()->id
        ];

        if ($id) {
            $roomType = RoomType::find($id);
            if ($roomType) {
                $roomType->update($data);
                $message = 'Room Type updated successfully';
            } else {
                $message = 'Room Type not found';
            }
        } else {
            RoomType::create($data);
            $message = 'Room Type added successfully';
        }

        $request->session()->flash('success', $message);
        return redirect()->back();
    }

    // Delete a specific room type
    public function roomTypeDelete(Request $request, $id)
    {
        $roomType = RoomType::find($id);
        if ($roomType) {
            $roomType->delete();
            $message = 'Room Type deleted successfully';
        } else {
            $message = 'Room Type not found';
        }

        $request->session()->flash('success', $message);
        return redirect()->back();
    }

    public function roomList()
    {
        $data['title'] = 'Room Management';
        $data['rooms'] = Room::where('user_id', Auth::user()->id)->get();
        return view('admin.pages.room.list', $data);
    }
    public function addRoom()
    {
        $data['title'] = 'Add Room';
        $data['roomTypes'] = RoomType::where('user_id', Auth::user()->id)->get();
        $data['amenities'] = RoomAmenities::where('user_id', Auth::user()->id)->get();
        return view('admin.pages.room.addRoom', $data);
    }

    public function edit_room($id)
    {
        $data['title'] = 'Add Room';
        $data['room'] = Room::where('id', $id)->first();
        $data['roomTypes'] = RoomType::where('user_id', Auth::user()->id)->get();
        $data['amenities'] = RoomAmenities::where('user_id', Auth::user()->id)->get();
        $data['documents'] = Documents::where('item_id', $id)->where('table_name', 'rooms')->get();
        return view('admin.pages.room.addRoom', $data);
    }

    public function saveRoom(Request $request, $roomId = null)
    {

        // dd($request->all());

        // Create or retrieve the Room instance based on $roomId
        $room = $roomId ? Room::findOrFail($roomId) : new Room();

        // Set attributes
        $room->name = $request->input('name');
        $room->room_type = $request->input('room_type');
        $room->price = $request->input('price');
        $room->no_of_rooms = $request->input('no_of_rooms');
        $room->minimum_day_stay = $request->input('minimum_day_stay');
        $room->no_of_beds = $request->input('no_of_beds');
        $room->room_size = $request->input('room_size');
        $room->max_adults = $request->input('max_adults');
        $room->max_children = $request->input('max_children');
        $room->room_amenities = implode(',', $request->room_amenities);
        $room->import_url = $request->input('import_url');
        $room->status = $request->input('status');
        $room->user_id = Auth::user()->id;
        // Add other fields here

        // Save the room
        $room->save();

        $id = $room->id;

        if ($request->hasFile('bed_room')) {
            $thumbnail = $request->file('bed_room');
            $thumbnailName = Str::uuid() . '_' . $thumbnail->getClientOriginalName(); // Unique filename
            $bed_room = '/upload/bed_room/' . $thumbnailName; // Adjust path as needed
            $thumbnail->move(public_path('upload/bed_room'), $thumbnailName);
            Room::where('id', $id)->update([
                'bed_room' => $bed_room,
            ]);
        }

        if ($request->hasFile('washroom')) {
            $thumbnail = $request->file('washroom');
            $thumbnailName = Str::uuid() . '_' . $thumbnail->getClientOriginalName(); // Unique filename
            $washroom = '/upload/washroom/' . $thumbnailName; // Adjust path as needed
            $thumbnail->move(public_path('upload/washroom'), $thumbnailName);
            Room::where('id', $id)->update([
                'washroom' => $washroom,
            ]);
        }

        if ($request->hasFile('kitchen')) {
            $thumbnail = $request->file('kitchen');
            $thumbnailName = Str::uuid() . '_' . $thumbnail->getClientOriginalName(); // Unique filename
            $kitchen = '/upload/kitchen/' . $thumbnailName; // Adjust path as needed
            $thumbnail->move(public_path('upload/kitchen'), $thumbnailName);
            Room::where('id', $id)->update([
                'kitchen' => $kitchen,
            ]);
        }

        if ($request->hasFile('balcony')) {
            $thumbnail = $request->file('balcony');
            $thumbnailName = Str::uuid() . '_' . $thumbnail->getClientOriginalName(); // Unique filename
            $balcony = '/upload/balcony/' . $thumbnailName; // Adjust path as needed
            $thumbnail->move(public_path('upload/balcony'), $thumbnailName);
            Room::where('id', $id)->update([
                'balcony' => $balcony,
            ]);
        }


        if ($request->hasFile('feature_image')) {
            $thumbnail = $request->file('feature_image');
            $thumbnailName = Str::uuid() . '_' . $thumbnail->getClientOriginalName(); // Unique filename
            $feature_image = '/upload/feature_image/' . $thumbnailName; // Adjust path as needed
            $thumbnail->move(public_path('upload/feature_image'), $thumbnailName);
            Room::where('id', $id)->update([
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


        $request->session()->flash('success', 'Addes success');
        return redirect()->back();
    }

    public function delete_room_images($id)
    {
        Documents::where('id', $id)->delete();
    }
    public function deleteRoom($id)
    {
        Room::where('id', $id)->delete();

        session()->flash('success', 'Deleted success');
        return redirect()->back();
    }

    public function roomAvalibility()
    {
        $data['title'] = 'Room Avalibility Management ';

        $roomav = DB::table('rooms_available')
            ->select('rooms_available.*', 'hotels.title as hotel_name', 'rooms.name as room_name')
            ->join('hotels', 'hotels.id', '=', 'rooms_available.hotel_id')
            ->join('rooms', 'rooms.id', '=', 'rooms_available.room_id')->orderBy('hotels.id', 'desc')->get();
        $data['roomav'] = $roomav;
        return view('admin.pages.room.avalibility', $data);
    }

    public function addRoomavailable()
    {
        $data['title'] = 'Add Room Avalibility';
        $data['hotels'] = Hotel::orderBy('id', 'desc')->get();
        $data['rooms'] = Room::orderBy('id', 'desc')->get();
        return view('admin.pages.room.addRoomavailable', $data);
    }

    public function edit_roomavailable($id)
    {
        $data['title'] = 'Add Room Avalibility';
        $data['available_room'] = RoomAvailable::where('id', $id)->first();
        $data['hotels'] = Hotel::orderBy('id', 'desc')->get();
        $data['rooms'] = Room::orderBy('id', 'desc')->get();

        $data['availabilityData'] = RoomAvailableDate::where('rad_available_room_id', $id)->get();


        return view('admin.pages.room.editAvailableRoom', $data);
    }

    public function saveRoomavailable(Request $request, $roomId = null)
    {

        // dd($request->all());
        
        $room = $roomId ? RoomAvailable::findOrFail($roomId) : new RoomAvailable();

        $roomId = $request->input('room_id');

        $year_month = explode('-', $request->input('available_month'));
        $year = $year_month[0];
        $month = $year_month[1];

        // Set attributes
        $room->hotel_id = $request->input('hotel_id');
        $room->room_id = $request->input('room_id');
        $room->amount = $request->input('amount');
        $room->no_of_rooms = $request->input('no_of_rooms');
        $room->available_month = $request->input('available_month');
        // $room->form_date = $request->form_date;
        // $room->to_date = $request->to_date;
        $room->added_by = Auth::user()->id;
        // Add other fields here

        // Save the room
        $room->save();


        
        
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
            
            $roomAvailable = new RoomAvailableDate();
            $roomAvailable->rad_hotel_id = $request->input('hotel_id');
            $roomAvailable->rad_room_id = $request->input('room_id');
            $roomAvailable->rad_available_room_id = $room->id;
            $roomAvailable->rad_amount = $request->input('amount');
            $roomAvailable->rad_available_date = $date;
            $roomAvailable->rad_available_status = 'YES';
            $roomAvailable->save();
        }

        return redirect('admin/room/edit_roomavailable/' . $room->id);

        

        // if (!empty($roomId)) {
        //     $request->session()->flash('success', 'Update success');
        // } else {
        //     $request->session()->flash('success', 'Addes success');
        // }
        // return redirect()->back();
    }


    public function update_roomavailable(Request $request)
    {

        // dd($request->all());
        $roomId = $request->input('available_room_id');

        $room = $roomId ? RoomAvailable::findOrFail($roomId) : new RoomAvailable();
        $room->hotel_id = $request->input('hotel_id');
        $room->room_id = $request->input('room_id');
        $room->no_of_rooms = $request->input('no_of_rooms');
        $room->added_by = Auth::user()->id;
        // Add other fields here

        // Save the room
        $room->save();


        return redirect('admin/room/avalibility/');

    }


    public function update_availability(Request $request)
{
    $id = $request->input('id');
    $amount = $request->input('amount');
    $status = $request->input('status');

    $availability = RoomAvailableDate::find($id);  // Find by ID
    if ($availability) {
        $availability->rad_amount = $amount;
        $availability->rad_available_status = $status;
        $availability->save();

        return response()->json([
            'success' => true,
            'amount' => $amount,
            'status' => $status
        ]);
    }

    return response()->json(['success' => false], 404);
}



    public function deleteRoomavailable($id)
    {
        try {
            // Attempt to delete the record
            $deleted = RoomAvailable::where('id', $id)->delete();

            if ($deleted) {
                return Response::json([
                    'success' => true,
                    'message' => 'Deleted successfully.'
                ]);
            } else {
                return Response::json([
                    'success' => false,
                    'message' => 'Record not found.'
                ], 404);
            }
        } catch (\Exception $e) {
            // Log the exception if needed
            return Response::json([
                'success' => false,
                'message' => 'An error occurred while deleting the record.'
            ], 500);
        }
    }
}
