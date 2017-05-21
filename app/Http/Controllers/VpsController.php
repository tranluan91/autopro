<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vps;

class VpsController extends Controller
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

    public function create(Request $reqest)
    {
        $vpsList = [__('setting.vps_added')];
        $vpsList = array_merge($vpsList, Vps::orderBy('id', 'DESC')->pluck('ip')->toArray());

        return view('vps.create', compact([
            'vpsList'
        ]));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = \Validator::make($input, Vps::$rule);

        if ($validator->fails()) {
            return redirect('vps/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        if (!Vps::create($input)) {
            redirect()->back()->with('error', __('setting.vps_fail'));
        }

        return redirect()->back()->with('message', __('setting.vps_success'));
    }
}
