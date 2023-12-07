<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use Auth;
use Validator;
use Session;
use Newsletter;


class UserController extends Controller
{
    public function loginRegister()
    {
        return view('front.users.login_register');
    }

    public function userRegister(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:150|unique:users',
                'password' => 'required|min:8',
            ]
        );

        if ($validator->passes()) {
            //Register the user            
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->status = 1;
            $user->save();

            // if(!Newsletter::isSubscribed($request->email)) {
            Newsletter::subscribe($request->email);
            //}

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $redirectTo = url('user/account');
                return response()->json(['url' => $redirectTo]);
            }
        }
    }

    public function userAccount(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:100',
                    'mobile' => 'required|numeric|digits:12',
                    'address' => 'required|string|max:100',
                ]
            );

            if ($validator->passes()) {

                //Update user details
                User::where('id', Auth::user()->id)->update(['name' => $data['name'], 'birthdate' => $data['birthdate'], 'religion' => $data['religion'], 'mobile' => $data['mobile'], 'email' => $data['email'], 'address' => $data['address']]);

                //Redirect back user with success message
                return response()->json(['type' => 'success', 'message' => 'Data Anda berhasil diperbarui']);
            } else {
                return response()->json(['type' => 'error', 'errors' => $validator->messages()]);
            }
        } else {
            return view('front.users.user_account');
        }
    }

    public function userUpdatePassword(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            $validator = Validator::make(
                $request->all(),
                [
                    'current_password' => 'required',
                    'new_password' => 'required|min:6',
                    'confirm_password' => 'required|min:6|same:new_password'

                ]
            );

            if ($validator->passes()) {

                $current_password = $data['current_password'];
                $checkPassword = User::where('id', Auth::user()->id)->first();
                if (Hash::check($current_password, $checkPassword->password)) {

                    // Update User Current Password
                    $user = User::find(Auth::user()->id);
                    $user->password = bcrypt($data['new_password']);
                    $user->save();

                    // Redirect back user with success message
                    return response()->json(['type' => 'success', 'message' => 'Password akun Anda berhasil diperbarui']);
                } else {
                    // Redirect back user with error message
                    return response()->json(['type' => 'incorrect', 'message' => 'Password lama yang Anda masukkan salah']);
                }


                // Redirect back user with success message
                return response()->json(['type' => 'success', 'message' => 'Your contact/billing details successfully updated!']);
            } else {
                return response()->json(['type' => 'error', 'errors' => $validator->messages()]);
            }
        } else {
            return view('front.users.user_account');
        }
    }

    public function userLogin(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150|exists:users',
                'password' => 'required',
            ]);

            if ($validator->passes()) {
                if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {

                    if (Auth::user()->status == 0) {
                        Auth::logout();
                        return response()->json(['type' => 'inactive', 'message' => 'Akun Anda saat ini tidak aktif. Silahkan hubungi Admin']);
                    }

                    // Update user cart with user id
                    if (!empty(Session::get('session_id'))) {
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id' => user_id]);
                    }

                    $redirectTo = url('/');
                    return response()->json(['type' => 'success', 'url' => $redirectTo]);
                } else {
                    return response()->json(['type' => 'incorrect', 'message' => 'E-mail atau Password yang Anda masukkan salah']);
                }
            } else {
                return response()->json(['type' => 'error', 'errors' => $validator->messages()]);
            }
        }
    }

    public function userLogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
