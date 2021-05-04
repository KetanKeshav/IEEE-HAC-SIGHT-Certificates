<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendees;

class attendeesPage extends Controller
{
  /**
   * Attendees - View Page
   * @author Tittu Varghese (tittu@servntire.com)
   *
   * @param  Request | $request
   * @return array | $dataArray
   * @return view | attendees
   */

  protected function view(Request $request)
  {

    $uri = $request->path();
    if ($uri == 'attendees') {
      $uri = "Attendees";
    }
    $returnData['uri'] = $uri;
    $returnData['attendees'] = Attendees::orderBy('rank', 'asc')->orderBy('team_name', 'asc')->paginate(50);

    return view('attendees', ['dataArray' => $returnData]);
  }

  /**
   * Teams - View Page
   * @author Tittu Varghese (tittu@servntire.com)
   *
   * @param  Request | $request
   * @return array | $dataArray
   * @return view | teams
   */

  protected function viewTeam(Request $request)
  {

    $uri = $request->path();
    if ($uri == 'teams') {
      $uri = "Teams";
    }
    $returnData['uri'] = $uri;
    $returnData['attendees'] = Attendees::orderBy('rank', 'asc')->orderBy('team_name', 'asc')->paginate(50);

    return view('teams', ['dataArray' => $returnData]);
  }
}
