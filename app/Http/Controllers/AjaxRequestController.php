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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
