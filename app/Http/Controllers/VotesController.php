<?php

namespace App\Http\Controllers;

use App\Votes;
use Illuminate\Http\Request;
use App\Poll;
use App\Choice;

class VotesController extends Controller
{
    public function store(Request $request, Poll $poll, Choice $choice)
    {

        if($poll->votes()->where('ip_adress', $request->ip())->first())
        {
            return response(['error' => 'You allready voted on this poll.']);
        }

        else if(!$poll->choices()->find($choice->id))
        {
            return response(['error' => 'This choice dosen\'t belong to that poll']);
        }

        else
        {
            $choice->votes++;
            $choice->save();    

            $poll->votes()->save(new Votes(['ip_adress' => $request->ip()]));

            return response(['success' => $choice]);
        }
    }
}
