<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendees;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Functions;
use App;

class issueCertificates extends Controller
{
  /**
   * Issue Certificate - Download Page
   * @author Tittu Varghese (tittu@servntire.com)
   *
   * @param  Request | $request
   * @return array | $dataArray
   * @return view | issue-certificates
   */

  protected function view(Request $request)
  {
    $uri = $request->path();
    if ($uri == 'issue-certificates') {
      $uri = "Issue Certificates";
    }

    $searchTerm = $request->input('s');
    if (isset($searchTerm)) {
      $returnData['attendees'] = Attendees::where([
        ['banned', false],
        ['bulk_data', 'like', '%' . $searchTerm . '%']
      ])->paginate(50);
    } else {
      $returnData['attendees'] = Attendees::where('banned', false)->orderBy('rank', 'asc')->orderBy('team_name', 'asc')->paginate(50);
    }
    $returnData['uri'] = $uri;

    return view('issue_certificates', ['dataArray' => $returnData]);
  }

  /**
   * Issue Certificate - Issue Page
   * @author Tittu Varghese (tittu@servntire.com)
   *
   * @param  Request | $request
   * @return array | $dataArray
   * @return view | issue-certificates
   */
  protected function issue(Request $request)
  {
    $uid = $request->route('uid');
    // $type = $request->route('type');

    if (isset($uid)) {
      if ($uid == 'download') {
        $users = Attendees::get(); // All users
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($users, ['member_uid', 'member_fname', 'member_email', 'member_type'])->download();
        exit();
        //return redirect('issue-certificates')->with('success', 'Successfully downloaded the csv.');

      } else if ($uid == 'all') {
        $query = DB::table('system_settings')->where('meta_key', 'generate_bulk_certificate')->update(
          ['value' => 'all']
        );
      } else {
        $attendee = Attendees::where('member_uid', $uid)->first();
        $attendee->certificate_status = 0;
        $attendee->certificate_email_status = 0;
        $attendee->save();
        $query = DB::table('single_certificate_issue')->insert(
          ['uid' => $uid]
        );
      }
    }
    if (isset($query)) {
      return redirect('issue-certificates')->with('success', 'Successfully added to the que to issue certificates.');
    } else {
      return redirect('issue-certificates')->with('error', 'Unable to process the request.');
    }
  }

  /**
   * Issue Certificates - Download Page
   * @author Tittu Varghese (tittu@servntire.com)
   *
   * @param  Request | $request
   * @return array | $dataArray
   * @return stream | PDF download
   */

