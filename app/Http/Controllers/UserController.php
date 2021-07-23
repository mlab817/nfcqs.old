<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    /**
     * View list of system users.
     *
     * @return void
     */
    public function index()
    {
        $users = User::all();

        return view('users', compact('users'));
    }

    /**
     * Update user instance.
     *
     * @param  array  $data
     * @return User
     */
    protected function update(UserUpdateRequest $request, User $user)
    {
        $user->office = $request->office;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            return view('auth.register')
                ->with([
                    'msg' => "User account successfully updated."
                ]);
        } else {
            return "Error. Cauld not update user account.";
        }
    }

    /**
     * Edit user form.
     *
     * @param Request $request
     * @return void
     */
    public function edit(Request $request, User $user)
    {
        return view('edit-user', compact('user'));
    }

    /**
     * Change user access.
     *
     * @param Request $request
     * @return void
     */
    public function changeAccess(Request $request, User $user)
    {
       $updated = $user->update([
                'is_active' => $request->action
            ]);

        if ($updated) {
            return redirect('users');
        } else {
            return "Error. No change made to the account.";
        }
    }

    /**
     * Delete user.
     *
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request, User $user)
    {
        if ($user->delete()) {
            return [
                'error' => 0,
                'msg' => "User successfully deleted."
            ];
        } else {
            return [
                'error' => 1,
                'msg' => "Unable to delete this record."
            ];
        }
    }
}