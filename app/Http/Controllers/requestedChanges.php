<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendees;
use App\Models\ChangeRequest;
use Illuminate\Support\Facades\DB;

class requestedChanges extends Controller
{

  protected function view(Request $request)
  {
    $uri = $request->path();
    if ($uri == 'requested-changes') {
      $uri = "Requested Changes";
    }
    $returnData['changes'] = ChangeRequest::where('status', 'null')->orderBy('id', 'desc')->paginate(50);

    $returnData['uri'] = $uri;
    return view('requested_changes', ['dataArray' => $returnData]);
  }


  protected function viewApproved(Request $request)
  {
    $uri = $request->path();
    if ($uri == 'approved-changes') {
      $uri = "Approved Changes";
    }
    $returnData['changes'] = ChangeRequest::where('status', true)->orWhere('status', 'sent')->orderBy('id', 'desc')->paginate(50);

    $returnData['uri'] = $uri;
    return view('approved_changes', ['dataArray' => $returnData]);
  }


  protected function action(Request $request)
  {
    $action = $request->route('action');
    $id = $request->route('id');
    if (isset($action) && isset($id)) {
      if ($action == 'approve') {

        DB::beginTransaction();

        $query = DB::table('change_request')->where('id', $id)
          ->update(['status' => true]);

        $changeData = ChangeRequest::where('id', $id)->first();

        $changeDataChanges = unserialize($changeData->changes);

        $teamUpdate = Attendees::where('member_uid', $changeData->request_member_uid)
          ->update([
            'member_fname' => $changeDataChanges['member_fname'], 'member_lname' => $changeDataChanges['member_lname'], 'Certificate_Type' => $changeDataChanges['Certificate_Type'],
            'certificate_status' => false
          ]);

        $issueCertificate = DB::table('single_certificate_issue')->insert(
          ['uid' => $changeData->request_member_uid]
        );

        if (isset($query) && isset($teamUpdate) && isset($issueCertificate)) {
          DB::commit();
        } else {
          DB::rollBack();
        }
      } else {
        $query = DB::table('change_request')->where('id', $id)
          ->update(['status' => false]);
      }
    }
    if (isset($query)) {
      return redirect('requested-changes')->with('success', 'Successfully approved the changes.');
    } else {
      return redirect('requested-changes')->with('error', 'Unable to process the request.');
    }
  }
}
