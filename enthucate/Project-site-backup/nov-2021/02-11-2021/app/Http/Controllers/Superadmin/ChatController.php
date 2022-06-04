<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;

use App\Models\DirectMessage;
use Illuminate\Http\Request;
use App\Models\User;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth');
    }
    public function index()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();
        return view('superadmin.chat', compact('users'));
           // return view('admin.message.index');
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
     * @param  \App\Models\DirectMessage  $directMessage
     * @return \Illuminate\Http\Response
     */
    public function show(DirectMessage $directMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DirectMessage  $directMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(DirectMessage $directMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DirectMessage  $directMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DirectMessage $directMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DirectMessage  $directMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(DirectMessage $directMessage)
    {
        //
    }
}
