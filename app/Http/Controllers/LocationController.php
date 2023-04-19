<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['locations'] = Location::paginate(5);
        return view('location.index',$data);
    }

    public function get_location_data(Request $request)
    {
        $locations = Location::paginate(5);

        if($request->ajax())
        {
            $locations = Location::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('name','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(5);

            return view('location.include.tableData', compact('locations'))->render();
        }

        return view('location.include.tableData', compact('locations'))->render();
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
        // dd($request->all());
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'timezone' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $location = new Location();
        $location->title = $request->title;
        $location->timezone = $request->timezone;
        $location->description = $request->description;
        $location->status = isset($request->status) && $request->status == "true" ? 1 : 0 ;
        $location->save();
        return response()->json(['type' =>'success']);
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

        $location = Location::find($id);
        if($location)
            return response()->json(['success'=>true,'location'=>$location]);
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
        // dd($request->all());
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'timezone' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $location = Location::find($id);
        $location->title = $request->title;
        $location->timezone = $request->timezone;
        $location->description = $request->description;
        $location->status = isset($request->status) && $request->status == "true" ? 1 : 0 ;
        $location->save();
        return response()->json(['type' =>'success']);
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
        Location::destroy($id);
        return response()->json(['success'=>true]);
    }
}
