<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email extends PHPMailer
{
  public function __construct($exceptions, $body = '')
  {
    parent::__construct($exceptions);
    $this->addReplyTo('xtremecert@ieee.org', 'IEEEXtreme Certificate');
    $this->setFrom('certificate@ieeextreme.org', 'IEEEXtreme Certificate');
    $this->isSMTP();
    $this->Host = 'ssl://smtp.zoho.in:465';
    $this->SMTPAuth = true;
    $this->Username = 'certificate@ieeextreme.org';
    $this->Password = 'tdg5PO9KU7n_hQ0cRuZY4';
    $this->msgHTML($body);
    $this->SMTPDebug = 0;
    $this->Debugoutput = function ($str, $level) {
      echo "Debug level $level; message: $str\n";
    };
  }
  public function send()
  {
    $r = parent::send();
    return $r;
  }
}
