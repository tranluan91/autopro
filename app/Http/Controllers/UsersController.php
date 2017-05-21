<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changePassword(Request $request)
    {
        return view('users.changePassword');
    }

    public function updatePassword(Request $request)
    {
        $messages = [
            'password.required' => __('setting.old_pass_.require'),
            'new_password.required' => __('setting.new_pass_.require'),
            'new_password.min.string' => __('setting.new_pass_.valid'),
            'new_password.confirmed' => __('setting.new_pass_confirm_.match'),
            'new_password_confirmation.required' => __('setting.new_pass_confirm_.require'),
        ];
        $input = $request->all();
        $validator = \Validator::make($input, User::$rule, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        if (!\Hash::check($input['password'], \Auth::user()->password)) {
            return redirect()->back()->with('error', __('setting.old_pass_.match'));
        }
        $user = User::find(\Auth::user()->id);
        $user->password = bcrypt($input['new_password']);
        $user->save();

        return redirect()->back()->with('message', __('setting.change_password_success'));
    }
}
