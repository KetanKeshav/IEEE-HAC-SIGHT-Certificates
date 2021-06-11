<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendees;
use App\Models\ChangeRequest;
use App\Models\Email;
use App\Models\NotificationEmail;

class requestChanges extends Controller
{

  protected function view(Request $request)
  {
    $memberUID = $request->route('member_uid');
    $existingRequest = ChangeRequest::where('request_member_uid', $memberUID)->where('status', 'null')->count();
    if ($existingRequest <= 0) {
      $attendee = Attendees::where('member_uid', $memberUID)->first();

      if (isset($attendee)) {

        $returnData['attendee']['cert_id'] = $attendee->cert_id;
        $returnData['attendee']['request_member_uid'] = $attendee->member_uid;
        $returnData['attendee']['Certificate_Type'] = $attendee->Certificate_Type;
        $returnData['attendee']['fname'] = $attendee->member_fname;
        $returnData['attendee']['lname'] = $attendee->member_lname;
        $returnData['attendee']['Certificate_Type'] = $attendee->Certificate_Type;
      } else {
        $returnData['attendee'] = "notFound";
      }
    } else {
      $returnData['attendee'] = "pendingRequest";
    }
    return view('request_changes', ['dataArray' => $returnData]);
  }


  protected function change(Request $request)
  {
    $changeRequest = new ChangeRequest();
    $changeRequest->cert_id = $request->get('cert_id');
    $changeRequest->request_member_uid = $request->get('request_member_uid');
    $changeRequest->Certificate_Type = $request->get('Certificate_Type');

    $requestedChanges['member_fname'] = $request->get('fname');
    $requestedChanges['Certificate_Type'] = $request->get('Certificate_Type');
    $requestedChanges['member_lname'] = $request->get('lname');

    $changeRequest->changes = serialize($requestedChanges);

    if ($changeRequest->save()) {

      /* Sending Notification Email */
      $notificationContent = "You have recieved a change request from " . $requestedChanges['member_fname'] .
        " of " . $requestedChanges['Certificate_Type'];
      $emailTemplate = new NotificationEmail("Tittu", $notificationContent); //To be changed
      $emailContent = $emailTemplate->GenerateEmailTemplate();
      $mail = new Email(true, $emailContent);
      $mail->addAddress('k.werth@ieee.org', 'Kelly Werth'); //To be changed
      $mail->Subject = "Change request from " . $requestedChanges['member_fname'] . ".";
      $mail->send();

      return redirect('request-changes')->with('success', 'Your change request is registered. Our team will validate it soon.');
    } else {
      return redirect('request-changes')->with('error', 'We are unable to process your request.');
    }
  }
}
