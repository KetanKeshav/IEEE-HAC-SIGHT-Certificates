<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Attendees;
use App\Models\Email;
use App\Models\EmailTemplates;
use App;


class SendCertificates extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'certificate:all';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Send certificate to all.';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    // if (App::environment('local')) {
    //   $baseURL = 'http://localhost:8000';
    // } else {
    //   $baseURL = 'http://18.220.159.33'; //To be changed
    // }
    $baseURL = 'https://certificate.ieeextreme.org';
    /* Check whether issue all is set or not */
    $systemSettings = DB::table('system_settings')->where('meta_key', 'generate_bulk_certificate')->first();
    $attendeesCount = Attendees::where('certificate_email_status', false)->count();
    $emailContent = false;

    if ($systemSettings->value == "all" && $attendeesCount > 0) {
      $attendees = Attendees::where('certificate_email_status', false)->orderBy('rank', 'ASC')->limit(250)->get();
      foreach ($attendees as $singleAttendees) {
        $emailSubject = null;
        if ($singleAttendees->member_type == 'member') {
          /**
           * Certificate of Participation - Attendees
           */
          $emailVariables_UserName = $singleAttendees->member_fname;
          $emailVariables_SubTitle = "Thanks for participating IEEEXtreme 13.0!";
          $emailVariables_MainTitle = "Download your certificate";
          $emailVariables_EmailText = "The IEEEXtreme Executive Committee would like to extend our sincere appreciation for your
            participation in the IEEEXtreme 13.0 competition. There were over 9,300+
            registered participants and from over 4,000 teams. We could not have achieved achieve this kind of success without
            the extraordinary efforts of the amazing global team of Proctors, & Ambassadors, Judges and of course students!";
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
          $emailSubject = 'IEEEXtreme 13.0 Certificate';
        } else if ($singleAttendees->member_type == 'proctor' || $singleAttendees->member_type == 'ambassador') {
          /**
           * Certificate of Achievement - Ambassador & Proctor
           */
          $emailVariables_UserName = $singleAttendees->member_fname;
          $emailVariables_SubTitle = "Thanks for being with IEEEXtreme 13.0!";
          $emailVariables_MainTitle = "Download your certificate";
          $emailVariables_EmailText = "The IEEEXtreme Executive Committee would like to extend our sincere appreciation for your
            participation in the IEEEXtreme 13.0 competition. There were over 9,300+
            registered participants and from over 4,000 teams. We could not have achieved achieve this kind of success without
            the extraordinary efforts of the amazing global team of Proctors, & Ambassadors, Judges and of course students!";
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
          $emailSubject = 'IEEEXtreme 13.0 Certificate of Appreciation';
        } else if ($singleAttendees->member_type == 'judge' || $singleAttendees->member_type == 'qa') {
          /**
           * Certificate of Achievement - Judges
           */
          $emailVariables_UserName = $singleAttendees->member_fname;
          $emailVariables_SubTitle = "Thanks for participating IEEEXtreme 13.0!";
          $emailVariables_MainTitle = "Download your certificate";
          $emailVariables_EmailText = "The IEEEXtreme Executive Committee would like to extend our sincere appreciation for your
            participation in the IEEEXtreme 13.0 competition. There were over 9,300+
            registered participants and from over 4,000 teams. We could not have achieved achieve this kind of success without
            the extraordinary efforts of the amazing global team of Proctors, & Ambassadors, Judges and of course students!";
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
          $emailSubject = 'IEEEXtreme 13.0 Certificate of Appreciation';
        } else if ($singleAttendees->member_type == 'execom') {
          /**
           * Certificate of Achievement - Execom
           */
          $emailVariables_UserName = $singleAttendees->member_fname;
          $emailVariables_SubTitle = "Thanks for participating IEEEXtreme 13.0!";
          $emailVariables_MainTitle = "Download your certificate";
          $emailVariables_EmailText = "The IEEEXtreme Executive Committee would like to extend our sincere appreciation for your
            participation in the IEEEXtreme 13.0 competition. There were over 9,300+
            registered participants and from over 4,000 teams. We could not have achieved achieve this kind of success without
            the extraordinary efforts of the amazing global team of Proctors, & Ambassadors, Judges and of course students!";
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
          $emailSubject = 'IEEEXtreme 13.0 Certificate of Appreciation';
        }

        if ($emailContent && $singleAttendees && filter_var($singleAttendees->member_email, FILTER_VALIDATE_EMAIL)) {
          try {
            $mail = new Email(true, $emailContent);
            if ($singleAttendees->member_email && $singleAttendees->member_fname && $singleAttendees->member_fname != '') {
              $mail->addAddress($singleAttendees->member_email, $singleAttendees->member_fname . ' ' . $singleAttendees->member_lname);
            } else if ($singleAttendees->member_email && $singleAttendees->member_lname && $singleAttendees->member_lname != '') {
              $mail->addAddress($singleAttendees->member_email, $singleAttendees->member_lname);
            }
            $mail->Subject = $emailSubject;
            if ($singleAttendees->member_email && $mail->send()) {
              echo "Sent";
              DB::table('attendees')->where('member_uid', $singleAttendees->member_uid)
                ->update(['certificate_email_status' => true]);
            } else {
              echo '\n Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
              DB::table('attendees')->where('member_uid', $singleAttendees->member_uid)
                ->update(['email_log' => serialize($mail->ErrorInfo)]);
            }
          } catch (Exception $e) {
            echo '\n Message could not be sent. Mailer Error: ' . $singleAttendees->member_email;
            DB::table('attendees')->where('member_uid', $singleAttendees->member_uid)
              ->update(['certificate_email_status' => 1, 'email_log' => 'unable to send']);

            // DB::table('attendees')->where('member_uid',$singleAttendees->member_uid)
            // ->update(['certificate_email_status' => 2, 'email_log' => serialize($mail->ErrorInfo)]);
          }
        } else {
          DB::table('attendees')->where('member_uid', $singleAttendees->member_uid)
            ->update(['certificate_email_status' => 1, 'email_log' => 'invalid email']);
        }
      }
    } else if ($systemSettings->value == true && $attendeesCount <= 0) {
      DB::table('system_settings')->where('meta_key', 'generate_bulk_certificate')
        ->update(['value' => false]);
      echo "Bulk Certificate Status True but no more pending certificates";
    } else {
      echo "Bulk Certificate Status False";
    }
  }
}
