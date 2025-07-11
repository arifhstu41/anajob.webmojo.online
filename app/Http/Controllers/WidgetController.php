<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Plan;
use App\Models\Widget;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Session;
class WidgetController extends Controller
{
    public function show_widget()
	{
		if(\Auth::user()->can('manage widget'))
        {
			$user=Auth::user();
			if(\Auth::user()->user_type !='company' )
	    	{
    			$site_data=Site::where('created_by',$user->created_by)->get();
    		}
    		else
    		{
    			$site_data=Site::where('created_by',$user->id)->get();
    		}
			$metric_option = $this->metric_option();
			$date_filter_option = $this->date_filter_option();
			return view('admin.widget.default')->with('site_data',$site_data)->with('metric_option',$metric_option)->with('date_filter_option',$date_filter_option);
		}
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
	}
	public function save_widget(Request $request)
	{
		if($request->get('site_id')=="")
		{
			return response()->json(["stutas" =>0,'error' => __('Please add site before create widget.')]);
		}
		$id=$request->get('id');
		$user= Auth::user();
		if($id == "0")
		{
    		if(\Auth::user()->can('create widget'))
			{
				$store=new Widget();
			}
			else
			{
				return response()->json(["stutas" =>0,'error' => __('Permission Denied.')]);
			
			}
		}
		else
		{
			if(\Auth::user()->can('edit widget'))
			{
				$store=Widget::where('id',$id)->first();
			}
			else
			{
				return response()->json(["stutas" =>0,'error' => __('Permission Denied.')]);
			
			}
		}
		$store->site_id=$request->get('site_id');
		$store->title=$request->get('title');
		$store->metrics_1=$request->get('metric_1');
		$store->metrics_2=$request->get('metric_2');
		$store->save();
		if($store)
		{
			return response()->json(["stutas" =>1,"id"=>$store->id,'success'=>__('Widget save successfully')]);
			
		}
		else
		{
			return response()->json(["stutas" =>0,'error' => __('Something is wrong..')]);
		
		}
			
	}
	public function widget_data(Request $request)
	{
		$site_id=$request->get('site_id');

		$metric_option = $this->metric_option();
		if($request->get('type')=="0")
		{
			$data=Widget::where('site_id',$site_id)->get();
		}
		else
		{
			$data=Widget::where('site_id',$site_id)->where('id',$request->get('wid_id'))->get();
		}
			$output="";

		if(count($data)>0)
		{
			foreach ($data as $value) {
				$site=Site::where('id',$value->site_id)->first();

				$arrMetrics = [
	                $value->metrics_1 => $metric_option[$value->metrics_1],
	                $value->metrics_2 => $metric_option[$value->metrics_2],
	            ];
	            $arrMet     = [
	                'metrics_1' => $value->metrics_1,
	                'metrics_2' => $value->metrics_2,
            	];
            	$dates = explode(" - ", $request->get('date'));
            	
            	$arrConfig = [];
	            $arrConfig['StartDate'] = date('Y-m-d', strtotime($dates[0]));
	            $arrConfig['EndDate'] = date('Y-m-d', strtotime($dates[1]));
	            $analyticsData = $this->getReport($site, $arrMetrics, $arrConfig);

	            if($analyticsData['is_success'])
		        {
		            $arrProccessData = $this->printResults($analyticsData['data']);
		          	if(!empty($arrProccessData[0]))
		          	{
		          		$data= $arrProccessData[0][0]['metrics'];
			            $output.="<div class='col-md-3' id='widget_div_".$value->id."'>
	                			<div class='card'>
				                	<div class='row'>
				                    	<h5 class='card-header col-9' >".$value->title."</h5>
				                    	<div class='col-3 card-header text-right'><a onclick='edit_widget(".$value->id.")' data-bs-toggle='modal' data-bs-target='#edit_widget_modal'><i class='ti ti-layout-2' ></i></a></div>
				                    </div>";
				                    $output.="<div class='card-body'>
				                        <div class='row'>";
				                        foreach ($data as $key => $res_val) {
								            	 $output.=" <div class='col-6 mb-2' align='center'>
			 										<h4>";
			 										if(strpos($res_val, '.') !== false)
								                    {
								                         $output.=" ".number_format((float)$res_val, 2, '.', '')."";
								                    }
								                    else
								                    {
								                        $output.=" ".$res_val."";
								                    }
			 										$output.="</h4>
							                        <p>".$key."</p>

							                        </div>";
								            }
				                    	$output.="</div>
	                				</div>
	            				</div>
	            			</div>";
		          	}
		          	else
		          	{
		          		$output.="<div class='col-md-3' id='widget_div_".$value->id."'>
	                			<div class='card'>
				                	<div class='row'>
				                    	<h5 class='card-header col-9' >".$value->title."</h5>
				                    	<div class='col-3 card-header text-right'><a onclick='edit_widget(".$value->id.")' data-bs-toggle='modal' data-bs-target='#edit_widget_modal'><i class='ti ti-layout-2' ></i></a></div>
				                    </div>";
				                    $output.="<div class='card-body'>
				                        <div class='row'>";
				                        foreach ($metric_option as $key => $m_val) {
				                        	if($key == $value->metrics_1 || $key == $value->metrics_2)
								            	 $output.=" <div class='col-6 mb-2' align='center'>
			 										<h4>0</h4>
							                        <p>".$m_val."</p>

							                        </div>";
								            }
				                    	$output.="</div>
	                				</div>
	            				</div>
	            			</div>";
		          	}
		            
		            
		        }
	            		
			}
			
		}
		else
		{
			$output.='<div class="col-md-12" style="height: 200px; ">
		      <div class="alert alert-primary alert-dismissible fade show text-center" role="alert">
		             '. __("No Data Found !").'
		             
		            </div>
		    </div>';
		}
		echo $output;
	}
	public function edit_widget_data(Request $request)
	{
		$id=$request->get('id');
		$data=Widget::where('id',$id)->first();
		return $data;
	}
}


