<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\Vps;
use App\Models\SunAccount;
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
        $suns = [__('setting.choose')];
        $suns += SunAccount::orderBy('id', 'DESC')->pluck('sun_id', 'id')->toArray();

        return view('websites.create', compact([
            'websites',
            'vpsList',
            'suns',
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
        } else {
            $script .= ' --id-sale ' . $website->sunAccount->sun_id;
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
            if ($input['keyword']) {
                $website->keyword = ($website->keyword) ? $website->keyword  . ',' . $input['keyword'] : $input['keyword'];
            }
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
        if ($result == 0) {
            $request->session()->flash('message', __('setting.undeploy_success'));

            return redirect('websites/index');
        }
        return redirect()->back()->with('error', __('setting.web_deploy_fail'));
    }

    public function delete()
    {
        $websites = Website::orderBy('id',  'DESC')->paginate(10);

        return view('websites.delete', compact(['websites']));
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->get('id');
            $website = Website::findOrFail($id);
            $protocol = $website->protocol;
            $vps = $website->vps;
            $result = self::runscript($website, $vps, $undeploy = true);
            if ($result != 0) {
                $request->session()->flash('error', __('setting.undeploy_fail'));

                return redirect('websites/delete');
            }
            $vps->website_deployed -= 1;
            $vps->save();
            $website->delete();

            $request->session()->flash('message', __('setting.undeploy_success'));
        } catch (Exception $e) {
            $request->session()->flash('error', __('setting.undeploy_fail'));
        }

        return redirect('websites/delete');
    }
}
