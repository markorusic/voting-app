<?php

namespace App\Http\Controllers;

use App\Poll;
use App\Choice;
use Illuminate\Http\Request;
use Auth;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        return view('polls', ['polls' => Poll::orderBy('created_at', 'desc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        return view('dashboard', ['mypolls' => Auth::user()->polls()->orderBy('created_at', 'desc')->get()]);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $poll = new Poll(['title' => $request->input('title')]);

        Auth::user()->polls()->save($poll);

        foreach ($request->input('choices') as $choice)
            $poll->choices()->save(new Choice(['title' => $choice]));
        
        return $poll;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , Poll $poll)
    {                
        $poll->choices = $poll->choices()->get();

        $poll->voted = $poll->votes()->where('ip_adress', $request->ip())->first();

        return view('poll', ['poll' => $poll, 'voted']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function edit(Poll $poll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poll $poll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll)
    {
        $poll->delete();
        return $poll;
    }
}
