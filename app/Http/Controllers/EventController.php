<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['events'] = Event::paginate(15);
        return view('event.index',$data);
    }

    public function get_event_data(Request $request)
    {
        $events = Event::paginate(15);

        if($request->ajax())
        {
            $events = Event::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('name','LIKE','%'.$request->search_item.'%')
                                ->orwhere('description','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(15);

            return view('event.include.tableData', compact('events'))->render();
        }

        return view('event.include.tableData', compact('events'))->render();
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
            'name' => 'required',
            'description' => 'required',
            'event_date' => 'required'
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $event = new Event();
        $event->name = $request->name;
        $event->description = $request->description;
        $event->event_date = $request->event_date;
        $event->status = isset($request->status) && $request->status == "true" ? 1 : 0 ;
        $event->save();
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
        //
        $event = Event::find($id);
        if($event)
            return response()->json(['success'=>true,'event'=>$event]);
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'event_date' => 'required'
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $event = Event::find($id);
        $event->name = $request->name;
        $event->description = $request->description;
        $event->event_date = $request->event_date;
        $event->status = isset($request->status) && $request->status == "true" ? 1 : 0 ;
        $event->save();
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
        Event::destroy($id);
        return response()->json(['success'=>true]);
    }
}
