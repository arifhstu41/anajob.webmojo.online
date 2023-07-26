<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Widget;
use Session;
class ChartController extends Controller
{
	public function get_chart_data(Request $request)
	{
		$siteid=$request->get('siteid');
				$duration=$request->get('chart_duration');
		
		$type=$request->get('type');
		$site=Site::where("id",$siteid)->first();

		 $lng=!empty($site)?$site->createdBy->lang:'en';

		$html=' <a href="#"id="'.route("site.dashboard.link",[\Illuminate\Support\Facades\Crypt::encrypt($site->id),$lng]).'" class="btn  btn-primary"  onclick="copyToClipboard(this)" data-bs-toggle="tooltip" title="{{__("Copy")}}" data-original-title="{{__("Click to copy")}}">Share Report</a>';
	    $arrConfig= [];
	    if($type=="mapcontainer")
	    {
	    	$arrMetrics = ['ga:newUsers' => 'Users'];

	        $arrConfig               = [];
	        $arrConfig['dimensions'] = [
	            'ga:latitude',
	            'ga:longitude',
	            'ga:country',
	        ];
	        $arrConfig['filter']     = [
	            [
	                'dimension' => 'ga:latitude',
	                'operator' => 'REGEXP',
	                'value' => '^[^0]',
	            ],
	        ];
	        $arrConfig['sort']       = [
	            'field' => 'ga:newUsers',
	            'order' => 'DESCENDING',
	        ];
	        $arrConfig['page_size']  = 100;

	        $analyticsData = $this->getReport($site, $arrMetrics, $arrConfig);

	        if($analyticsData['is_success'])
	        {
	            $arrProccessData = $this->printResults($analyticsData['data']);
	            $arrData         = [];
	            foreach($arrProccessData[0] as $record)
	            {
	                $location  = $record['dimensionHeaders'];
	                $arrData[] = [
	                    'latLng' => [
	                        floatval($location['ga:latitude']),
	                        floatval($location['ga:longitude']),
	                    ],
	                    'name' => $location['ga:country'] . "(" . $record['metrics']['Users'] . ")",
	                ];
	            }
	            $arrResult['is_success'] = 1;
	            $arrResult['data']       = $arrData;
	        }
	        else
	        {
	            $arrResult['is_success'] = 0;
	            $arrResult['message']    = $analyticsData['error']->error->message;
	        }
	       
	    }
	    else
	    {
	    	if($type=="bounceRateChart")
			{
				$arrMetrics = ['ga:bounceRate' => 'Bounce Rate'];
		        $arrParam =  $this->getDurationFromText($duration);
		        $arrConfig['dimensions'] = [$arrParam['dimension']];

			}
			if($type=="get_user_data")
			{
				$arrMetrics = ['ga:users' => 'Users'];
		        $arrParam =  $this->getDurationFromText($duration);
		        $arrConfig['dimensions'] = [$arrParam['dimension']];

			}
			if($type=="sessionDuration")
			{
				$arrMetrics = ['ga:sessionDuration' => 'Session Duration'];
		        $arrParam =  $this->getDurationFromText($duration);
		        $arrConfig['dimensions'] = [$arrParam['dimension']];
			}
			if($type=="session_by_device")
			{
				$arrMetrics              = ['ga:sessions' => 'Sessions'];
		        $arrParam                = $this->getDurationFromText('month');
		        $arrConfig['dimensions'] = ['ga:deviceCategory'];
			}
			if($type=="user-timeline-chart")
			{
	        	$arrMetrics = ['ga:users' => 'Users'];
		        $arrParam =  $this->getDurationFromText($duration);
	        	$arrConfig['dimensions'] = ['ga:userType',
	            	$arrParam['dimension'],
	        	];

			}
		         
		        $arrConfig['StartDate']  = $arrParam['StartDate'];
		        $arrConfig['EndDate']    = $arrParam['EndDate'];
		        $analyticsData= $this->getReport($site, $arrMetrics, $arrConfig);
		        if($analyticsData['is_success'])
		        {
		            $arrProccessData = $this->printResults($analyticsData['data']);

		            $arrKeys = [];
			         $arrData= [];
		            if($type=="session_by_device")
		            {
		            	$total = 0;
			            foreach($arrProccessData[0] as $record)
			            {
			                $total += $record['metrics']['Sessions'];
			            }

			            foreach($arrProccessData[0] as $record)
			            {
			                $per                   = ($record['metrics']['Sessions'] * 100) / $total;
			                $arrData['labels'][]    = ucfirst($record['dimensionHeaders']['ga:deviceCategory']);
			                $arrData['datasets'][] = (int)number_format($per, 1);
			            }
			            $arrResult['is_success'] = 1;
			            $arrResult['data']       = $arrData;
		            }
		            elseif($type=="user-timeline-chart")
		            {
		            	

			            
			            $arrColor['New Visitor']['backgroundColor'] = "transparent";
			            $arrColor['New Visitor']['borderColor']     = "#5e72e4";
			            $arrColor['New Visitor']['borderWidth']     = 4;
			            $arrColor['New Visitor']['tension']         = .4;

			            $arrColor['Returning Visitor']['backgroundColor'] = "transparent";
			            $arrColor['Returning Visitor']['borderColor']     = "#11cdef";
			            $arrColor['Returning Visitor']['borderWidth']     = 4;
			            $arrColor['Returning Visitor']['tension']         = .4;

			            $arrKeys = [];
			            foreach($arrParam['arrField'] as $key => $value)
			            {
			                $arrKeys[$key] = 0;
			            }

			            $arrData = [];
			            foreach($arrProccessData[0] as $record)
			            {
			                if(!array_key_exists($record['dimensionHeaders']['ga:userType'], $arrData))
			                {
			                    $arrData[$record['dimensionHeaders']['ga:userType']]         = [];
			                    $arrData[$record['dimensionHeaders']['ga:userType']]['data'] = $arrKeys;
			                }
			                $arrData[$record['dimensionHeaders']['ga:userType']]['data'][$record['dimensionHeaders'][$arrParam['dimension']]] = intval($record['metrics']['Users']);
			            }
			            $datasets = [];
			            $arrTotal = [];
			            foreach($arrData as $key => $data)
			            {
			                $tmpArray          = [];
			                $tmpArray['label'] = $key;
			                $tmpArray['data']  = array_reverse(array_values($data['data']));
			                $tmpArray          = array_merge($tmpArray, $arrColor[$key]);
			                $datasets[]        = $tmpArray;
			               $str_key=str_replace(" ","_",$key);
			                $arrTotal[$str_key]    = number_format(array_sum($data['data']));
			            }

			            $arrReturn             = [];
			            $arrReturn['labels']   = array_reverse(array_values($arrParam['arrField']));
			            $arrReturn['datasets'] = $datasets;

			            $arrResult['is_success'] = true;
			            $arrResult['data']       = $arrReturn;
			            $arrResult['total']      = $arrTotal;
		            }
		            else{
		            	foreach($arrParam['arrField'] as $key => $value)
			            {
			                $arrKeys[$key] = 0;
			            }

			            $arrData['cahart_data']['data'] = $arrKeys;

			            foreach($arrProccessData[0] as $record)
			            {
			            	if($type=="bounceRateChart")
							{
								$arrData['cahart_data']['data'][$record['dimensionHeaders'][$arrParam['dimension']]] = intval($record['metrics']['Bounce Rate']);
							}
							if($type=="get_user_data")
							{						
								$arrData['cahart_data']['data'][$record['dimensionHeaders'][$arrParam['dimension']]] = intval($record['metrics']['Users']);
							}
							if($type=="sessionDuration")
							{
								$arrData['cahart_data']['data'][$record['dimensionHeaders'][$arrParam['dimension']]] = intval($record['metrics']['Session Duration']);
							}
			                
			            }

			            $datasets = [];
			            $arrTotal = [];
			            foreach($arrData as $key => $data)
			            {
			                
			                $datasets = array_reverse(array_values($data['data']));
			                $arrTotal[$key]    = number_format(array_sum($data['data']));
			            }

			            $arrReturn             = [];
			            $arrReturn['labels']   = array_reverse(array_values($arrParam['arrField']));
			            $arrReturn['datasets'] = $datasets;

			            $arrResult['is_success'] = 1;
			            $arrResult['data']       = $arrReturn;
			            $arrResult['total']      = $arrTotal;
		            }
	            
	        }
	        else
	        {
	            $arrResult['is_success'] = 0;
	            $arrResult['message']    = $analyticsData['error']->error->message;
	        }
	    }
		$arrResult['link']      = $html;
		
	     return $arrResult;
		

	}
	public function live_user(Request $request)
	{
		$site=Site::where("id",$request->siteid)->first();
		$arrResult = $this->getLiveUser($site);
	}

