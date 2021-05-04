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
  /**
   * Import Attendees - View Page
   * @author Tittu Varghese (tittu@servntire.com)
   *
   * @param  Request | $request
   * @return array | $dataArray
   * @return view | import_attendees
   */

  protected function view(Request $request)
  {

    $uri = $request->path();
    if ($uri == 'import-attendees') {
      $uri = "Import Attendees";
    }
    $returnData['uri'] = $uri;

    return view('import_attendees', ['dataArray' => $returnData]);
  }

  /**
   * Import Attendees - View Page
   * @author Tittu Varghese (tittu@servntire.com)
   *
   * @param  Request | $request
   * @return array | $dataArray
   * @return view | import_attendees
   */

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
      $newTeamMember = true;
      $memberFieldCounter = 2;
      $teamId = $hashids->encode(time(), rand(1111, 99999));

      while ($newTeamMember == true) {
        $attendees = new Attendees();
        $firstNameFiled = 0 + $memberFieldCounter; // 2
        $lastNameFiled = 1 + $memberFieldCounter; // 3
        $emailFiled = 2 + $memberFieldCounter; // 4
        $memberNumberField = 3 + $memberFieldCounter;

        $hashids = new Hashids($singleRecord[$emailFiled]); // Member Email Address as Salt

        $attendees['rank'] = (int)$singleRecord[0];
        $attendees['team_name'] = $singleRecord[1];
        $attendees['team_id'] = $teamId;
        $attendees['member_uid'] = $hashids->encode(time(), rand(1111, 99999), rand(11, 999));
        $attendees['member_fname'] = $singleRecord[$firstNameFiled];
        $attendees['member_lname'] = $singleRecord[$lastNameFiled];
        $attendees['member_email'] = $singleRecord[$emailFiled];
        if (isset($singleRecord[14]) && $singleRecord[14] != '') {
          $attendees['member_type'] = $singleRecord[14];
        }
        $attendees['member_number'] = $singleRecord[$memberNumberField];
        $attendees['bulk_data'] = serialize($attendees);
        unset($attendees['member_number']);

        $importStatus['data'] = $attendees;

        if ($attendees->save()) {
          $importStatus['status'] = "Yes";
        } else {
          $importStatus['status'] = "No";
        }
        $returnData['importStatus'][] = $importStatus;

        /* Checking for other members in the team */
        $memberFieldCounter += 4;

        if (isset($singleRecord[$memberFieldCounter]) && $singleRecord[$memberFieldCounter] == '') {
          $newTeamMember = false;
        } else if (!isset($singleRecord[$memberFieldCounter])) {
          $newTeamMember = false;
        } else if (empty($singleRecord[$memberFieldCounter])) {
          $newTeamMember = false;
        } else if ($memberFieldCounter > 10) {
          $newTeamMember = false;
        }
      }
    }
    return view('import_attendees', ['dataArray' => $returnData]);
  }
}
