<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['notices'] = Notice::paginate(15);
        return view('notice.index',$data);
    }

    public function get_notice_data(Request $request)
    {
        $notices = Notice::paginate(15);

        if($request->ajax())
        {
            $notices = Notice::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('name','LIKE','%'.$request->search_item.'%')
                                ->orwhere('description','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(15);

            return view('event.include.tableData', compact('notices'))->render();
        }

        return view('event.include.tableData', compact('notices'))->render();
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
            'description' => 'required'
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $notice = new Notice();
        $notice->name = $request->name;
        $notice->description = $request->description;
        $notice->status = isset($request->status) && $request->status == "true" ? 1 : 0 ;
        $notice->save();
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
        $notice = Notice::find($id);
        if($notice)
            return response()->json(['success'=>true,'notice'=>$notice]);
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
            'description' => 'required'
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $notice = Notice::find($id);
        $notice->name = $request->name;
        $notice->description = $request->description;
        $notice->status = isset($request->status) && $request->status == "true" ? 1 : 0 ;
        $notice->save();
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
        Notice::destroy($id);
        return response()->json(['success'=>true]);
    }
}
