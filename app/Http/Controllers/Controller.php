<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Google_Client;
use Google_Service_Analytics;
use Session;
use Google_Service_AnalyticsReporting;
use Google_Service_AnalyticsReporting_DateRange;
use Google_Service_AnalyticsReporting_Metric;
use Google_Service_AnalyticsReporting_ReportRequest;
use Google_Service_AnalyticsReporting_GetReportsRequest;
use Google_Service_AnalyticsReporting_Dimension;
use Google_Service_AnalyticsReporting_OrderBy;
use Google_Service_AnalyticsReporting_Segment;
use Google_Service_AnalyticsReporting_DimensionFilter;
use Google_Service_AnalyticsData;
use Google_Service_AnalyticsData_RunRealtimeReportRequest;
use Google_Service_AnalyticsReporting_DimensionFilterClause;
use Google_Service_AnalyticsData_Metric;
use App\Models\Site;
use App\Models\User;
use App\Models\Credintials;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   public function authmain($user_id=0)
    {

           
            if($user_id==0)
            {
                $user= Auth::user();

            }
            else
            {
                $user= User::find($user_id);

            }
            if($user)
            {
                //dd("---------------");
        
                if($user->user_type == 'company')
                {
                    $credintial=Credintials::where("user_id",$user->id)->first();
                }
                else{
                    $credintial=Credintials::where("user_id",$user->created_by)->first();
                }
            }
            else
            {
                try {
                    $currenturl=explode('/link/', url()->previous());
               
                    $link_typeurl=explode('/', $currenturl[0]);
                    $link_type=end($link_typeurl);
                    $arr=explode('/', $currenturl[1]);
                    $id=$arr[0];
                  
                    $id = \Illuminate\Support\Facades\Crypt::decrypt($id);
                    if($link_type=='quickview')
                    {
                        $data=User::where('id',$id)->first();
                        if($data->user_type=='company')
                        {
                            $credintial=Credintials::where("user_id",$data->id)->first();
                        }
                        else
                        {
                            $credintial=Credintials::where("user_id",$data->created_by)->first();
                        }  
                    }
                    else
                    {
                        $data=Site::where('id',$id)->first();
                        $credintial=Credintials::where("user_id",$data->created_by)->first();
                    }
                } catch (Exception $e) {
                    return view('share-link.error');
                }
            }

            $file_name='credintial_' . time() . rand() . '.json';
            $directory = storage_path('uploads/');
            $file = $directory . $file_name;
            touch($file);
            file_put_contents($file, $credintial->json);
            if(file_exists($file)){
                $client = new Google_Client();
                $client->setAuthConfig(storage_path('uploads/'.$file_name));
                $client->setRedirectUri(''.url('/').'/oauth2callback');
                $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
                $client->setAccessType('offline');
                $directory = storage_path('uploads/');
                File::deleteDirectory($directory, true);
                return $client;
            }
           else{
            return 0;
           }
    }

    function gaDateFormat($date)
    {
        $year = substr($date, 0, 4) . '-' . substr($date, 4);
        $date = substr($year, 0, 7) . '-' . substr($year, 7);

        return $date;
    }

    public function metric_option()
    {
        $metric_option = [
             "ga:avgSessionDuration" => "Session Time",
                "ga:users" => "Users",
                "ga:sessions" => "Sessions",
                "ga:newUsers" => "New Users",
                "ga:pageviews" => "Page Views",
                "ga:bounceRate" => "Bounce Rate",
                "ga:percentNewSessions" => "New Session %",
                "ga:goalCompletionsAll" => "All goals",
                "ga:goalConversionRateAll" => "All Goals CR %",
                "ga:goalValueAll" => "All goals value",
                "ga:totalEvents" => "Total Events",
                "ga:transactions" => "All transactions",
                "ga:transactionRevenue" => "All transaction revenue",
                "ga:transactionRevenuePerSession" => "Avg. revenue per session",
        ];
        return $metric_option;
    }
    public function arrUsableMetrics()
    {
        $arrUsableMetrics = [
            "ga:sessions" => "sessions",
            "ga:users" => "users",
            "ga:newUsers" => "newUsers",
            "ga:pageviews" => "pageviews",
            "ga:pageviewsPerSession" => "pageviewsPerSession",
            "ga:entranceRate" => "entranceRate",
            "ga:percentNewSessions" => "percentNewSessions",
            "ga:exitRate" => "exitRate",
            "ga:bounceRate" => "bounceRate",
            "ga:goalCompletionsAll" => "goalCompletionsAll",
        ];
        return $arrUsableMetrics;
    }
    public function arrTimeframe()
    {
        $arrTimeframe = [
            'today' => 'Today',
            'yesterday' => 'Yesterday',
            '7daysAgo' => 'Last 7 days',
            '15daysAgo' => 'Last 15 days',
            '30daysAgo' => 'Last 30 days',
        ];
        return $arrTimeframe;
    }
    public function dimension()
    {
        $dimension=[
            'ga:userType' => 'User Type',
            'ga:medium' => 'Medium',
            'ga:source' => 'Source',
            'ga:keyword' => 'Keyword',
            'ga:socialNetwork' => 'Social Network',
            'ga:browser' => 'Browser',
            'ga:operatingSystem' => 'Operating System',
            'ga:deviceCategory' => 'Device Category',
            'ga:language' => 'Language',
            'ga:screenResolution' => 'Screen Resolution',
        ];
        return $dimension;
    }

     public function date_filter_option()
    {
        
        $date_option = [
            "".date('Y-m-d')." - ".date('Y-m-d')."" => "Today",
            "".date('Y-m-d',strtotime("-1 days"))." - ".date('Y-m-d',strtotime("-1 days"))."" => "Yesterday",
            "".date('Y-m-d',strtotime("-6 days"))." - ".date('Y-m-d')."" => "Last 7 Days",
            "".date('Y-m-d',strtotime("-29 days"))." - ".date('Y-m-d')."" => "Last 30 Days",
            "".date('Y-m-01')." - ".date('Y-m-t')."" => "This Month",
            "".date('Y-m-01',strtotime("-1 months"))." - ".date('Y-m-t',strtotime("-1 months"))."" => "Last Month",
            
        ];
    }

    function getReport($objSite, $arrMetrics, $arrConfig)
    {
       if($objSite)
        {
           // $token = $this->checkAccessToken($objSite);

        $client=$this->authmain($objSite->created_by);
        $client->setAccessToken($objSite->accessToken);
        $analytics = new Google_Service_AnalyticsReporting($client);
        
        $VIEW_ID = $objSite->view_id;

        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($VIEW_ID);
        $setMetrics = [];
        foreach($arrMetrics as $key => $alias)
        {
            $ga_metrics = new Google_Service_AnalyticsReporting_Metric();
            $ga_metrics->setExpression($key);
            $ga_metrics->setAlias($alias);
            $setMetrics[] = $ga_metrics;
        
        }

        $request->setMetrics($setMetrics);
        $setDimensions = [];
        
        if(!empty($arrConfig['dimensions']))
        {
            foreach($arrConfig['dimensions'] as $dimensions)
            {
                $objDimensions = new Google_Service_AnalyticsReporting_Dimension();
                $objDimensions->setName($dimensions);
                $setDimensions[] = $objDimensions;
            }
        }
        if(isset($arrConfig['segments']) && !empty($arrConfig['segments']))
        {
            $setSegments = [];
            foreach($arrConfig['segments'] as $segments)
            {
                $objSegments = new Google_Service_AnalyticsReporting_Segment();
                $objSegments->setSegmentId($segments);
                $setSegments[] = $objSegments;
            }

            $request->setSegments($setSegments);
            $dimensionSegment = new Google_Service_AnalyticsReporting_Dimension();
            $dimensionSegment->setName('ga:segment');
            $setDimensions[] = $dimensionSegment;
        }



        $request->setDimensions($setDimensions);

        if(!empty($arrConfig['filter']))
        {
            $setFilter = [];
            foreach($arrConfig['filter'] as $filter)
            {
                $dimensionFilter = new Google_Service_AnalyticsReporting_DimensionFilter();
                $dimensionFilter->setDimensionName($filter['dimension']);
                $dimensionFilter->setOperator($filter['operator']);
                $dimensionFilter->setExpressions([$filter['value']]);
                $setFilter[] = $dimensionFilter;
            }
            $dimensionFilterClause = new Google_Service_AnalyticsReporting_DimensionFilterClause();
            $dimensionFilterClause->setFilters($setFilter);
            $request->setDimensionFilterClauses(array($dimensionFilterClause));
        }

        if(!empty($arrConfig['StartDate']))
        {
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($arrConfig['StartDate']);
            $dateRange->setEndDate($arrConfig['EndDate']);
            $request->setDateRanges($dateRange);
        }

        if(!empty($arrConfig['sort']))
        {
            $orderby = new Google_Service_AnalyticsReporting_OrderBy();
            $orderby->setFieldName($arrConfig['sort']['field']);
            $orderby->setSortOrder($arrConfig['sort']['order']);
            $request->setOrderBys($orderby);
        }
        if(!empty($arrConfig['page_size']))
        {
            $request->setPageSize($arrConfig['page_size']);
        }
        $return = [];
        try
        {
            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();

            $body->setReportRequests(array($request));
            
            $return['data']       = $analytics->reports->batchGet($body);
            
            $return['is_success'] = true;
        }
        catch(exception $e)
        {
            dd("error");
            $return['is_success'] = false;
            $return['error']      = json_decode($e->getMessage());
        }
       
        return $return;
            
        }       
    }
    function printResults($reports)
    {

        $arrReport = [];
        for($reportIndex = 0; $reportIndex < count($reports); $reportIndex++)
        {

            $arrReport[$reportIndex] = [];
            $report                  = $reports[$reportIndex];
            $header                  = $report->getColumnHeader();
            $dimensionHeaders        = $header->getDimensions();
            $metricHeaders           = $header->getMetricHeader()->getMetricHeaderEntries();
            $rows                    = $report->getData()->getRows();

            for($rowIndex = 0; $rowIndex < count($rows); $rowIndex++)
            {
                $arrReport[$reportIndex][$rowIndex] = [];
                $row                                = $rows[$rowIndex];
                $dimensions                         = $row->getDimensions();
                $metrics                            = $row->getMetrics();

                $arrReport[$reportIndex][$rowIndex]['dimensionHeaders'] = [];
                if($dimensionHeaders !="")
                {
                for($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++)
                {
                    $arrReport[$reportIndex][$rowIndex]['dimensionHeaders'][$dimensionHeaders[$i]] = $dimensions[$i];
                }

                }

                $arrReport[$reportIndex][$rowIndex]['metrics'] = [];
                for($j = 0; $j < count($metrics); $j++)
                {
                    $values = $metrics[$j]->getValues();
                    for($k = 0; $k < count($values); $k++)
                    {
                        $entry                                                            = $metricHeaders[$k];
                        $arrReport[$reportIndex][$rowIndex]['metrics'][$entry->getName()] = $values[$k];
                    }
                }
            }
        }
        return $arrReport;
    }


    public function checkAccessToken($objSite)
    {   

        $client=$this->authmain();
        $return = [];
        $client->setAccessToken($objSite->accessToken);

        $client->refreshToken($objSite->refreshToken);
        $accessToken = $client->getAccessToken();

        if($client->isAccessTokenExpired())
        {
            $client->fetchAccessTokenWithRefreshToken($objSite->refreshToken);
            $objSite->accessToken = json_encode($client->getAccessToken());
            $return['isUpdated']  = true;
        }
        else
        {
            $return['isUpdated'] = false;
        }
        $return['objSite'] = $objSite;

        return $return;
    }

    function getDurationFromText($duration)
    {


        $arrDate  = [];
        $arrField = [];
        $duration = strtolower($duration);

        if($duration == "today")
        {
            $arrDate['dimension'] = "ga:hour";
            $arrDate['EndDate']   = date('Y-m-d');
            $startDate            = date('Y-m-d');
            for($i = 0; $i <= 23; $i++)
            {
                if($i <= 9)
                {
                    $arrField['0' . $i] = $i;
                }
                else
                {
                    $arrField[$i] = $i;
                }
            }

            $arrDate['StartDate'] = $startDate;
            $arrDate['arrField']  = $arrField;
        }
        elseif($duration == "yesterday")
        {
            $arrDate['dimension'] = "ga:date";
            $arrDate['EndDate']   = date('Y-m-d');
            $startDate            = date('Y-m-d');
            for($i = 1; $i <= 2; $i++)
            {
                $startDate                                  = date('Y-m-d', strtotime('-1 day', strtotime($startDate)));
                $arrField[date('l', strtotime($startDate))] = date('l', strtotime($startDate));
            }

            $arrDate['StartDate'] = $startDate;
            $arrDate['arrField']  = $arrField;
        }
        elseif($duration == "week" || $duration == "7daysago")
        {
            $arrDate['dimension'] = "ga:dayOfWeekName";
            $arrDate['EndDate']   = date('Y-m-d');
            $startDate            = $arrDate['EndDate'];
            for($i = 1; $i <= 7; $i++)
            {
                $startDate                                  = date('Y-m-d', strtotime('-1 day', strtotime($startDate)));
                $arrField[date('l', strtotime($startDate))] = date('l', strtotime($startDate));
            }
            $arrDate['StartDate'] = $startDate;
            $arrDate['arrField']  = $arrField;
        }
        elseif($duration == "15daysago")
        {
            $arrDate['dimension'] = "ga:date";
            $arrDate['EndDate']   = date('Y-m-d');
            $startDate            = $arrDate['EndDate'];
            for($i = 1; $i <= 15; $i++)
            {
                $arrField[date('Ymd', strtotime($startDate))] = date('d-m-Y', strtotime($startDate));
                $startDate                                    = date('Y-m-d', strtotime('-1 day', strtotime($startDate)));
            }
            $arrField[date('Ymd', strtotime($startDate))] = date('d-m-Y', strtotime($startDate));

            $arrDate['StartDate'] = $startDate;
            $arrDate['arrField']  = $arrField;

        }
        elseif($duration == "month" || $duration == "30daysago")
        {
            $arrDate['dimension'] = "ga:date";
            $arrDate['EndDate']   = date('Y-m-d');
            $startDate            = $arrDate['EndDate'];

            for($i = 1; $i <= 30; $i++)
            {
                $startDate                                    = date('Y-m-d', strtotime('-1 day', strtotime($startDate)));
                $arrField[date('Ymd', strtotime($startDate))] = date('d-m-Y', strtotime($startDate));
            }
            $arrDate['StartDate'] = $startDate;
            $arrDate['arrField']  = $arrField;
        }
        elseif($duration == "year")
        {

            $arrDate['dimension'] = "ga:yearMonth";
            $arrDate['EndDate']   = date('Y-m-d', strtotime('+1 month', time()));
            $startDate            = $arrDate['EndDate'];
            for($i = 1; $i <= 12; $i++)
            {
                $startDate                                   = date('Y-m-d', strtotime('-1 month', strtotime($startDate)));
                $arrField[date('Ym', strtotime($startDate))] = date('M', strtotime($startDate));
            }
            $arrDate['StartDate'] = $startDate;
            $arrDate['arrField']  = $arrField;
        }

        return $arrDate;
    }
    function getLiveUser($objSite)
    {

        $client=$this->authmain();
        $client->setAccessToken($objSite->accessToken);
        $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
        $analytics = new Google_Service_Analytics($client);

        $optParams = ['dimensions' => 'rt:medium'];
        try
        {
            $results = $analytics->data_realtime->get(
                'ga:' . $objSite->view_id, 'rt:activeUsers', $optParams
            );
            // Success. 
            $res['is_success'] = 1;
            $res['liveUser']   = $results->totalsForAllResults['rt:activeUsers'];

            
        }
        catch(apiServiceException $e)
        {
            $res['is_success'] = 0;
            $res['error']      = json_decode($e->getMessage());
        }
        catch(Exception $e)
        {
            
            $res['is_success'] = 0;
            $res['error']      = json_decode($e->getMessage());
        }
        
        echo json_encode($res); ;
    }

    

    public function assignPlan($planID,$Company_id, $frequency = '')
    {
            
      
        $plan = Plan::find($planID);
        
        $Company=User::where('id',$Company_id)->first();
               $sites= Site::where('created_by', '=', $Company->id)->get();
        if ($plan) {
            $sitescount = 0;
            foreach ($sites as $site) {
                 $sitescount++;
                $site->is_active = $plan->max_site == -1 || $sitescount <= $plan->max_site ? 1 : 0;

                $site->save();
                
                $assetsCount = 0;
                foreach ($site->widget as $widget) {
                    $assetsCount++;
                    $widget->is_active = $plan->max_widget == -1 || $assetsCount <= $plan->max_widget ? 1 : 0;
                    $widget->save();
                }   
            }
            if ($plan->max_site == -1) 
            {
                $Company->is_plan_purchased = 1;
                $Company->save();
                $user=User::where('created_by',$Company_id)->update(['is_plan_purchased'=>1]);
            } 
            else 
            {

                $s_Count = 0;
                foreach ($sites as $site) {
                    $s_Count++;
                    if ($s_Count <= $plan->max_user) {
                        $Company->is_plan_purchased = 1;
                        $Company->save();
                        $user=User::where('created_by',$Company_id)->update(['is_plan_purchased'=>1]);

                    } else {
                        $Company->is_plan_purchased = 0;
                        $Company->save();
                        $user=User::where('created_by',$Company_id)->update(['is_plan_purchased'=>0]);
                    }
                }
            }

           $user=User::where('created_by',$Company_id)->update(['plan'=>$planID]);
            $Company->plan = $plan->id;
            if ($frequency == 'weekly') {
                $user=User::where('created_by',$Company_id)->update(['plan_expire_date'=>Carbon::now()->addWeeks(1)->isoFormat('YYYY-MM-DD')]);
                $Company->plan_expire_date = Carbon::now()->addWeeks(1)->isoFormat('YYYY-MM-DD');
            } elseif ($frequency == 'monthly') {
                $user=User::where('created_by',$Company_id)->update(['plan_expire_date'=>Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD')]);
                $Company->plan_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            } elseif ($frequency == 'annual') {
                $user=User::where('created_by',$Company_id)->update(['plan_expire_date'=>Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD')]);
                $Company->plan_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            } else {
                $Company->plan_expire_date = null;
                $user=User::where('created_by',$Company_id)->update(['plan_expire_date'=>null]);
            }
            $Company->plan_type = $frequency;
             $user=User::where('created_by',$Company_id)->update(['plan_type'=>$frequency]);

            $Company->save();
            return ['is_success' => true];
        } else {
            return [
                'is_success' => false,
                'error' => __('Plan is deleted.'),
            ];
        }
    }

    public function daily_alter_data($siteid,$metric)
    {
        $duration='yesterday';
        $site=Site::where("id",$siteid)->first();
        $arrConfig= [];
        //$arrMetrics = ['ga:users' => 'Users'];
         $metric_option=$this->metric_option();
            $met_name='';
        foreach ($metric_option as $ke => $met_val) {
            if($ke==$metric)
            {
                $arrMetrics = [$ke => $met_val];

                $met_name=$met_val;
                break;
            }
        }
        $arrParam =  $this->getDurationFromText($duration);
        $arrConfig['dimensions'] = [$arrParam['dimension']];
        $arrConfig['StartDate']  = $arrParam['StartDate'];
        $arrConfig['EndDate']    = $arrParam['EndDate'];
        
        $analyticsData= $this->getReport($site, $arrMetrics, $arrConfig);
        $y_data=0;
        $t_data=0;
        if($analyticsData['is_success'])
        {
            $arrProccessData = $this->printResults($analyticsData['data']);
            $data=array();
               
            foreach ($arrProccessData[0] as $key => $value) {
                if($key!=0)
                {
                    $data[]=$value;
                }

            }
            if(!empty($data))
            {
                foreach ($data as $k => $val) {
                   if($k==0)
                   {
                        $y_data=$val['metrics'][$met_name];
                   }
                   else
                   {
                        $t_data=$val['metrics'][$met_name];
                   }

                  
                   
                }
                if($y_data>$t_data)
                {
                    $sum=$y_data/$t_data;
                    $res="increased " .number_format($sum, 2)."x";

                }
                else
                {
                    $sum=$t_data/$y_data;
                    $res="decreased " .number_format($sum, 2)."x";
                }

                return $res;
            }
                
        }

    }
    public function week_alter_data($siteid,$metric)
    {

        $duration='7daysago';
        $site=Site::where("id",$siteid)->first();
        $arrConfig= [];
        $metric_option=$this->metric_option();
            $met_name='';
        foreach ($metric_option as $ke => $met_val) {
            if($ke==$metric)
            {
                $arrMetrics = [$ke => $met_val];

                $met_name=$met_val;
                break;
            }
        }
         
        $arrParam =  $this->getDurationFromText($duration);
        $arrConfig['dimensions'] = [$arrParam['dimension']];
        $arrConfig['StartDate']  = $arrParam['StartDate'];
        $arrConfig['EndDate']    = $arrParam['EndDate'];
            
        
        $analyticsData= $this->getReport($site, $arrMetrics, $arrConfig);
        $y_data=0;
        $t_data=0;
        if($analyticsData['is_success'])
        {
            $start_day=date('l', strtotime(' -7 day'));

            $end_day=date('l', strtotime(' -1 day'));
            $arrProccessData = $this->printResults($analyticsData['data']);
            $data=array();
               
            foreach ($arrProccessData[0] as $key => $value) {

                
                if($value['dimensionHeaders']['ga:dayOfWeekName']==$start_day )
                {
                    $data['start']=$value;
                }
                if($value['dimensionHeaders']['ga:dayOfWeekName']==$end_day)
                {
                    $data['end']=$value;
                }

            }
           
            if(!empty($data))
            {
                foreach ($data as $k => $val) {
                    
                   if($k=='start')
                   {
                        $s_date=$val['metrics'][$met_name];
                   }
                   else
                   {
                        $e_date=$val['metrics'][$met_name];
                   }

                  
                   
                }
                if($e_date>$s_date)
                {
                    $sum=$e_date/$s_date;
                    $res="increased " .number_format($sum, 2)."x";

                }
                else
                {
                    $sum=$s_date/$e_date;
                    $res="decreased " .number_format($sum, 2)."x";
                }
                

                return $res;
            }
                
        }

    }
    public function monthly_alter_data($siteid,$metric)
    {
        $duration='30daysago';
        $site=Site::where("id",$siteid)->first();
        $arrConfig= [];
        /**/
        $metric_option=$this->metric_option();
            $met_name='';
        foreach ($metric_option as $ke => $met_val) {
            if($ke==$metric)
            {
                $arrMetrics = [$ke => $met_val];

                $met_name=$met_val;
                break;
            }
        }

        $arrParam =  $this->getDurationFromText($duration);
        $arrConfig['dimensions'] = [$arrParam['dimension']];
        $arrConfig['StartDate']  = $arrParam['StartDate'];
        $arrConfig['EndDate']    = $arrParam['EndDate'];
        
        $analyticsData= $this->getReport($site, $arrMetrics, $arrConfig);
        $s_data=0;
        $e_data=0;
        if($analyticsData['is_success'])
        {
            $arrProccessData = $this->printResults($analyticsData['data']);
       
            $data=array();
               
            foreach ($arrProccessData[0] as $key => $value) {
                if($key==0)
                {
                    $data['start']=$value;
                }
                if($key==30)
                {
                    $data['end']=$value;
                }

            }
            if(!empty($data))
            {
                foreach ($data as $k => $val) {
                   if($k=='start')
                   {
                        $s_data=$val['metrics'][$met_name];
                   }
                   else
                   {
                        $e_data=$val['metrics'][$met_name];
                   }

                  
                   
                }
                
                if($e_data>$s_data)
                {
                    $sum=$e_data/$s_data;
                    $res="increased " .number_format($sum, 2)."x";

                }
                else
                {
                    $sum=$s_data/$e_data;
                    $res="decreased " .number_format($sum, 2)."x";
                }

                return $res;
            }
                
        }

    }
    public static function send_slack_msg($msg,$created_id=0) {

       
        
        if($created_id==0){

            $settings  = Utility::settings($created_id);
        }else{
            $settings  = Utility::settings($created_id);
        }


        try{
            if(isset($settings['slack_webhook']) && !empty($settings['slack_webhook'])){
                
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $settings['slack_webhook']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['text' => $msg]));

                $headers = array();
                $headers[] = 'Content-Type: application/json';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);

                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
            }
        }
        catch(\Throwable $e){
                            Log::info($e);
                        }

    } 


     public function daily_report_data($siteid)
    {
        $duration='yesterday';
        $site=Site::where("id",$siteid)->first();
        $arrConfig= [];
        $arrMetrics=[];
        //$arrMetrics = ['ga:users' => 'Users'];
         $metric_option=$this->metric_option();
        $i=1;
        foreach ($metric_option as $ke => $met_val) {
                if($i<=10)
                {
                    $arrMetrics[$ke] = $met_val;
                }      
                $i++;
        }

        $arrParam =  $this->getDurationFromText($duration);
        $arrConfig['dimensions'] = [$arrParam['dimension']];
        $arrConfig['StartDate']  = $arrParam['StartDate'];
        $arrConfig['EndDate']    = $arrParam['EndDate'];
        
        $analyticsData= $this->getReport($site, $arrMetrics, $arrConfig);
       
        $y_data=0;
        $t_data=0;
        $dt_arr=array();
        $html="";
        if($analyticsData['is_success'])
        {
            $arrProccessData = $this->printResults($analyticsData['data']);
            $data=array();
               
            foreach ($arrProccessData[0] as $key => $value) {
                if($key!=0)
                {
                    $data[]=$value;
                }

            }
            if(!empty($data))
            {
                
                foreach ($data as $k => $val) {
                    if($k==0)
                    {
                        $y_data=$val['metrics'];
                    }
                    else
                    {
                        $t_data=$val['metrics'];
                    } 
                }
                $temp=0;
                
                if($y_data!=0&&$t_data!=0)
                {
                    foreach ($y_data as $key => $value) 
                    {
                        
                        if($value !=0 && $t_data[$key]!=0)
                        {
                            $temp=number_format($value, 2)-number_format($t_data[$key], 2);
                            $sum=($temp*100)/$value;
                          
                        }
                        else{
                            $sum=100;
                          
                        }
                        $dt_arr[$key]=array(
                            "previous"=>number_format($value, 2),
                            "current"=>number_format($t_data[$key], 2),
                            "change"=>number_format($sum, 2),
                        );
                    }

                }
               
                
            }
                
        }

        return json_encode($dt_arr);

    }

      public function weekly_report_data($siteid)
    {
       
        $duration='7daysago';
        $site=Site::where("id",$siteid)->first();
        $arrConfig= [];
        $arrMetrics=[];
        //$arrMetrics = ['ga:users' => 'Users'];
         $metric_option=$this->metric_option();
        $i=1;
        foreach ($metric_option as $ke => $met_val) {
                if($i<=10)
                {
                    $arrMetrics[$ke] = $met_val;
                }      
                $i++;
        }

        $arrParam =  $this->getDurationFromText($duration);
        $arrConfig['dimensions'] = [$arrParam['dimension']];
        $arrConfig['StartDate']  = $arrParam['StartDate'];
        $arrConfig['EndDate']    = $arrParam['EndDate'];
        
        $analyticsData= $this->getReport($site, $arrMetrics, $arrConfig);
        $start_day=date('l', strtotime(' -7 day'));

        $end_day=date('l', strtotime(' -1 day'));
        $y_data=0;
        $t_data=0;
        $dt_arr=array();
        $html="";
        if($analyticsData['is_success'])
        {
            $arrProccessData = $this->printResults($analyticsData['data']);
            $data=array();
               
            foreach ($arrProccessData[0] as $key => $value) {

                
                if($value['dimensionHeaders']['ga:dayOfWeekName']==$start_day )
                {
                    $data['start']=$value;
                }
                if($value['dimensionHeaders']['ga:dayOfWeekName']==$end_day)
                {
                    $data['end']=$value;
                }

            }
           
           
            if(!empty($data))
            {
                
                foreach ($data as $k => $val) {
                    if($k=='start')
                    {
                        $y_data=$val['metrics'];
                    }
                    else
                    {
                        $t_data=$val['metrics'];
                    } 
                }
                $temp=0;
                
                if($y_data!=0&&$t_data!=0)
                {
                     foreach ($y_data as $key => $value) 
                    {
                        
                        if($value !=0 && $t_data[$key]!=0)
                        {
                            $temp=number_format($value, 2)-number_format($t_data[$key], 2);
                            $sum=($temp*100)/$value;
                          
                        }
                        else{
                            $sum=100;
                          
                        }
                        $dt_arr[$key]=array(
                            "previous"=>number_format($value, 2),
                            "current"=>number_format($t_data[$key], 2),
                            "change"=>number_format($sum, 2),
                        );
                    }

                }
               
                
            }
                
        }

        return json_encode($dt_arr);

    }

      public function monthly_report_data($siteid)
    {
       
        $duration='30daysago';
        $site=Site::where("id",$siteid)->first();
        $arrConfig= [];
        $arrMetrics=[];
        //$arrMetrics = ['ga:users' => 'Users'];
         $metric_option=$this->metric_option();
        $i=1;
        foreach ($metric_option as $ke => $met_val) {
                if($i<=10)
                {
                    $arrMetrics[$ke] = $met_val;
                }      
                $i++;
        }

        $arrParam =  $this->getDurationFromText($duration);
        $arrConfig['dimensions'] = [$arrParam['dimension']];
        $arrConfig['StartDate']  = $arrParam['StartDate'];
        $arrConfig['EndDate']    = $arrParam['EndDate'];
        
        $analyticsData= $this->getReport($site, $arrMetrics, $arrConfig);
        $start_day=date('l', strtotime(' -7 day'));

        $end_day=date('l', strtotime(' -1 day'));
        $y_data=0;
        $t_data=0;
        $dt_arr=array();
        $html="";
        if($analyticsData['is_success'])
        {
            $arrProccessData = $this->printResults($analyticsData['data']);
            $data=array();
               
            foreach ($arrProccessData[0] as $key => $value) {

                
                 if($key==0)
                {
                    $data['start']=$value;
                }
                if($key==30)
                {
                    $data['end']=$value;
                }

            }
           
           
            if(!empty($data))
            {
                
                foreach ($data as $k => $val) {
                    if($k=='start')
                    {
                        $y_data=$val['metrics'];
                    }
                    else
                    {
                        $t_data=$val['metrics'];
                    } 
                }
                $temp=0;
                
                if($y_data!=0&&$t_data!=0)
                {
                    foreach ($y_data as $key => $value) 
                    {
                        
                        if($value !=0 && $t_data[$key]!=0)
                        {
                            $temp=number_format($value, 2)-number_format($t_data[$key], 2);
                            $sum=($temp*100)/$value;
                          
                        }
                        else{
                            $sum=100;
                          
                        }
                        $dt_arr[$key]=array(
                            "previous"=>number_format($value, 2),
                            "current"=>number_format($t_data[$key], 2),
                            "change"=>number_format($sum, 2),
                        );
                    }

                }  
            }
                
        }
        return json_encode($dt_arr);
    }
}
