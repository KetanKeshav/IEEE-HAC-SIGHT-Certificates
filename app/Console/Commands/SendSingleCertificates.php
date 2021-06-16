<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ChangeRequest;
use App\Models\Attendees;
use App\Models\Email;
use App\Models\EmailTemplates;
use Illuminate\Support\Facades\DB;
use App;


class SendSingleCertificates extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'certificate:single';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Generate Single Certificate';

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
    $attendees = Attendees::where('certificate_email_status', false)->orderBy('id', 'ASC')->limit(250)->get();
    foreach ($attendees as $singleAttendees) {
      //variables
      $full_name = "$singleAttendees->member_fname $singleAttendees->member_lname";
      $memberType = $singleAttendees->Certificate_Type;
      $searchKey = $singleAttendees->Email;
      $sendTo = $singleAttendees->Email;
      $uid = $singleAttendees->member_uid;
      //email setup
      $email = new \SendGrid\Mail\Mail();
      $email->setFrom("ketan.keshav@ieee.org", "IEEE HAC & SIGHT CERTIFICATES");
      $email->setSubject("Claim your IEEEXtreme certificate");
      $email->addTo($sendTo);
      $email->setReplyTo('ketan.keshav@ieee.org');
      $email->setTemplateId("d-93ff64b85a104136a6e19754f90826e6");
      $email->addDynamicTemplateData("full_name", $full_name);
      $email->addDynamicTemplateData("change_url", "https://certificate.ieeextreme.org/request-changes/$uid");
      $email->addDynamicTemplateData("certificate_url", "https://certificate.ieeextreme.org/generate-email-certificate/$uid");
      $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

      try {
        $response = $sendgrid->send($email);
        echo $response->statusCode() . "\n";
        echo $response->body() . "\n";

        DB::table('attendees')->where('member_uid', $singleAttendees->member_uid)
          ->update(['certificate_email_status' => true]);
        //DB::table('change_request')->where('request_member_uid', $singleAttendees->member_uid)
          //->update(['status' => 'sent']);
        DB::table('single_certificate_issue')->where('uid', $singleAttendees->member_uid)
          ->update(['status' => true]);
      } catch (Exception $e) {
        echo '\n Message could not be sent to .' . $singleAttendees->Email;
        echo '\n Caught exception: ' . $e->getMessage() . "\n";
        DB::table('attendees')->where('member_uid', $singleAttendees->member_uid)
          ->update(['email_log' => serialize($e->getMessage())]);
      }
    }
  }
}