  protected function download(Request $request)
  {
    $userID = $request->route('uid');
    $userData = Functions::getDetails($userID, "");
    if (!$userData) {
      return redirect('/error');
    }
    /**
     * Certificate Variables - Certificate Title
     */
    $certTitle = $certContent = null;
    $certSubTitle = "THIS IS TO THANK";
    if (isset($userData['member_type']) && $userData['member_type'] == 'member') {
        $certTitle = 'IEEE HAC & SIGHT recognize the successful completion of the project named';
        $certContent = '<p class="name">' . $userData['name'] . '</p>
        <br><br><br><br>
          <p class="teamName">undertaken in ' . $userData['team_name'] . '</p>
          <p class="teamRank">Completed ' . $userData['team_rank'] . '</p>';
      /**$certSubTitle = "This is to certify that";*/
    } else if (isset($userData['member_type']) && $userData['member_type'] == 'Team Leader') {
      $certTitle = 'Certificate of Appreciation';
      $certSubTitle = "This is to certify that";
      $certContent = '<p class="name">' . $userData['name'] . '</p>
        <p>Volunteered as proctor to guide and oversee competing teams for the IEEEXtreme<br /><br />
        14.0 programming competition that hosted +7,300 participants</p>';
    } else if (isset($userData['member_type']) && $userData['member_type'] == 'judge') {
      $certTitle = 'Certificate of Appreciation';
      $certSubTitle = "This is to certify that";
      $certContent = '<p class="name">' . $userData['name'] . '</p>
        <p>Volunteered as a Judge for the IEEEXtreme 14.0 programming competition that<br /><br />
        hosted +7,300 participants</p>';
    } else if (isset($userData['member_type']) && $userData['member_type'] == 'qa') {
      $certTitle = 'Certificate of Appreciation';
      $certSubTitle = "This is to certify that";
      $certContent = '<p class="name">' . $userData['name'] . '</p>
        <p>Volunteered as a Quality Assurance team member for the IEEEXtreme 14.0<br /><br />
        programming competition that hosted +7,300 participants</p>';
    } else if (isset($userData['member_type']) && $userData['member_type'] == 'ambassador') {
      $certTitle = 'Certificate of Appreciation';
      $certSubTitle = "This is to certify that";
      $certContent = '<p class="name">' . $userData['name'] . '</p>
        <p>Volunteered as an Ambassador in the IEEEXtreme 14.0<br /><br />
        programming competition that hosted +7,300 participants</p>';
    } else if (isset($userData['member_type']) && $userData['member_type'] == 'execom') {
      $certTitle = 'Certificate of Appreciation';
      $certSubTitle = "This is to certify that";
      $certContent = '<p class="name">' . $userData['name'] . '</p>
        <p>Volunteered as an Executive Committee Member for the IEEEXtreme 14.0
        <br /><br />programming competition that hosted +7,300 participants</p>';
    } else {
      $certTitle = 'Certificate of Participation';
      $certContent = '<p class="name">' . $userData['name'] . '</p>
        <p>From team <span class="teamName">' . $userData['team_name'] . '</span>
        Participated in IEEEXtreme 14.0 Programming<br /><br />Competition that Hosted +7,300 Participants</p>';
      $certSubTitle = "This is to certify that";
    }

    $data = '<html>
      <head>
      <style>' . "
      @font-face {
        font-family: 'Calibri;
        src: url('fonts/Calibri Regular.ttf') format('truetype');
        font-style: normal;
      }" . '
      html {
        margin:0px 0px;
      }
      @page { margin: 0px 0px; }
      body {
        font-family: "Calibri";
        margin:0px;
      }
      .headerLine {
        height: 40px;
        background-color:#00629b;
        margin-bottom:30px;
      }
      .topPage {
        padding: 20px 0px 10px 0px;
        font-size:26px;
        width:100%;
        color: #000;
        text-align:center;
        margin-bottom:15px;
      }
      .ieeeLogo {
        text-align:center;
        margin-top:15px;
        margin-bottom:10px;
      }
      .heading {
        font-size:35px;
        color:#00629b;
        text-align:center;
      }
      .headingLine {
        height:4px;
        width:5%;
        background-color:#00629b;
        margin: 0 auto;
      }
      p {
        color:#666666;
        font-size:26px;
        line-height:100%;
        text-align:center;
      }
      p.name {
        color: #00629b;
        font-size:70px;
        text-align:center;
        margin: 0 auto;
      }
      p.date {
        font-size:26px;
        z-index:100;
      }
      p.teamName {
        color:#000000;
      }
      p.teamRank {
        color:#00629B;
      }
      span {
        color: #666666;
      }
      .footer {
        bottom: 0;
        position:absolute;
        z-index:1;
      }
      </style>
      </head>
      <body>
      <div class="headerLine"><img src="img/HeaderHacSight.png" width="1123"/></div>
      <br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="topPage">' . $certTitle . '</div>
      ' . $certContent . '
      <div class="footer"><img src="img/FooterHacSight.png" width="1123"/></div>
      </body>
      </html>';
    $pdf = App::make('dompdf.wrapper')->setPaper('a4', 'landscape');
    $pdf->loadHTML($data);

    return $pdf->stream($userData['member_uid'] . '.pdf');

    // $outputData = $pdf->output(); //
    // $response = file_put_contents('certificates/'.$userID.'.pdf', $outputData);
    // //
    // // if($response) {
    // //   DB::table('single_certificate_issue')->where('uid',$userID)
    // //   ->update(['status' => true]);
    // // }
    //
    // return $pdf->stream($userID.'.pdf');
  }

  /**
   * Issued Certificates - Issued Certificates Page
   * @author Tittu Varghese (tittu@servntire.com)
   *
   * @param  Request | $request
   * @return array | $dataArray
   * @return view | issued-certificates
   */
  protected function issuedView(Request $request)
  {
    $uri = $request->path();
    if ($uri == 'issued-certificates') {
      $uri = "Issued Certificates";
    }

    $returnData['attendees'] = Attendees::where('certificate_status', true)->orderBy('team_name', 'asc')->paginate(50);
    $returnData['uri'] = $uri;

    return view('issued_certificates', ['dataArray' => $returnData]);
  }

  /**
   * Pending Certificates - Pending Certificates Page
   * @author Tittu Varghese (tittu@servntire.com)
   *
   * @param  Request | $request
   * @return array | $dataArray
   * @return view | pending-certificates
   */
  protected function pendingCertificateView(Request $request)
  {
    $uri = $request->path();
    if ($uri == 'pending-certificates') {
      $uri = "Pending Certificates";
    }

    $returnData['attendees'] = Attendees::where('certificate_status', false)->orderBy('rank', 'asc')->orderBy('team_name', 'asc')->paginate(50);
    $returnData['uri'] = $uri;

    return view('issued_certificates', ['dataArray' => $returnData]);
  }
}
