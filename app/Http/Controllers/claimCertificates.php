<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Functions;
use App;
use Illuminate\Support\Facades\Validator;

class claimCertificates extends Controller
{
  protected function view()
  {
    return view('claim_certificates');
  }


  protected function download(Request $request)
  {
    $rules = [
      'searchKey' => 'required',
      'memberType' => 'required',
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      $messages = $validator->messages();
      $errors = $messages->all();
      return  response()->json(['errors' => $errors], 404);
    }
    $searchKey = $request->input('searchKey');
    // $userMemberNumber = $request->input('memberNumber');
    $userMemberType = $request->input('memberType');


    $userData = Functions::getDetails($searchKey, $userMemberType);
    if (!$userData) {
      return response()->json(['error' => 'We are unable to identify your certificate.<br/>
        Please contact <a href="mailto:xtremecert@ieee.org">xtremecert@ieee.org</a> for further informations.'], 404);
    }

    /**
     * Certificate Variables - Certificate Title
     */
    $certTitle = $certContent = null;
    $certSubTitle = "THIS IS TO THANK";
    if (isset($userData['Certificate_Type']) && $userData['Certificate_Type'] == 'CONGO') {
      if ($userData['team_rank'] > 0 && $userData['team_rank'] <= 100) {
        $certTitle = 'Certificate of Achievement';
        $certContent = '<p class="name">' . $userData['name'] . '</p>
          <p>From team <span class="teamName">' . $userData['Certificate_Type'] . '</span>
          Ranked <span class="teamRank">' . $userData['team_rank'] . '</span></p>
          <p>In the IEEEXtreme 14.0 programming competition that hosted +7,300 participants</p>';
      } else {
        $certTitle = 'Certificate of Participation';
        $certContent = '<p class="name">' . $userData['name'] . '</p>
          <p>From team <span class="teamName">' . $userData['Certificate_Type'] . '</span>
          Participated in IEEEXtreme 14.0 Programming<br /><br />Competition that Hosted +7,300 Participants</p>';
      }
      $certSubTitle = "This is to certify that";
    } else if (isset($userData['Certificate_Type']) && $userData['Certificate_Type'] == 'proctor') {
      $certTitle = 'Certificate of Appreciation';
      $certSubTitle = "This is to certify that";
      $certContent = '<p class="name">' . $userData['name'] . '</p>
        <p>Volunteered as proctor to guide and oversee competing teams for the IEEEXtreme<br /><br />
        14.0 programming competition that hosted +7,300 participants</p>';
    } else if (isset($userData['Certificate_Type']) && $userData['Certificate_Type'] == 'judge') {
      $certTitle = 'Certificate of Appreciation';
      $certSubTitle = "This is to certify that";
      $certContent = '<p class="name">' . $userData['name'] . '</p>
        <p>Volunteered as a Judge for the IEEEXtreme 14.0 programming competition that<br /><br />
        hosted +7,300 participants</p>';
    } else if (isset($userData['Certificate_Type']) && $userData['Certificate_Type'] == 'qa') {
      $certTitle = 'Certificate of Appreciation';
      $certSubTitle = "This is to certify that";
      $certContent = '<p class="name">' . $userData['name'] . '</p>
        <p>Volunteered as a Quality Assurance team member for the IEEEXtreme 14.0<br /><br />
        programming competition that hosted +7,300 participants</p>';
    } else if (isset($userData['Certificate_Type']) && $userData['Certificate_Type'] == 'ambassador') {
      $certTitle = 'Certificate of Appreciation';
      $certSubTitle = "This is to certify that";
      $certContent = '<p class="name">' . $userData['name'] . '</p>
        <p>Volunteered as an Ambassador in the IEEEXtreme 14.0<br /><br />
        programming competition that hosted +7,300 participants</p>';
    } else if (isset($userData['Certificate_Type']) && $userData['Certificate_Type'] == 'execom') {
      $certTitle = 'Certificate of Appreciation';
      $certSubTitle = "This is to certify that";
      $certContent = '<p class="name">' . $userData['name'] . '</p>
        <p>Volunteered as an Executive Committee Member for the IEEEXtreme 14.0
        <br /><br />programming competition that hosted +7,300 participants</p>';
    } else {
      $certTitle = 'Certificate of Participation';
      $certContent = '<p class="name">' . $userData['name'] . '</p>
        <p>From team <span class="teamName">' . $userData['Certificate_Type'] . '</span>
        Participated in IEEEXtreme 14.0 Programming<br /><br />Competition that Hosted +7,300 Participants</p>';
      $certSubTitle = "This is to certify that";
    }

    $data = '<html>
      <head>
      <style>' . "
      @font-face {
        font-family: 'Corsiva-I';
        src: url('fonts/MonotypeCorsiva.ttf') format('truetype');
        font-style: normal;
      }" . '
      html {
        margin:0px 0px;
      }
      @page { margin: 0px 0px; }
      body {
        font-family: "Corsiva-I";
        margin:0px;
      }
      .headerLine {
        height: 40px;
        background-color:#00629b;
        margin-bottom:30px;
      }
      .topPage {
        padding: 20px 0px 10px 0px;
        font-size:48px;
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
        font-size:35px;
        text-align:center;
      }
      p.date {
        font-size:26px;
        z-index:100;
      }
      span.teamName {
        color:#00629b;
      }
      span.teamRank {
        color:#00629b;
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
      <div class="headerLine"></div>
      <div class="ieeeLogo"><img src="img/ieee_mb_blue.png" width="284"/></div>
      <div class="topPage">' . $certTitle . '</div>
      <p><span>' . $certSubTitle . '</span></p>
      ' . $certContent . '
      <p class="date">24th October 2020</p>
      <div class="footer"><img src="img/footer.png" width="1135"/></div>
      </body>
      </html>';
    $pdf = App::make('dompdf.wrapper')->setPaper('a4', 'landscape');
    $pdf->loadHTML($data);

    return $pdf->stream($userData['member_uid'] . '.pdf');

    // $outputData = $pdf->output();
    // $response = file_put_contents('certificates/'.$userID.'.pdf', $outputData);
    // //
    // // if($response) {
    // //   DB::table('single_certificate_issue')->where('uid',$userID)
    // //   ->update(['status' => true]);
    // // }
    //
    // return $pdf->stream($userID.'.pdf');
  }
}
