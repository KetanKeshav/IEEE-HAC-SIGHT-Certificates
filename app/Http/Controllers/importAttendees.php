<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Models\Attendees;
use Illuminate\Support\Facades\Storage;
use Hashids\Hashids;

class importAttendees extends Controller
{
  protected function view(Request $request)
  {

    $uri = $request->path();
    if ($uri == 'import-attendees') {
      $uri = "Import Attendees";
    }
    $returnData['uri'] = $uri;

    return view('import_attendees', ['dataArray' => $returnData]);
  }

  protected function upload(Request $request)
  {

    if (!ini_get("auto_detect_line_endings")) {
      ini_set("auto_detect_line_endings", '1');
    }

    $uri = $request->path();
    if ($uri == 'import-attendees') {
      $uri = "Import Attendees";
    }
    $returnData['uri'] = $uri;

    $file = $request->file('UploadAttendeeFile');
    $filename = "ieeextremeAttendees." . $file->getClientOriginalExtension();

    if ($file->getClientOriginalExtension() == "csv") {
      $filePath = $file->storeAs('', $filename);
    } else {
      $filePath = "false";
    }

    $returnData['filePath'] = "../storage/app/uploads/" . $filename;

    $csv = Reader::createFromPath($returnData['filePath'], 'r');

    $headerData = $csv->fetchOne(); //set the CSV header offset

    $headerFilter = (new Statement())->offset(1);
    $attendeeRecords = $headerFilter->process($csv);
    foreach ($attendeeRecords as $singleRecord) {
      $hashids = new Hashids($singleRecord[4]); // Member 1 Email Address as Salt
      $memberFieldCounter = 5;
      $certId = $hashids->encode(time(), rand(1111, 99999));

      //while ($newTeamMember == true) {
        $attendees = new Attendees();
        //$projectNameFiled = 4 + $memberFieldCounter; // 2
        //$lastNameFiled = 2 + $memberFieldCounter; // 3
        $emailFiled = 2 + $memberFieldCounter; // 4
        //$memberNumberField = 3 + $memberFieldCounter;

        $hashids = new Hashids($singleRecord[$emailFiled]); // Member Email Address as Salt

        $attendees['Certificate_Type'] = $singleRecord[0];
        $attendees['Name'] = $singleRecord[1];
        $attendees['cert_id'] = $certId;
        $attendees['member_uid'] = $hashids->encode(time(), rand(1111, 99999), rand(11, 999));
        $attendees['Year'] = $singleRecord[2];
        $attendees['Position_chair_member'] = $singleRecord[3];
        $attendees['Committee_of_person'] = $singleRecord[4];
        $attendees['Date_of_Completion'] = $singleRecord[5];
        $attendees['Project_Name'] = $singleRecord[6];
        $attendees['Month_of_Completion'] = $singleRecord[7];
        $attendees['Email'] = $singleRecord[8];
        $attendees['bulk_data'] = serialize($attendees);
        //unset($attendees['member_number']);

        $importStatus['data'] = $attendees;

        if ($attendees->save()) {
          $importStatus['status'] = "Yes";
        } else {
          $importStatus['status'] = "No";
        }
        $returnData['importStatus'][] = $importStatus;

        /* Checking for other members in the team */
        $memberFieldCounter += 4;
    }
    return view('import_attendees', ['dataArray' => $returnData]);
  }
}
