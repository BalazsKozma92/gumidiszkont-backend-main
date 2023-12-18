<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function index(Request $request) {
        try {
            $coupons = Coupon::with('user')->get();

            $groupedCoupons = $coupons->groupBy(function ($coupon) {
                return $coupon->user->id;
            });

            return response()->json(['coupons' => $groupedCoupons], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch coupons'], 500);
        }
    }

    public function show(Request $request, Coupon $coupon) {
        if (!$coupon->used) {
            return response()->json($coupon);
        }

        return response()->json(['error' => 'A kupon már fel lett használva'], 402);
    }

    public function myCoupons(Request $request, User $user) {
        try {
            $currentDate = Carbon::now();
            $coupons = $coupons = $user->coupons()
                ->where('expiration_date', '>', $currentDate)
                ->where('used', '!=', 1) // Exclude used coupons
                ->get();
    
            return response()->json(['coupons' => $coupons], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch coupons'], 500);
        }
    }

    public function generateCoupons(Request $request)
    {
        $validatedData = $request->validate([
            'count' => 'required|numeric',
            'type' => 'required|string',
            'name' => 'required|string',
            'value' => 'required|numeric',
            'expiration_date' => 'required|date',
            'all_users' => 'required|boolean',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);

        if ($validatedData['all_users'] == true) {
            $users = User::all();
    
            foreach ($users as $user) {
                for ($i = 0; $i < $validatedData['count']; $i++) {
                    $coupon = new Coupon();
                    $coupon->user_id = $user->id;
                    $coupon->value = $validatedData['value'];
                    $coupon->type = $validatedData['type'];
                    $coupon->name = $validatedData['name'];
                    $coupon->expiration_date = $validatedData['expiration_date'];
                    $coupon->save();
    
                    $qrCodeContent = 'Coupon-' . $coupon->id;
                    $coupon->qr_code = QrCode::size(120)->generate($qrCodeContent);
                    $coupon->save();
                }
            }
        } else {
            $user = User::find($validatedData['user_id']);
    
            for ($i = 0; $i < $validatedData['count']; $i++) {
                $coupon = new Coupon();
                $coupon->user_id = $user->id;
                $coupon->value = $validatedData['value'];
                $coupon->type = $validatedData['type'];
                $coupon->name = $validatedData['name'];
                $coupon->expiration_date = $validatedData['expiration_date'];
                $coupon->save();

                $qrCodeContent = 'Coupon-' . $coupon->id;
                $coupon->qr_code = QrCode::size(120)->generate($qrCodeContent);
                $coupon->save();
            }
        }

        return response()->json(['message' => 'A kuponok elkészültek'], 201);
    }


    public function markAsUsed(Coupon $coupon)
    {
        if ($coupon && !$coupon->used) {
            $coupon->used = true;
            $coupon->used_at = now();
            $coupon->save();

            return response()->json(['message' => 'Coupon marked as used', 'coupon' => $coupon], 200);
        } else {
            return response()->json(['message' => 'Coupon not found or already used'], 404);
        }
    }


    public function deleteCoupons(Request $request)
    {
        try {
            $couponIds = $request->input('coupon_ids');

            DB::beginTransaction();
            Coupon::whereIn('id', $couponIds)->delete();
            DB::commit();

            return response()->json(['message' => 'A kuponok sikeresen törölve'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Valami hiba történt'], 500);
        }
    }
}
