<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\Vps;

class WebsitesController extends Controller
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
        $websites = [__('setting.website_added')];
        $websites +=  Website::orderBy('id', 'DESC')->pluck('domain', 'id')->toArray();
        $vpsList = [__('setting.choose')];
        $vpsList += Vps::orderBy('id', 'DESC')->pluck('ip', 'id')->toArray();

        return view('websites.create', compact([
            'websites',
            'vpsList',
        ]));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = \Validator::make($input, Website::$rule);

        if ($validator->fails()) {
            return redirect('websites/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $input['status'] = Website::WAIT_DEPLOY;
        if (!Website::create($input)) {
            redirect()->back()->with('error', __('setting.vps_fail'));
        }

        return redirect()->back()->with('message', __('setting.website_success'));
    }
}
