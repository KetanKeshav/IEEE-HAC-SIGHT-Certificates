<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendees;

class attendeesPage extends Controller
{
  protected function view(Request $request)
  {

    $uri = $request->path();
    if ($uri == 'attendees') {
      $uri = "Attendees";
    }
    $returnData['uri'] = $uri;
    $returnData['attendees'] = Attendees::orderBy('id', 'asc')->orderBy('Certificate_Type', 'asc')->paginate(50);

    return view('attendees', ['dataArray' => $returnData]);
  }

  protected function viewTeam(Request $request)
  {

    $uri = $request->path();
    if ($uri == 'teams') {
      $uri = "Teams";
    }
    $returnData['uri'] = $uri;
    $returnData['attendees'] = Attendees::orderBy('id', 'asc')->orderBy('Certificate_Type', 'asc')->paginate(50);

    return view('teams', ['dataArray' => $returnData]);
  }
}
