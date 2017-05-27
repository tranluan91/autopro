<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\Vps;
use Symfony\Component\Process\Process;

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
        $protocol = $input['protocol'];
        $validator = \Validator::make($input, Website::$rule);

        if ($validator->fails()) {
            return redirect('websites/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $vps = Vps::find($input['vps_id']);
        if ($vps->website_deployed >= Vps::MAX_SITE_VPS) {
            return redirect()->back()->with('error', __('setting.vps_max'));
        }
        $input['status'] = Website::WAIT_DEPLOY;
        $web = Website::create($input);
        if (!$web) {
            return redirect()->back()->with('error', __('setting.vps_fail'));
        }
        $website = Website::find($web->id);
        $vps = $website->vps;
        $result = self::runscript($website, $vps);
        if (!$result) {
            $vps->website_deployed += 1;
            $vps->save();

            $request->session()->flash('message', __('setting.web_deploy_success'));
            return view('websites.keyword', compact(['website', 'protocol']));
        }
        Website::destroy($website->id);

        return redirect()->back()->with('error', __('setting.web_deploy_fail'));
    }

    private static function runscript($website, $vps, $undeploy = false)
    {
        $script = "/bin/sh /opt/autodeploy/runme.sh -D '" . $website->domain .
            "' -W 'wp_template.zip' -h '" . $vps->ip . "' -p " . $vps->port .
            " -u '" . $vps->username . "' -P '" . $vps->password . "'";
        if ($undeploy) {
            $script .= ' --undeploy';
        }
        $process = new Process($script);
        $process->setTimeout(1200);
        $process->run();

        return $process->getOutput();
    }

    public function keyword(Request $request)
    {
        $input = $request->all();
        $website = Website::find($input['id']);
        $website->keyword = $input['keyword'];
        $website->save();

        \Artisan::call('convert:data', [
            'domain' => $input['protocol'] . $input['domain'],
            'key' => isset($input['keyword']) ?: '',
        ]);

        return redirect('/home');
    }

    public function index()
    {
        $websites = Website::orderBy('id',  'DESC')->paginate(10);

        return view('websites.index', compact(['websites']));
    }

    public function redeploy(Request $request)
    {
        $websiteId = $request->get('id');
        $website = Website::find($websiteId);
        $protocol = $website->protocol;
        $vps = $website->vps;
        $result = self::runscript($website, $vps);
        if (!$result) {
            $request->session()->flash('message', __('setting.web_deploy_success'));

            return view('websites.keyword', compact(['website', 'protocol']));
        }
        return redirect()->back()->with('error', __('setting.web_deploy_fail'));
    }

    public function continuedeploy(Request $request)
    {
        $websiteId = $request->get('id');
        $website = Website::find($websiteId);
        \Artisan::call('convert:data', [
            'domain' => $website->protocol . $website->domain,
            'key' => $website->keyword,
        ]);

        return redirect('/home');
    }

    public function undeploy(Request $request)
    {
        $websiteId = $request->get('id');
        $website = Website::find($websiteId);
        $protocol = $website->protocol;
        $vps = $website->vps;
        $result = self::runscript($website, $vps, true);
        if (!$result) {
            $request->session()->flash('message', __('setting.undeploy_success'));

            return view('websites.index', compact(['website']));
        }
        return redirect()->back()->with('error', __('setting.web_deploy_fail'));
    }
}
