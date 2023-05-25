<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Http\Requests\EmailTemplate\CreateRequest;
use App\Http\Requests\EmailTemplate\EditRequest;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['templates'] = EmailTemplate::paginate(5);
        return view('emailTemplate.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('emailTemplate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\EmailTemplate\CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $template = new EmailTemplate();
        $template->name = $request->name;
        $template->subject = $request->subject;
        $strippedText = $request->content; // Remove HTML tags
        $template->body = $strippedText;
        $template->save();

        return redirect()->route('template.index')->with(['type' => 'success', 'message' => 'Template Created Sucessfully!']);
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
        $data = [];
        $data['template'] = EmailTemplate::find($id);
        return view('emailTemplate.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRequest $request, $id)
    {
        //
        $template = EmailTemplate::find($id);
        $template->name = $request->name;
        $template->subject = $request->subject;
        $strippedText = $request->content; // Remove HTML tags
        $template->body = $strippedText;
        $template->save();

        return redirect()->route('template.index')->with(['type' => 'success', 'message' => 'Template Updated Sucessfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EmailTemplate::destroy($id);
        return redirect()->route('template.index')->with(['type' => 'success', 'message' => 'Template Deleted Sucessfully!']);
    }
}
