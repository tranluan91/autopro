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
        if ($request->ajax()) {
            $input = $request->all();
            $protocol = $input['protocol'];
            $validator = \Validator::make($input, Website::$rule);

            if ($validator->fails()) {
                $errors = $validator->getMessageBag();

                return response()->json(['status' => false, 'message' => $errors]);
            }
            $vps = Vps::find($input['vps_id']);
            if ($vps->website_deployed >= Vps::MAX_SITE_VPS) {
                return response()->json(['status' => false, 'message' => ['vps_id' => [__('setting.vps_max')]]]);
            }
            $input['status'] = Website::WAIT_DEPLOY;
            $web = Website::create($input);
            if (!$web) {
                return response()->json(['status' => false, 'message' => ['domain' => [__('setting.website_fail')]]]);
            }
            $website = Website::find($web->id);
            $vps = $website->vps;
            $result = self::runscript($website, $vps);
            if ($result == 0) {
                $vps->website_deployed += 1;
                $vps->save();

                return response()->json(['status' => true, 'message' => __('setting.web_deploy_success')]);
            }
            Website::destroy($website->id);

            return response()->json(['status' => false, 'message' => ['domain' => [__('setting.web_deploy_fail')]]]);
        }

        return redirect('/');
    }

    private static function runscript($website, $vps, $undeploy = false)
    {
        $script = "/bin/sh /opt/autodeploy/runme.sh -D '" . $website->domain .
            "' -W 'wp_template.zip' -h '" . $vps->ip . "' -p " . $vps->port .
            " -u '" . $vps->username . "' -P '" . $vps->password . "'";
        if ($undeploy) {
            $script .= ' --undeploy';
        }
        try {
            $process = new Process($script);
            $process->setTimeout(1200);
            $process->run();

            return $process->getOutput();
        } catch (\Exception $e) {
            return true;
        }
    }

    public function keyword(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $website = Website::find($input['website_id']);
            $website->keyword = $input['keyword'];
            $website->daily_deploy += 1;
            $website->sum_deploy += 1;
            $website->save();

            \Artisan::call('convert:data', [
                'domain' => $website->protocol . $website->domain,
                'key' => isset($input['keyword']) ? $input['keyword'] : '',
            ]);

            return ['status' => true];
        } else {
            return redirect('/home');
        }
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
            return redirect('websites/index')->with('message', __('setting.web_deploy_success'));
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

            return redirect('websites/index');
        }
        return redirect()->back()->with('error', __('setting.web_deploy_fail'));
    }

    public function edit($id)
    {
        $website = Website::findOrFail($id);
        $vpsList = [__('setting.choose')];
        $vpsList += Vps::orderBy('id', 'DESC')->pluck('ip', 'id')->toArray();

        return view('websites.edit', compact(['website', 'vpsList']));
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $protocol = $input['protocol'];
            $validator = \Validator::make($input, Website::ruleUpdate($input['id']));

            if ($validator->fails()) {
                $errors = $validator->getMessageBag();

                return response()->json(['status' => false, 'message' => $errors]);
            }
            $vps = Vps::find($input['vps_id']);
            $website = Website::findOrFail($input['id']);
            $web = $website;
            if ($website->vps_id != $vps->id && $vps->website_deployed >= Vps::MAX_SITE_VPS) {
                return response()->json(['status' => false, 'message' => ['vps_id' => [__('setting.vps_max')]]]);
            }
            $input['status'] = Website::WAIT_DEPLOY;
            $website->domain = $input['domain'];
            $website->protocol = $input['protocol'];
            $website->vps_id = $input['vps_id'];
            if (!$website->save()) {
                return response()->json(['status' => false, 'message' => ['domain' => [__('setting.website_fail')]]]);
            }
            $website = Website::find($web->id);
            $vps = $website->vps;
            $result = self::runscript($website, $vps);
            if ($result == 0) {
                $vps->website_deployed += 1;
                $vps->save();

                return response()->json(['status' => true, 'message' => __('setting.web_deploy_success')]);
            }
            Website::destroy($website->id);

            return response()->json(['status' => false, 'message' => ['domain' => [__('setting.web_deploy_fail')]]]);
        }

        return redirect('/');
    }
}
