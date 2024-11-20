<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vtuber;

class VtuberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $vtubers = Vtuber::orderBy('name', 'asc')->get();
        return view('vtuber', ['vtubers' => $vtubers]);
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
        $vtuber = new Vtuber;
        $vtuber->name = $request->name;
        $vtuber->alias = $request->alias;
        $vtuber->agency = $request->agency;
        $vtuber->channel_name = $request->channel_name;
        $vtuber->channel_url = $request->channel_url;
        $vtuber->debut = $request->debut;
        $vtuber->status = $request->status;

        //validate input
        $request->validate([
            'file' => 'required',
        ]);

        // save file to variable $file
        $file = $request->file('file');
        $file_name = $file->getClientOriginalName();
        $file_ext = $file->getClientOriginalExtension();
        $file->getRealPath();
        $file->getSize();
        $file->getMimeType();
        $upload_destination = 'public/image/';

        // upload file
        $file->move($upload_destination, $file->getClientOriginalName());
        $vtuber->img_url = $upload_destination . $file_name;
        $vtuber->save();

        return redirect()->back();
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
        $vtuber = Vtuber::find($id);
        return $vtuber;
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
    public function update(Request $request)
    {
        //
        $vtuber = Vtuber::find($request->id_vtuber);
        $vtuber->name = $request->name;
        $vtuber->alias = $request->alias;
        $vtuber->agency = $request->agency;
        $vtuber->channel_name = $request->channel_name;
        $vtuber->channel_url = $request->channel_url;
        $vtuber->debut = $request->debut;
        $vtuber->status = $request->status;

        if ($request->file != null) {
            //validate input
            $this->validate($request, [
                'file' => 'required',
            ]);

            // save file to variable $file
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_ext = $file->getClientOriginalExtension();
            $file->getRealPath();
            $file->getSize();
            $file->getMimeType();
            $upload_destination = 'public/image/';

            // upload file
            $file->move($upload_destination, $file->getClientOriginalName());
            $vtuber->img_url = $upload_destination . $file_name;
        }

        $vtuber->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $vtuber = Vtuber::find($request->id_vtuber);
        $vtuber->delete();
        return redirect()->back();
    }
}
