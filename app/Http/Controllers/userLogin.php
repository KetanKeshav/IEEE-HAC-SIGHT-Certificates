<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class userLogin extends Controller
{
  /**
   * Requested Changes - view Page
   * @author Tittu Varghese (tittu@servntire.com)
   *
   * @param  Request | $request
   * @return redirect | authentication
   * @return view | dashboard
   */

  protected function authentication(Request $request)
  {
    $user = new User;
    $user->email = $request->get('email');
    $user->password = $request->get('password');

    /* Validation Rules */
    $ValidationRules = [
      'email' => 'required|email|exists:mysql.users,email',
      'password' => 'required|min:8'
    ];
    /* Error Messages */
    $ErrorMessages = [
      'email.exists' => 'The account is not exist in our system',
      'password.min' => 'Please enter a valid password.'
    ];

    /* Validation */
    $this->validate($request, $ValidationRules, $ErrorMessages);

    $userCredentials['email'] = $user->email;
    $userCredentials['password'] = $user->password;

    /* Making Authentication Request */
    if (Auth::attempt($userCredentials)) {
      /* If Auth true */
      return redirect('dashboard');
    } else {

      /* If Auth false */
      return redirect("login")->with('error', 'Invalid email address or password.');
    }
  }

  /**
   * User Logout Function
   * @author Tittu Varghese (tittu@servntire.com)
   * @return redirect | login | dashboard
   */

  protected function logout()
  {
    Auth::logout();
    return redirect('login');
  }
}
