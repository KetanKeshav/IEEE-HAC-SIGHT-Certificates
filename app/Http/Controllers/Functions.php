<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Attendees;

use Illuminate\Http\Request;

class Functions extends Controller
{
  public static function getDetails($searchKey, $userMemberType)
  {
    // $count = DB::table('single_certificate_issue')->where('uid', $userID)->count();
    // if($count<=0)
    //  return false;
    // $memberType = DB::table('single_certificate_issue')->where('uid', $userID)->first();
    // $searchKey = $memberType->type.'_uid';
    // $result = Attendees::where($searchKey,$userID)->first();
    // $userNameKey = $memberType->type.'_name';
    // $returnData['name'] = $result->$userNameKey;
    // $returnData['teamName'] = $result->team_name;

    // if($userEmail && $userMemberNumber && $userEmail != '' && $userMemberNumber !='') {
    //
    //   // Query Builder
    //   if($userMemberType != '' && $userMemberType != 'execom') {
    //     $query = [
    //       ['member_email',$userEmail],
    //       ['member_type',$userMemberType],
    //       ['bulk_data', 'like', '%'.$userMemberNumber.'%'],
    //     ];
    //   } else if($userMemberType == 'execom'){
    //     $query = [
    //       ['member_email',$userEmail],
    //     ];
    //   } else {
    //     $query = [
    //       ['member_email',$userEmail],
    //       ['bulk_data', 'like', '%'.$userMemberNumber.'%'],
    //     ];
    //   }
    //
    // } else if($userEmail && $userEmail !='') {
    //
    //   // Query Builder
    //   if($userMemberType != '') {
    //     $query = [
    //       ['member_email',$userEmail],
    //       ['member_type',$userMemberType],
    //     ];
    //   } else {
    //     $query = [
    //       ['member_email',$userEmail],
    //     ];
    //   }
    //
    // } else if($userMemberNumber && $userMemberNumber !='') {
    //
    //   // Query Builder
    //   if($userMemberType != '') {
    //     $query = [
    //       ['member_type',$userMemberType],
    //       ['bulk_data', 'like', '%'.$userMemberNumber.'%'],
    //     ];
    //   } else {
    //     $query = [
    //       ['bulk_data', 'like', '%'.$userMemberNumber.'%'],
    //     ];
    //   }
    //
    // } else {
    //   return false;
    // }

    if ($userMemberType != '') {
      $count = Attendees::where([
        ['banned', false],
        ['member_type', $userMemberType],
        ['member_email', $searchKey],
      ])
        ->orWhere([
          ['banned', false],
          ['member_type', $userMemberType],
          ['bulk_data', 'like', '%' . $searchKey . '%'],
        ])->count();
      $result = Attendees::where([
        ['banned', false],
        ['member_type', $userMemberType],
        ['member_email', $searchKey],
      ])
        ->orWhere([
          ['banned', false],
          ['member_type', $userMemberType],
          ['bulk_data', 'like', '%' . $searchKey . '%'],
        ])->first();
    } else {
      $count = Attendees::where('member_email', $searchKey)
        ->orWhere('bulk_data', 'like', '%' . $searchKey . '%')->count();
      $result = Attendees::where('member_email', $searchKey)
        ->orWhere('bulk_data', 'like', '%' . $searchKey . '%')->first();
      // $count = Attendees::where($query)->count();
      // $result = Attendees::where($query)->first();
    }

    if ($count <= 0 || $result->banned) {
      return false;
    }

    $returnData['name'] = $result->member_fname . ' ' . $result->member_lname;
    $returnData['team_name'] = $result->team_name;
    $returnData['team_rank'] = $result->rank;
    $returnData['member_uid'] = $result->member_uid;
    $returnData['member_type'] = strtolower($result->member_type);

    $result->certificate_status = true;
    $result->save();
    return ($returnData);
  }
}
