<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\EmployeeLeaveType;

class AjaxRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $viewData = array();
    public function getCities($country_id, Request $request)
    {
        $cities = City::where('country_id', $country_id)->get();
        $this->viewData['cities'] = $cities;
        $this->viewData['city_id'] = isset($request->city_id) ?  $request->city_id : 0;
        return view('partial.cities', $this->viewData);
    }

    public function getSelectedCities(Request $request)
    {  
        $cities = City::where('country_id', $request->country_id)->get();
        $this->viewData['cities'] = $cities;
        $this->viewData['city_id'] = isset($request->city_id) ?  $request->city_id : 0;
        //While fetching city_id value in edit form, since add form and edit both has city_id
        $this->viewData['edit_city_id'] = 1;
         
        return view('partial.cities', $this->viewData);
    }

    public function storeEmpTypeLeaves(Request $request)
    {
        // dd($request->all());
        for ($i = 0; $i < count($request->leaveTypeValues); $i++) {
            $result[] = [
                "leave_type" => $request->leaveTypeValues[$i],
                "nol" => $request->nolValues[$i],
            ];
        }
        
        $json_result = json_encode($result);

        $empLeavetype = new EmployeeLeaveType();
        $empLeavetype->emp_type_id = $request->empTypeId;
        $empLeavetype->payload = $json_result;
        $empLeavetype->save();
        return response()->json(['success' =>'true']);
    }

    public function getEmpTypeLeaves(Request $request, $id)
    {
        // dd($request->all());
        $empLeavetype = EmployeeLeaveType::where('emp_type_id',$id)->first();
        return response()->json(['success' =>'true','empLeavetype'=>$empLeavetype]);
    }
}
