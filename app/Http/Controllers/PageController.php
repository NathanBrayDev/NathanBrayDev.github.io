<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;
use Illuminate\Http\Request;

class PageController extends Controller
{
   
    public function newsDetails(News $news)
    {
        return view('news_details')->with(['page' => $news]);
    }

    public function eventDetails(Event $event)
    {
        return view('event_details')->with(['page' => $event]);
    }
}