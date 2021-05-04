<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendees;
use App\Models\ChangeRequest;

class dashboard extends Controller
{
  /**
   * Dashboard - View Page
   * @author Tittu Varghese (tittu@servntire.com)
   *
   * @param  Request | $request
   * @return array | $dataArray
   * @return view | import_attendees
   */

  protected function view(Request $request)
  {

    $uri = $request->path();
    if ($uri == 'dashboard') {
      $uri = "Dashboard";
    }
    $returnData['uri'] = $uri;
    $returnData['attendees'] = Attendees::where('member_type', 'Member')->count();
    $returnData['teams'] = Attendees::distinct('team_id')->where('member_type', 'Member')->count('team_id');
    $returnData['issued_certificates'] = Attendees::where('certificate_status', true)->count();
    $returnData['issued_certificates_email'] = Attendees::where('certificate_email_status', true)->count();
    $returnData['changes_requested'] = ChangeRequest::count();
    return view('dashboard', ['dataArray' => $returnData]);
  }
}
