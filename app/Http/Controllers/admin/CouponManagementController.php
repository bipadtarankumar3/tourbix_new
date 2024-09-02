<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponManagementController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth'); 
        
    }
    public function couponList()
    {
        $data['title'] = 'Coupon Lists';
        $data['coupons'] = Coupon::all();
        return view('admin.pages.coupon.list', $data);
    }
    public function addCoupon()
    {
        $data['title'] = 'Add Coupon';
        return view('admin.pages.coupon.add', $data);
    }

    public function updateOrAddCoupon(Request $request, $id = null)
    {
        // Determine if creating or updating a coupon
        $isNew = is_null($id);

        // Handle file upload for feature_image (if provided)
        $featureImagePath = null;
        $oldImagePath = null;  // Store the path of the existing image (if any)
        if ($request->hasFile('feature_image')) {
            $featureImage = $request->file('feature_image');
            $featureImageName = time() . '_' . $featureImage->getClientOriginalName();
            $featureImagePath = '/images/' . $featureImageName; // Assuming 'images' directory inside 'public'

            // If updating, store the path of the existing image for deletion
            if (!$isNew) {
                $coupon = Coupon::find($id);
                if ($coupon) {
                    $oldImagePath = $coupon->feature_image;
                }
            }

            $featureImage->move(public_path('images'), $featureImageName);
        }

        // Create or update the coupon data
        $couponData = [
            'coupon_code' => $request['coupon_code'],
            'coupon_name' => $request['coupon_name'],
            'coupon_amount' => $request['coupon_amount'],
            'discount_type' => $request['discount_type'],
            'end_date' => $request['end_date'],
            'min_spend' => $request['min_spend'],
            'max_spend' => $request['max_spend'],
            'only_for_services' => $request['only_for_services'],
            'only_for_user' => $request['only_for_user'],
            'usage_limit_per_coupon' => $request['usage_limit_per_coupon'],
            'usage_limit_per_user' => $request['usage_limit_per_user'],
            'status' => $request['status'],
        ];

        if ($featureImagePath) {
            $couponData['feature_image'] = $featureImagePath;
        }

        if ($isNew) {
            $coupon = Coupon::create($couponData);
        } else {
            $coupon = Coupon::find($id);
            if ($coupon) {
                $coupon->update($couponData);

                // Delete the old image if a new one was uploaded and the old one exists
                if ($featureImagePath && $oldImagePath) {
                    $this->deleteImage($oldImagePath); // Implement a function to delete the image file
                }
            } else {
                // Handle case where the coupon with the provided ID is not found
                return redirect()->back()->with('error', 'Coupon not found.');
            }
        }

        // Redirect to a success page or return a response
        return redirect()->back()->with('success', ($isNew ? 'Coupon created' : 'Coupon updated') . ' successfully.');
    }

    /**
     * Deletes an image file from the public directory.
     *
     * @param string $path
     * @return void
     */
    protected function deleteImage($path)
    {
        $fullPath = public_path($path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    
    public function editCoupon($id)
    {
        $data['title'] = 'Edit Coupon Type';
        $data['id'] = $id;
        $data['coupon'] = Coupon::where('id', $id)->first();
        return view('admin.pages.coupon.add', $data);
    }
    public function deleteCoupon(Request $request, $id)
    {
      
        $data['propertyType'] = Coupon::where('id', $id)->delete();
        $request->session()->flash('success', ' Deleted successfully');
        return redirect()->back();
    }

}
