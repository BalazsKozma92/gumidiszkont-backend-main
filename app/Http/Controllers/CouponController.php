<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CouponController extends Controller
{
    public function index(Request $request) {
        try {
            $coupons = Coupon::all();

            return response()->json(['coupons' => $coupons], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch coupons'], 500);
        }
    }

    public function generateCoupons(Request $request)
    {
        $validatedData = $request->validate([
            'count' => 'required|numeric',
            'value' => 'required|numeric',
            'expiration_date' => 'required|date',
        ]);

        $users = User::all();

        foreach ($users as $user) {
            for ($i = 0; $i < $validatedData['count']; $i++) {
                $coupon = new Coupon();
                $coupon->user_id = $user->id;
                $coupon->value = $validatedData['value'];
                $coupon->expiration_date = $validatedData['expiration_date'];
                $coupon->save();

                $qrCodeContent = 'Coupon-' . $coupon->id;
                $coupon->qr_code = QrCode::size(200)->generate($qrCodeContent);
                $coupon->save();
            }
        }

        return response()->json(['message' => 'Coupons generated successfully'], 201);
    }


    public function markAsUsed(Coupon $coupon)
    {
        if ($coupon) {
            $coupon->used = true;
            $coupon->used_at = now();
            $coupon->save();

            return response()->json(['message' => 'Coupon marked as used', 'coupon' => $coupon], 200);
        } else {
            return response()->json(['message' => 'Coupon not found'], 404);
        }
    }
}
