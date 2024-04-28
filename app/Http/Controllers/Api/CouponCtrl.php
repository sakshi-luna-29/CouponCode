<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponCtrl extends Controller
{
    public function CreateCoupon(Request $request)
    {
        $data = $request->all();
        $cc = Coupon::Create($data);
        if ($cc) {
            return response()->json(['status' => 'true', 'status_code' => "200", 'data' => $data, 'message' => 'coupon saved successfully']);
        } else {
            return response()->json(['status' => 'false', 'status_code' => "400", 'message' => 'something went wrong']);
        }
    }

    public function useCoupon(Request $request)
    {
        $data = $request->all();
        $cc =   Coupon::where('coupon_code', $data['coupon_code'])->first();
        if ($cc->count > 1 && $cc->multipleUsage == "0") {
            return response()->json(['status' => 'true', 'status_code' => "200",  'message' => 'coupon already used.']);
        } else {
            // if ($cc->multipleUsage == "1") {
            $amount = $data['amount'];

            $percentage = $cc->percentage;

            $discounted_price = number_format(($amount * (100  - $percentage)) / 100, 2);
            $dd = [
                'discounted_price' => $discounted_price,
            ];
            $count = $cc->count + 1;
            $cc_update = Coupon::where('id', $cc->id)->update(['status' => '1', 'count' => $count]);
            if ($cc_update) {
                return response()->json(['status' => 'true', 'status_code' => "200", 'data' => $dd, 'message' => 'coupon used successfully']);
            } else {
                return response()->json(['status' => 'false', 'status_code' => "400", 'message' => 'something went wrong']);
            }
        }
        // }
    }
}
