<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationEmail extends Model
{
  public function __construct($user_name, $notification_content)
  {
    $this->user_name = $user_name;
    $this->notification_content = $notification_content;
  }
  public function GenerateEmailTemplate()
  {
    $EmailTemplate = "<p>Dear " . $this->user_name . ",</p>";
    $EmailTemplate .= "<p>" . $this->notification_content . "</p>";
    $EmailTemplate .= "<p>Thanks, <br /> IEEEXtreme Team</p>";
    return ($EmailTemplate);
  }
}
