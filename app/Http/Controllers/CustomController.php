<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Plan;
use App\Models\Widget;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Session;
class CustomController extends Controller
{
    public function custom_dashboard()
    {
        if(\Auth::user()->can('show custom analytic'))
        {
            $metrics=$this->metric_option();
            $user=Auth::user();
            if(\Auth::user()->user_type !='company')
            {
                $site_data=Site::where('created_by',$user->created_by)->get();
            }
            else
            {
                $site_data=Site::where('created_by',$user->id)->get();
            }
            
            return view('admin.custom.default')->with("site_data",$site_data)->with("metrics",$metrics); 
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    	
    }

     public function get_dimension()
    {
    	$metrics=$this->dimension();

                                    
    	$html="<option selected disabled value='0'>Dimension</option>";
    	foreach ($metrics as $key => $value) {
    		$html.="<option value='".$key."'  data-name=".$value.">".$value."</option>";
    	}

    	return $html;
    	
    }

    public function custom_chart(Request $request)
    {
    	$site=Site::where("id",$request->get('site_id'))->first();
    	$metrics    = ucfirst(str_replace("ga:", "", $request->get('metric')));
        $dimension  = ucfirst(str_replace("ga:", "", $request->get('dimension')));
        $arrMetrics = [$request->get('metric') => $request->get('metric')];

        $arrParam = $this->getDurationFromText($request->get('chart_duration'));

        $tmpDate = explode("-", $request->get('chart_duration'));

        $arrConfig               = [];
        $arrConfig['StartDate']  = date('Y-m-d', strtotime($tmpDate[0]));
        $arrConfig['EndDate']    = date('Y-m-d', strtotime($tmpDate[1]));
        $arrConfig['dimensions'] = [$_POST['dimension']];
        $arrConfig['sort']       = [
            'field' => $request->get('metric'),
            'order' => 'DESCENDING',
        ];
        $arrConfig['page_size']  = 13;

        $analyticsData = $this->getReport($site, $arrMetrics, $arrConfig);

        if($analyticsData['is_success'])
        {
            $arrProccessData = $this->printResults($analyticsData['data']);
            $arrData         = [];
            foreach($arrProccessData[0] as $record)
            {
                $arrData[$record['dimensionHeaders'][$request->get('dimension')] ]= intval($record['metrics'][$request->get('metric')]);
            }

            $arrReturn               = [];
            $arrReturn['labels']     = array_keys($arrData);
            $arrReturn['datasets'][] = [
                'label' => $dimension,
                'data' => array_values($arrData),
                'backgroundColor' => "rgba(94, 113, 228, 1)",
            ];
            $arrResult['data']       = $arrReturn;
            $arrResult['is_success'] = 1;
        }
        else
        {
            $arrResult['is_success'] = 0;
            $arrResult['message']    = $analyticsData['error']->error->message;
        }
        return $arrResult;
    }
     public function custom_share_chart(Request $request)
    {

        $site=Site::where("id",$request->get('id'))->first();
        if(!empty($site->share_setting))
        {
             $json=json_decode($site->share_setting);
        
            $metrics    = ucfirst(str_replace("ga:", "", $json->custom->share_metric));
            $dimension  = ucfirst(str_replace("ga:", "", $json->custom->share_dimension));
            $arrMetrics = [$json->custom->share_metric => $json->custom->share_metric];

            $arrParam = $this->getDurationFromText($request->get('chart_duration'));

            $tmpDate = explode("-", $request->get('chart_duration'));

            $arrConfig               = [];
            $arrConfig['StartDate']  = date('Y-m-d', strtotime($tmpDate[0]));
            $arrConfig['EndDate']    = date('Y-m-d', strtotime($tmpDate[1]));
            $arrConfig['dimensions'] = [$json->custom->share_dimension];
            $arrConfig['sort']       = [
                'field' => $json->custom->share_metric,
                'order' => 'DESCENDING',
            ];
            $arrConfig['page_size']  = 13;

            $analyticsData = $this->getReport($site, $arrMetrics, $arrConfig);

            if($analyticsData['is_success'])
            {
                $arrProccessData = $this->printResults($analyticsData['data']);
                $arrData         = [];
                foreach($arrProccessData[0] as $record)
                {
                    $arrData[$record['dimensionHeaders'][$json->custom->share_dimension] ]= intval($record['metrics'][$json->custom->share_metric]);
                }

                $arrReturn               = [];
                $arrReturn['labels']     = array_keys($arrData);
                $arrReturn['datasets'][] = [
                    'label' => $dimension,
                    'data' => array_values($arrData),
                    'backgroundColor' => "rgba(94, 113, 228, 1)",
                ];
                $arrResult['data']       = $arrReturn;
                $arrResult['is_success'] = 1;
            }
            else
            {
                $arrResult['is_success'] = 0;
                $arrResult['message']    = $analyticsData['error']->error->message;
            }
            return $arrResult;
        }
       
    }
}
