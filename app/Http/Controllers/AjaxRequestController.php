<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

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
         
        return view('partial.cities', $this->viewData);
    }
}
