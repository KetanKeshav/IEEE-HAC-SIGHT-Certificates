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
    // $returnData['teamName'] = $result->Certificate_Type;

    // if($userEmail && $userMemberNumber && $userEmail != '' && $userMemberNumber !='') {
    //
    //   // Query Builder
    //   if($userMemberType != '' && $userMemberType != 'execom') {
    //     $query = [
    //       ['Email',$userEmail],
    //       ['Certificate_Type',$userMemberType],
    //       ['bulk_data', 'like', '%'.$userMemberNumber.'%'],
    //     ];
    //   } else if($userMemberType == 'execom'){
    //     $query = [
    //       ['Email',$userEmail],
    //     ];
    //   } else {
    //     $query = [
    //       ['Email',$userEmail],
    //       ['bulk_data', 'like', '%'.$userMemberNumber.'%'],
    //     ];
    //   }
    //
    // } else if($userEmail && $userEmail !='') {
    //
    //   // Query Builder
    //   if($userMemberType != '') {
    //     $query = [
    //       ['Email',$userEmail],
    //       ['Certificate_Type',$userMemberType],
    //     ];
    //   } else {
    //     $query = [
    //       ['Email',$userEmail],
    //     ];
    //   }
    //
    // } else if($userMemberNumber && $userMemberNumber !='') {
    //
    //   // Query Builder
    //   if($userMemberType != '') {
    //     $query = [
    //       ['Certificate_Type',$userMemberType],
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
        ['Certificate_Type', $userMemberType],
        ['Email', $searchKey],
      ])
        ->orWhere([
          ['banned', false],
          ['Certificate_Type', $userMemberType],
          ['bulk_data', 'like', '%' . $searchKey . '%'],
        ])->count();
      $result = Attendees::where([
        ['banned', false],
        ['Certificate_Type', $userMemberType],
        ['Email', $searchKey],
      ])
        ->orWhere([
          ['banned', false],
          ['Certificate_Type', $userMemberType],
          ['bulk_data', 'like', '%' . $searchKey . '%'],
        ])->first();
    } else {
      $count = Attendees::where('Email', $searchKey)
        ->orWhere('bulk_data', 'like', '%' . $searchKey . '%')->count();
      $result = Attendees::where('Email', $searchKey)
        ->orWhere('bulk_data', 'like', '%' . $searchKey . '%')->first();
      // $count = Attendees::where($query)->count();
      // $result = Attendees::where($query)->first();
    }

    if ($count <= 0 || $result->banned) {
      return false;
    }

    //$returnData['name'] = $result->member_fname . ' ' . $result->member_lname;
    $returnData['Certificate_Type'] = $result->Certificate_Type;
    $returnData['member_uid'] = $result->member_uid;
    $returnData['Project_Name'] = $result ->Project_Name;
    $returnData['Name']=$result->Name;
    $returnData['Date']=$result->Date_of_Completion . ' ' . $result->Month_of_completion . ' ' . $result->Year;
    $returnData['Year']=$result->Year;
    $returnData['Month']=$result->Month_of_completion . '-' . $result->Year;
    $returnData['Committee']=$result->Committee_of_person;
    $returnData['Chair']=$result->Position_chair_member;
    
    $result->certificate_status = true;
    $result->save();
    return ($returnData);
  }
}
