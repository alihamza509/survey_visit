<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CheckInCheckOut;
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;

class CheckInCheckOutController extends Controller
{
    use ApiResponse;

    public function checkInOut(Request $request)
    {
        $user = Auth::user();

        try {
            if ($user->checkin) {
                // User is checking out
                $existingCheckIn = CheckInCheckOut::where('user_id', $user->id)->whereNull('check_out')->first();

                if ($existingCheckIn) {
                    $existingCheckIn->update([
                        'check_out' => now(),
                    ]);
                    $user->update(['checkin' => 0]);
                    return $this->success($existingCheckIn, 'Checked out successfully');
                } else {
                    return $this->error('No active check-in found', 400);
                }
            } else {
                // User is checking in
                $checkIn = CheckInCheckOut::create([
                    'user_id' => $user->id,
                    'check_in' => now(),
                ]);
                $user->update(['checkin' => 1]);
                return $this->success($checkIn, 'Checked in successfully');
            }
        } catch (Exception $e) {
            return $this->error('An error occurred during check-in/check-out', 500);
        }
    }
    public function index(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return $this->error('Unauthorized', 401);
        }
    
        $user = $request->user(); // or Auth::user()
    
        // Retrieve the latest check-in or check-out record for the authenticated user
        try {
            $latestCheckInCheckOut = CheckInCheckOut::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->first();
    
            // Check if a record was found
            if (!$latestCheckInCheckOut) {
                return $this->error('No check-in or check-out record found', 404);
            }
    
            return $this->success($latestCheckInCheckOut, 'Latest check-in or check-out record retrieved successfully');
        } catch (Exception $e) {
            return $this->error('An error occurred while retrieving the record', 500);
        }
    }
}
