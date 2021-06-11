<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendees;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Functions;
use App;

class issueCertificates extends Controller
{
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
      $returnData['attendees'] = Attendees::where('banned', false)->orderBy('id', 'asc')->orderBy('Certificate_Type', 'asc')->paginate(50);
    }
    $returnData['uri'] = $uri;

    return view('issue_certificates', ['dataArray' => $returnData]);
  }

  protected function issue(Request $request)
  {
    $uid = $request->route('uid');
    // $type = $request->route('type');

    if (isset($uid)) {
      if ($uid == 'download') {
        $users = Attendees::get(); // All users
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($users, ['member_uid', 'Project_Name', 'Name', 'Email', 'Certificate_Type'])->download();
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
    
    $certTitle = $certContent = $certHeader = $certFooter = null;
    $certSubTitle = "THIS IS TO THANK";
    if ($userData['Certificate_Type'] == 'COC') {

        $certTitle = '<br><br><br><br><br><br>IEEE HAC & SIGHT recognize the successful completion of the project named';
        $certContent = '<p class="name">' . $userData['Project_Name'] . '</p>
        <br><br><br><br>
          <p class="teamName">undertaken in COVID-19</p>
          <p class="teamRank">Completed ' . $userData['Month'] . '</p>';
        $certHeader = '<div class="headerLine"><img src="img/HacSightHeader.png" width="1123"/> </div>';
        $certFooter = '<div class="footer"><img src="img/HacSightFooter.png" width="1123"/></div>';
        
      /**$certSubTitle = "This is to certify that";*/
    }

    else if ($userData['Certificate_Type'] == 'COA') {
      $certTitle = 'The IEEE Special Interest Group on Humanitarian Technology is pleased to present this certificate to: <br>';
        $certContent = '<p class="name">' . $userData['Name'] . '</p>
        <br><br><br>
          <p class="COA"> in appreciation of your efforts to support IEEE volunteers around the world carrying our impactful humanitarian activities </p>
          <br><br>
          <p class="teamName"> as '. $userData['Chair'] . ' of the </p>
          <br><br>
          <p class="COA1">IEEE SIGHT ' . $userData['Committee'] . '</p>;
          <br><br><br>  
          <p class="COA1"><b> January - December ' . $userData['Year'] . '</b></p>' ;
        $certHeader = '<div class="headerLine"><img src="img/COAHeader.png" width="1123"/> </div>';
        $certFooter = '<div class="footer"><img src="img/SIGHTFooter.jpg" width="1123"/></div>';
    /**$certSubTitle = "This is to certify that";*/
    }

    else if ($userData['Certificate_Type'] == 'COR') {
      $certTitle = 'The IEEE Humanitarian Activities Committee is pleased to present this certificate to:<br>';
        $certContent = '<p class="name">' . $userData['Name'] . '</p>
        <br><br><br>
          <p class="COA"> in appreciation of your efforts to support IEEE volunteers around the world carrying our impactful humanitarian activities </p>
          <br><br><br>
          <p class="COR"> as the </p>
          <br><br><br>
          <p class="COR1">IEEE Humanitarian Activities Committee (HAC) </p>
          <br><br>
          <p class="COR1">' . $userData['Committee'] . ' ' . $userData['Chair'] . '</p>;
          <br><br><br>  
          <p class="COR2"><b> January 1, ' . $userData['Year'] . ' - December 31, ' . $userData['Year'] . '</b></p>' ;
        $certHeader = '<div class="headerLine"><img src="img/CORHeader.png" width="1123"/> </div>';
        $certFooter = '<div class="footer"><img src="img/HACFooter.jpg" width="1123"/></div>';
    /**$certSubTitle = "This is to certify that";*/
    }

    else if ($userData['Certificate_Type'] == 'CONGO') {
      $certTitle = '<p class = "CONGO1"> The IEEE Special Interest Group on Humanitarian Technology (SIGHT) ' . $userData['Year'] . ' Steering Committee recognizes<br></p>';
        
      $certContent = '<br><br><br><br><p class="name">' . $userData['Name'] . '</p>
        <br><br><br><br><br><br><br>
          <p class="CONGO2"> for successfully completing the IEEE SIGHT Trivia Challenge and participating in SIGHT Day ' . $userData['Year'] . ' activities. </p>
          <br><br><br>
          <br>
          <p class="COR1">IEEE SIGHT Day Champion</p>;
          <br><br><br><br>
          <p class="COR2"><b> Awarded on the first IEEE SIGHT Day ' . $userData['Date'] . '</b></p>' ;
        $certHeader = '<div class="headerLine"><img src="img/CONGOHeader.png" width="1123"/> </div>';
        $certFooter = '<div class="footer"><img src="img/SteeringFooter.png" width="1123"/></div>';
    /**$certSubTitle = "This is to certify that";*/
    }
    
    /*else {
      $certTitle = 'Certificate of Participation';
      $certContent = '<p class="name">' . $userData['name'] . '</p>
        <p>From team <span class="teamName">' . $userData['Certificate_Type'] . '</span>
        Participated in IEEEXtreme 14.0 Programming<br /><br />Competition that Hosted +7,300 Participants</p>';
      $certSubTitle = "This is to certify that";
    }*/
    
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
      p.COA {
        color: #000000;
        font-size:20px;
        text-align:center;
        margin: 0 auto;
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
        font-size:50px;
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
      p.COA1 {
        color:#00629B;
        margin: 0 auto;
      }
      p.COR {
        color:#000000;
        font-size:30px;
        margin: 0 auto;
      }
      p.COR1 {
        color:#00629B;
        font-size:32px;
        margin: 0 auto;
      }

      p.COR2 {
        color:#00629B;
        font-size:40px;
        margin: 0 auto;
      }

      p.CONGO1 {
        color:#000000;
        font-size:24px;
        margin: 0 auto;
      }
      p.CONGO2 {
        color: #000000;
        font-size:24px;
        text-align:center;
        margin: 0 auto;
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
      ' . $certHeader . '
      <br><br><br>
      <div class="topPage">' . $certTitle . '</div>
      ' . $certContent . '
      ' . $certFooter . '
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

  protected function issuedView(Request $request)
  {
    $uri = $request->path();
    if ($uri == 'issued-certificates') {
      $uri = "Issued Certificates";
    }

    $returnData['attendees'] = Attendees::where('certificate_status', true)->orderBy('Certificate_Type', 'asc')->paginate(50);
    $returnData['uri'] = $uri;

    return view('issued_certificates', ['dataArray' => $returnData]);
  }

  protected function pendingCertificateView(Request $request)
  {
    $uri = $request->path();
    if ($uri == 'pending-certificates') {
      $uri = "Pending Certificates";
    }

    $returnData['attendees'] = Attendees::where('certificate_status', false)->orderBy('id', 'asc')->orderBy('Certificate_Type', 'asc')->paginate(50);
    $returnData['uri'] = $uri;

    return view('issued_certificates', ['dataArray' => $returnData]);
  }
}
