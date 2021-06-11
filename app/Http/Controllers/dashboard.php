<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendees;
use App\Models\ChangeRequest;

class dashboard extends Controller
{

  protected function view(Request $request)
  {

    $uri = $request->path();
    if ($uri == 'dashboard') {
      $uri = "Dashboard";
    }
    $returnData['uri'] = $uri;
    $returnData['attendees'] = Attendees::where('Certificate_Type', 'Member')->count();
    //$returnData['teams'] = Attendees::distinct('cert_id')->where('Certificate_Type', 'Member')->count('cert_id');
    $returnData['issued_certificates'] = Attendees::where('certificate_status', true)->count();
    $returnData['issued_certificates_email'] = Attendees::where('certificate_email_status', true)->count();
    $returnData['changes_requested'] = ChangeRequest::count();
    return view('dashboard', ['dataArray' => $returnData]);
  }
}
