<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SunAccount;

class SunAccountsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin', ['except' => 'index']);
    }

    public function index()
    {
        if (!\Auth::user()) {
            return redirect('/');
        }
        $sunAccounts = SunAccount::orderBy('id',  'DESC')->paginate(10);

        return view('suns.index', compact(['sunAccounts']));
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request)
    {
    }

    public function create()
    {
        return view('suns.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = \Validator::make($input, SunAccount::$rule);

        if ($validator->fails()) {
            return redirect('sun/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        if (!SunAccount::create($input)) {
            redirect()->back()->with('error', __('setting.sun_fail'));
        }

        return redirect('sun')->with('message', __('setting.sun_success'));
    }

    public function destroy(Request $request)
    {
    }
}
