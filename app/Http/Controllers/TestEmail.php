<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;
use App\Models\EmailTemplates;
use Illuminate\Support\Facades\DB;
use App\Models\Attendees;

class TestEmail extends Controller
{
  protected function test(Request $request)
  {
    $baseURL = "http://certificate.ieeextreme.org";
    $emailType = $request->route('emailType');
    $singleIssueCount = DB::table('single_certificate_issue')->where('status', false)->count();
    if ($singleIssueCount > 0) {
      $singleIssueRequest = DB::table('single_certificate_issue')->where('status', false)->orderBy('id', 'desc')->limit(1)->get();
      foreach ($singleIssueRequest as $singleChangeRequest) {
        $singleAttendees = Attendees::where('member_uid', $singleChangeRequest->uid)->first();
        $emailSubject = null;
        if ($singleAttendees->member_type == 'member') {
          /**
           * Certificate of Participation - Attendees
           */
          $emailVariables_UserName = $singleAttendees->member_fname;
          $emailVariables_SubTitle = "Thanks for participating IEEEXtreme 12.0!";
          $emailVariables_MainTitle = "Download your certificate";
          $emailVariables_EmailText = "The IEEEXtreme Executive Committee would like to extend our sincere appreciation for your
          participation in the IEEEXtreme 12.0 competition. This was the largest event to date with 9.500
          registered participants and 4,024 teams representing a 20% increase over last year. We hope
          you enjoyed the competition and will join us again next year if eligible.";
          $emailVariables_EmailTextFeedback = "Our aspiration is to ensure the competition continues to be fun and engaging.
          In the coming days, you will be receiving an email from the corporate Headquarters with the subject line:   <b><i>A special request from IEEE</i></b> which will include a survey.
          We strive every year to make the competition better and utilize this survey to help accomplish this goal.
          We ask that you kindly complete this survey to help us with this goal.";
          $emailVariables_ButtonLink = $baseURL . "/generate/" . $singleAttendees->member_uid;
          $emailVariables_ButtonText = "DOWNLOAD CERTIFICATE";
          $emailVariables_RequestChangeLink = $baseURL . "/request-changes/" . $singleAttendees->member_uid;
          $emailTemplate = new EmailTemplates($emailVariables_UserName, $emailVariables_SubTitle, $emailVariables_MainTitle, $emailVariables_EmailText, $emailVariables_EmailTextFeedback, $emailVariables_ButtonLink, $emailVariables_ButtonText, $emailVariables_RequestChangeLink);
          $emailContent = $emailTemplate->GenerateEmailTemplate();
          //echo $emailContent;
          $emailSubject = 'IEEEXtreme 12.0 Certificate & Gifts';
        } else if ($singleAttendees->member_type == 'proctor' || $singleAttendees->member_type == 'ambassador') {
          /**
           * Certificate of Achievement - Ambassador & Proctor
           */
          $emailVariables_UserName = $singleAttendees->member_fname;
          $emailVariables_SubTitle = "Thanks for being with IEEEXtreme 12.0!";
          $emailVariables_MainTitle = "Download your certificate";
          $emailVariables_EmailText = "The IEEEXtreme Executive Committee would like to extend our sincere appreciation for your contribution to the IEEEXtreme 12.0 competition.  This was the largest event to date with 9.500 registered participants and 4,024 teams representing a 20% increase over last year. We couldn’t achieve this kind of success without the extraordinary efforts of the amazing team of Proctors & Ambassadors!";
          $emailVariables_EmailTextFeedback = "Our aspiration is to ensure the competition continues to be fun and engaging.
          In the coming days, you will be receiving an email from the corporate Headquarters with the subject line:   <b><i>A special request from IEEE</i></b> which will include a survey.
          We strive every year to make the competition better and utilize this survey to help accomplish this goal.
          We ask that you kindly complete this survey to help us with this goal.";
          $emailVariables_ButtonLink = $baseURL . "/generate/" . $singleAttendees->member_uid;
          $emailVariables_ButtonText = "DOWNLOAD CERTIFICATE";
          $emailVariables_RequestChangeLink = $baseURL . "/request-changes/" . $singleAttendees->member_uid;
          $emailTemplate = new EmailTemplates($emailVariables_UserName, $emailVariables_SubTitle, $emailVariables_MainTitle, $emailVariables_EmailText, $emailVariables_EmailTextFeedback, $emailVariables_ButtonLink, $emailVariables_ButtonText, $emailVariables_RequestChangeLink);
          $emailContent = $emailTemplate->GenerateEmailTemplate();
          //echo $emailContent;
          $emailSubject = 'IEEEXtreme 12.0 Certificate of Appreciation';
        } else if ($singleAttendees->member_type == 'judge' || $singleAttendees->member_type == 'qa') {
          /**
           * Certificate of Achievement - Judges
           */
          $emailVariables_UserName = $singleAttendees->member_fname;
          $emailVariables_SubTitle = "Thanks for participating IEEEXtreme 12.0!";
          $emailVariables_MainTitle = "Download your certificate";
          $emailVariables_EmailText = "The IEEEXtreme Executive Committee would like to extend our sincere appreciation for your contribution to the IEEEXtreme 12.0 competition.  This was the largest event to date with 9.500 registered participants and 4,024 teams representing a 20% increase over last year. We couldn't achieve this kind of success without the extraordinary efforts of the amazing team of Judges and QAs!";
          $emailVariables_EmailTextFeedback = "Our aspiration is to ensure the competition continues to be fun and engaging.
          In the coming days, you will be receiving an email from the corporate Headquarters with the subject line:   <b><i>A special request from IEEE</i></b> which will include a survey.
          We strive every year to make the competition better and utilize this survey to help accomplish this goal.
          We ask that you kindly complete this survey to help us with this goal.";
          $emailVariables_ButtonLink = $baseURL . "/generate/" . $singleAttendees->member_uid;
          $emailVariables_ButtonText = "DOWNLOAD CERTIFICATE";
          $emailVariables_RequestChangeLink = $baseURL . "/request-changes/" . $singleAttendees->member_uid;
          $emailTemplate = new EmailTemplates($emailVariables_UserName, $emailVariables_SubTitle, $emailVariables_MainTitle, $emailVariables_EmailText, $emailVariables_EmailTextFeedback, $emailVariables_ButtonLink, $emailVariables_ButtonText, $emailVariables_RequestChangeLink);
          $emailContent = $emailTemplate->GenerateEmailTemplate();
          //echo $emailContent;
          $emailSubject = 'IEEEXtreme 12.0 Certificate of Appreciation';
        } else if ($singleAttendees->member_type == 'execom') {
          /**
           * Certificate of Achievement - Execom
           */
          $emailVariables_UserName = $singleAttendees->member_fname;
          $emailVariables_SubTitle = "Thanks for participating IEEEXtreme 12.0!";
          $emailVariables_MainTitle = "Download your certificate";
          $emailVariables_EmailText = "The IEEEXtreme Executive Committee would like to extend our sincere appreciation for your contribution to the IEEEXtreme 12.0 competition.  This was the largest event to date with 9.500 registered participants and 4,024 teams representing a 20% increase over last year. We couldn't achieve this kind of success without the extraordinary efforts of the amazing execom members!";
          $emailVariables_EmailTextFeedback = "Our aspiration is to ensure the competition continues to be fun and engaging.
          In the coming days, you will be receiving an email from the corporate Headquarters with the subject line:   <b><i>A special request from IEEE</i></b> which will include a survey.
          We strive every year to make the competition better and utilize this survey to help accomplish this goal.
          We ask that you kindly complete this survey to help us with this goal.";
          $emailVariables_ButtonLink = $baseURL . "/generate/" . $singleAttendees->member_uid;
          $emailVariables_ButtonText = "DOWNLOAD CERTIFICATE";
          $emailVariables_RequestChangeLink = $baseURL . "/request-changes/" . $singleAttendees->member_uid;
          $emailTemplate = new EmailTemplates($emailVariables_UserName, $emailVariables_SubTitle, $emailVariables_MainTitle, $emailVariables_EmailText, $emailVariables_EmailTextFeedback, $emailVariables_ButtonLink, $emailVariables_ButtonText, $emailVariables_RequestChangeLink);
          $emailContent = $emailTemplate->GenerateEmailTemplate();
          //echo $emailContent;
          $emailSubject = 'IEEEXtreme 12.0 Certificate of Appreciation';
        }

        // if($emailContent && $singleAttendees) {
        //   try {
        //     $mail = new Email(true,$emailContent);
        //     $mail->addAddress($singleAttendees->member_email,$singleAttendees->member_fname.' '.$singleAttendees->member_lname);
        //     $mail->Subject = $emailSubject;
        //     if($mail->send()) {
        //       DB::table('attendees')->where('member_uid',$singleAttendees->member_uid)
        //       ->update(['certificate_email_status' => true]);
        //       DB::table('change_request')->where('request_member_uid',$singleAttendees->member_uid)
        //       ->update(['status' => 'sent']);
        //       DB::table('single_certificate_issue')->where('uid',$singleAttendees->member_uid)
        //       ->update(['status' => true]);
        //     } else {
        //       echo 'Message could not be sent. Mailer Error: '.$singleAttendees->member_email;
        //       DB::table('attendees')->where('member_uid',$singleAttendees->member_uid)
        //       ->update(['email_log' => serialize($mail->ErrorInfo)]);
        //     }
        //   }
        //   catch (Exception $e) {
        //     echo 'Message could not be sent to .'.$singleAttendees->member_email;
        //     DB::table('attendees')->where('member_uid',$singleAttendees->member_uid)
        //     ->update(['email_log' => serialize($mail->ErrorInfo)]);
        //   }
        // }
      }
    }
  }
}