	public function active_page(Request $request)
	{
		$siteid=$request->get('siteid');

		$site=Site::where("id",$siteid)->first();

		$arrMetrics              = [
            'ga:users' => 'Users',
            'ga:percentNewSessions' => '% New Sessions',
        ];
        $arrParam                = $this->getDurationFromText('month');
        $arrConfig               = [];
        $arrConfig['dimensions'] = ['ga:pagePath'];
        $arrConfig['StartDate']  = $arrParam['StartDate'];
        $arrConfig['EndDate']    = $arrParam['EndDate'];
        $arrConfig['sort']       = [
            'field' => 'ga:users',
            'order' => 'DESCENDING',
        ];
        $arrConfig['page_size']  = 10;
        $analyticsData           = $this->getReport($site, $arrMetrics, $arrConfig);

        if($analyticsData['is_success'])
        {
            $arrProccessData = $this->printResults($analyticsData['data']);
            $arrData         = [];
            foreach($arrProccessData[0] as $record)
            {
                $arrData[] = [
                    'PageUrl' => $record['dimensionHeaders']['ga:pagePath'],
                    'Users' => number_format($record['metrics']['Users']),
                    'NewSessions' => number_format($record['metrics']['% New Sessions'], 2),
                ];
            }
            $arrResult['is_success'] = 1;
            $arrResult['data']       = $arrData;
        }
        else
        {
            $arrResult['is_success'] = 0;
            $arrResult['message']    = $analyticsData['error']->error->message;
        }
     
        return $arrResult;
	}
}

