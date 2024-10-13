<?php

use App\Models\CheckInCheckOut;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

if (!function_exists('getUserProfileImage')) {
    function getUserProfileImage() {
        $user = auth()->user();

        if ($user && $user->profile_image) {
            return asset('storage/profile/profile_images/' . $user->profile_image);
        } else {
            return asset('images/default-profile-image.jpg'); // Path to your default profile image
        }
    }
}

    if (!function_exists('exportAllCheckInOutDetails')) {
        function exportAllCheckInOutDetails($userId)
        {
            return Excel::download(new class($userId) implements FromCollection, WithHeadings, WithMapping {
                protected $userId;
    
                public function __construct($userId)
                {
                    $this->userId = $userId;
                }
    
                public function collection()
                {
                    return CheckInCheckOut::where('user_id', $this->userId)->get();
                }
    
                public function headings(): array
                {
                    return [
                        'User ID',
                        'User Name',
                        'Check-In Time',
                        'Check-Out Time',
                        'Duration',
                    ];
                }
    
                public function map($checkInCheckOut): array
                {
                    $checkIn = new \DateTime($checkInCheckOut->check_in);
                    $checkOut = new \DateTime($checkInCheckOut->check_out);
                    $interval = $checkIn->diff($checkOut);
    
                    $user = User::find($checkInCheckOut->user_id);
    
                    return [
                        $checkInCheckOut->user_id,
                        $user ? $user->name : 'Unknown',
                        $checkIn->format('d M Y, H:i:s'),
                        $checkOut->format('d M Y, H:i:s'),
                        $interval->format('%h hours %i minutes %s seconds'),
                    ];
                }
            }, 'checkinout-details.xlsx');
        }
    }

