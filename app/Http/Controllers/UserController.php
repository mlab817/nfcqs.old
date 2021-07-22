<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;

class UserController extends Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'office' => 'required|max:100',
            'full_name' => 'required|max:50',
            'email' => 'required|email|max:60|unique:users,email,' . $data['id'],
            'password' => 'required|min:6',
            'password_confirmation' => 'same:password'
        ]);
    }

    /**
     * Update user instance.
     *
     * @param  array  $data
     * @return User
     */
    protected function update(array $data)
    {
        $user = User::find($data['id']);

        $user->office = $data['office'];
        $user->full_name = $data['full_name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);

        return $user->save();
    }

    /**
     * View list of system users.
     *
     * @return void
     */
    public function list()
    {
        $users = DB::table('users')
            ->where('user_type', '<>', 0)
            ->get();

        if (Auth::user()->user_type != 0) {
            return redirect('/');
        }

        return view('users')
            ->with([
                'users' => $users
            ]);
    }

    /**
     * Edit user form.
     *
     * @param Request $request
     * @return void
     */
    public function editUserForm(Request $request)
    {
        $user = DB::table('users')
            ->where('id', $request->input('id'))
            ->first();

        return view('edit-user')
            ->with([
                'user' => $user,
                'id' => $request->input('id')
            ]);
    }

    /**
     * Update user.
     *
     * @param Request $request
     * @return void
     */
    public function updateUser(Request $request)
    {
        // validate details
        if ($this->validator($request->all())->fails()) {
            return redirect('user/edit?id=' . $request->input('id'))
                ->withInput()
                ->withErrors($this->validator($request->all()));
        }

        // update user user
        $updated = $this->update($request->all());

        // check if user account is updated
        if ($updated) {
            return view('auth.register')
                ->with([
                    'msg' => "User account successfully updated."
                ]);
        } else {
            return "Error. Cauld not update user account.";
        }
    }

    /**
     * Change user access.
     *
     * @param Request $request
     * @return void
     */
    public function changeAccess(Request $request)
    {
        if (Auth::user()->user_type == 0) {

            $updated = DB::table('users')
                ->where('id', $request->input('id'))
                ->update([
                    'is_active' => $request->input('action')
                ]);

            if ($updated) {
                return redirect('users');
            } else {
                return "Error. No changed made to the account.";
            }

        } else {
            return "Access denied.";
        }
    }

    /**
     * Delete user.
     *
     * @param Request $request
     * @return void
     */
    public function deleteUser(Request $request)
    {
        if (Auth::user()->user_type == 0) {
            $user = User::find($request->input('id'));
            
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
        } else {
            return [
                'error' => 1,
                'msg' => "Access denied."
            ];
        }
    }
}