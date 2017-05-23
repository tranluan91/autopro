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
        $vpsList += Vps::orderBy('id', 'DESC')->pluck('ip', 'id')->toArray();

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

    public function edit($id)
    {
        $vps = Vps::findOrFail($id);

        return view('vps.edit', compact([
            'vps',
        ]));
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $vps = Vps::findOrFail($input['id']);
        $validator = \Validator::make($input, Vps::rule($input['id']));

        if ($validator->fails()) {
            return redirect('vps/' . $input['id'] . '/edit')
                        ->withErrors($validator)
                        ->withInput();
        }
        $vps->ip = $input['ip'];
        $vps->username = $input['username'];
        $vps->password = $input['password'];
        $vps->port = $input['port'];
        if ($vps->save()) {
            return redirect()->back()->with('message', __('setting.edit_vps_success'));
        }

        return redirect()->back()->with('error', __('setting.edit_vps_fail'));
    }

    public function destroy($id)
    {
        if (Vps::destroy($id)) {
            return redirect('vps/create')->with('message', __('setting.delete_vps_success'));
        }

        return redirect()->back()->with('error', __('setting.delete_vps_fail'));
    }
}
