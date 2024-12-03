<?php

namespace App\Http\Controllers;

use App\Models\UserAcc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function index(){
        return view('pages.accounts.account');
    }

    public function create(){
        return view('pages.accounts.add');
    }

    public function store(Request $request)
    {

        $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:user_accs,email',
            'password' => 'required|min:8|regex:/[A-Z]/|regex:/[0-9]/|regex:/[\W_]/', // Enforcing password rules
            'role' => 'required|integer'
        ]);

        UserAcc::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => $request->password, // Your model already handles the hashing
            'role' => $request->role
        ]);

        return redirect()->route('account')->with('success', 'Account created successfully');
    }

    public function getData(Request $request){
        $searchTerm = $request->input('search');

        $query = UserAcc::query();

        if($searchTerm){
            $query->where(function ($innerQuery) use ($searchTerm) {

                $normalizedSearchTerm = strtolower($searchTerm);

                $innerQuery->where('id', 'like', "%{$searchTerm}%")
                ->orWhere('name', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%")
                ->orWhere(function ($q) use ($normalizedSearchTerm) {
                    if ($normalizedSearchTerm === 'staff') {
                        $q->where('role', '1'); // Assuming '0' is the role ID for 'staff'
                    } elseif ($normalizedSearchTerm === 'admin') {
                        $q->where('role', '2'); // Assuming '1' is the role ID for 'admin'
                    } elseif ($normalizedSearchTerm === 'super admin' || $normalizedSearchTerm === 'super') {
                        $q->where('role', '3'); // Assuming '2' is the role ID for 'super admin'
                    }
                });
            });
        }

        $account = $query->paginate(10);
        return response()->json($account);

    }

    public function edit(string $user_id){
        $findAccount = UserAcc::find($user_id);

        if (!$findAccount) {
             return view('errors.404');
        }

        return view('pages.accounts.edit', compact('findAccount'));
    }

    public function update(Request $request, $id)
    {
        $user = UserAcc::findOrFail($id);

        Log::info("user: ", [$user]);

        $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:user_accs,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed|regex:/[A-Z]/|regex:/[0-9]/|regex:/[\W_]/',
            'role' => 'required|integer'
        ]);

        Log::info("Hello World!");

        $user->name = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->role = $request->role;
        $user->save();

        return redirect()->route('account')->with('success', 'Account updated successfully');
    }

    public function delete(Request $request){
        try{
            $userID =  $request->input('userId');

            $user = UserAcc::findOrFail($userID);

            $user->delete();

            return response()->json([
                'message' => 'The account has been deleted successfully',
                'icon' => 'success',
                'title' => 'Success'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete user'], 500);
        }
    }
}
