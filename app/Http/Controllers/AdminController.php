<?php

namespace App\Http\Controllers;

use App\Models\CheckInCheckOut;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function viewAdmin(){
        return view('admin.admins.index');
     }
     public function getAdminData(Request $request)
     {
         // Base query to retrieve admin users
         $usersQuery = User::query()->where('role', 'staff');
     
         // Apply search filter if search query exists
         $search = $request->input('search.value');
         if ($search) {
             $usersQuery->where(function ($query) use ($search) {
                 $query->where('name', 'like', '%' . $search . '%')
                     ->orWhere('email', 'like', '%' . $search . '%');
             });
         }
     
         // Get the total count before pagination
         $totalCount = $usersQuery->count();
     
         // Apply pagination
         $start = $request->input('start', 0);
         $length = $request->input('length', 10);
         $usersQuery->skip($start)->take($length);
     
         // Retrieve users
         $users = $usersQuery->get();
     
         // Transform user data into a format suitable for JSON response
         $userData = $users->map(function ($user) {
             return [
                 'id' => $user->id,
                 'name' => $user->name,
                 'email' => $user->email,
                 // Add more attributes as needed
             ];
         });
     
         // Prepare the response data
         $data = [
             'draw' => $request->input('draw'),
             'recordsTotal' => $totalCount,
             'recordsFiltered' => $totalCount, // No filtering applied in this example
             'data' => $userData,
         ];
     
         // Return the JSON response
         return response()->json($data);
     }
  
 
     // Store new user
     public function store(Request $request)
     {
         $validatedData = $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|email|unique:users',
             'password' => 'required|string|min:8|confirmed',
             'role'=>'required'
         ]);
 
         $user = User::create($validatedData);
         return response()->json(['message' => 'User created successfully']);
     }
     public function show($id)
     {
         $user = User::findOrFail($id);
         return response()->json($user);
     }
     // Update user
     public function update(Request $request, $id)
     {
         $validatedData = $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|email|unique:users,email,'.$id,
         ]);
     
         $user = User::findOrFail($id);
         $user->update($validatedData);
      if($user->role=='student'){
         // Compare selected courses with the user's current courses
         $currentCourses = $user->courses->pluck('id')->toArray();
         $newCourses = $request->input('courses', []);
     
         // Courses to detach (deselected)
         $coursesToDetach = array_diff($currentCourses, $newCourses);
     
         // Sync courses if provided in the request
         if (!empty($newCourses)) {
             $user->courses()->sync($newCourses);
         } else {
             // If no courses are selected, detach all existing courses
             $user->courses()->detach();
         }
     
         // Detach deselected courses
         if (!empty($coursesToDetach)) {
             $user->courses()->detach($coursesToDetach);
         }
      }
         return response()->json(['message' => 'User updated successfully']);
     }
 
     // Delete user
     public function destroy($id)
     {
         $user = User::findOrFail($id);
         $user->delete();
 
         return response()->json(['message' => 'User deleted successfully']);
     }
    public function Setting(){
        $settings = Setting::first();
        return view('admin.setting',compact('settings'));
    }
    public function settingStore(Request $request){
        $request->validate([
            'app_title' => 'required|string',
            'app_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'login_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $settings = Setting::first();
        if (!$settings) {
            $settings = new Setting();
        }
    
        $settings->app_title = $request->app_title;
    $settings->footer_title = $request->footer_text;
        if ($request->hasFile('app_logo')) {
            $settings->app_logo = $request->file('app_logo')->store('public/logos');
        }
    
        if ($request->hasFile('login_logo')) {
            $settings->login_logo = $request->file('login_logo')->store('public/logos');
        }
    
        if ($request->hasFile('favicon_logo')) {
            $settings->favicon_logo = $request->file('favicon_logo')->store('public/logos');
        }
    
        $settings->save();
    
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
    public function showCheckInOut($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.checkinout', compact('user'));
    }

    public function exportCheckInOut($id)
    {
        return exportAllCheckInOutDetails($id);
    }
    public function getUserDetails($id, Request $request)
    {
        if ($request->ajax()) {
            $detailsQuery = CheckInCheckOut::where('user_id', $id);
    
            // Apply search filter if search query exists
            $search = $request->input('search.value');
            if ($search) {
                $detailsQuery->where(function ($query) use ($search) {
                    $query->where('check_in', 'like', '%' . $search . '%')
                          ->orWhere('check_out', 'like', '%' . $search . '%');
                });
            }
    
            // Get the total count before pagination
            $totalCount = $detailsQuery->count();
    
            // Apply pagination
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $detailsQuery->skip($start)->take($length);
    
            // Retrieve check-in/out details
            $details = $detailsQuery->get();
    
            // Transform details data into a format suitable for JSON response
            $detailsData = $details->map(function ($detail) {
                return [
                    'check_in' => $detail->check_in,
                    'check_out' => $detail->check_out,
                ];
            });
    
            // Prepare the response data
            $data = [
                'draw' => $request->input('draw'),
                'recordsTotal' => $totalCount,
                'recordsFiltered' => $totalCount, // Adjust if search is implemented
                'data' => $detailsData,
            ];
    
            // Return the JSON response
            return response()->json($data);
        }
    
        $user = User::findOrFail($id);
        return view('admin.users.checkinout', compact('user'));
    }
    public function editProfile(){
        return view('admin.editprofile');
    }
    public function updateProfile(Request $request) {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Get the current user
        $user = auth()->user();
    
        // Update name and email
        $user->name = $request->input('name');
        $user->email = $request->input('email');
    
        // Handle profile image upload
       // Handle profile image upload
       if ($request->hasFile('profile_image')) {
        // Delete the old profile image if exists
        if ($user->profile_image) {
            Storage::delete('public/profile/profile_images/' . $user->profile_image);
        }
    
        $image = $request->file('profile_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/profile/profile_images', $imageName);
        $user->profile_image = $imageName;
    }
    
        // Save the updated user
        $user->save();
    
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    public function changePassword(){
        return view('admin.change_password');
    }
    public function passwordStore(Request $request){
        $user = Auth::user();
        $currentPassword = $user->password;
        $newPassword = $request->new_password;
        $confirmPassword = $request->new_password_confirmation;
    
        // Validate the input
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($currentPassword) {
                if (!Hash::check($value, $currentPassword)) {
                    return $fail(__('The :attribute is incorrect.'));
                }
            }],
            'new_password' => 'required|min:8|confirmed',
        ]);
    
        // Update the password
        $user->password = Hash::make($newPassword);
        $user->save();
    
        return back()->with('success', 'Password updated successfully!');
    }
}
