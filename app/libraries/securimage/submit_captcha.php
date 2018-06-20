<?php
  $_SESSION['ctform'] = array(); // re-initialize the form session data

  require_once dirname(__FILE__) . '/securimage.php';
  $securimage = new Securimage();

  $captcha = $_POST['ct_captcha'];
  echo $captcha.'<br />';
  var_dump($securimage->check($captcha));
  if ($securimage->check($captcha) == false) {
    $errors['captcha_error'] = 'Incorrect security code entered<br />';
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['do'] == 'contact') {
    // if the form has been submitted

    // foreach($_POST as $key => $value) {
    //   if (!is_array($key)) {
    //     // sanitize the input data
    //     if ($key != 'ct_message') $value = strip_tags($value);
    //     $_POST[$key] = htmlspecialchars(stripslashes(trim($value)));
    //   }
    // }

    $name    = @$_POST['ct_name'];    // name from the form
    $email   = @$_POST['ct_email'];   // email from the form
    $URL     = @$_POST['ct_URL'];     // url from the form
    $message = @$_POST['ct_message']; // the message from the form
    $captcha = $_POST['ct_captcha']; // the user's entry for the captcha code
    $name    = substr($name, 0, 64);  // limit name to 64 characters

    $errors = array();  // initialize empty error array

    if (isset($GLOBALS['DEBUG_MODE']) && $GLOBALS['DEBUG_MODE'] == false) {
      // only check for errors if the form is not in debug mode

      if (strlen($name) < 3) {
        // name too short, add error
        $errors['name_error'] = 'Your name is required';
      }

      if (strlen($email) == 0) {
        // no email address given
        $errors['email_error'] = 'Email address is required';
      } else if ( !preg_match('/^(?:[\w\d-]+\.?)+@(?:(?:[\w\d]\-?)+\.)+\w{2,63}$/i', $email)) {
        // invalid email format
        $errors['email_error'] = 'Email address entered is invalid';
      }

      if (strlen($message) < 20) {
        // message length too short
        $errors['message_error'] = 'Your message must be longer than 20 characters';
      }
    }

    // Only try to validate the captcha if the form has no errors
    // This is especially important for ajax calls
    if (sizeof($errors) == 0) {
      // require_once dirname(__FILE__) . '/securimage.php';
      // $securimage = new Securimage();

      // $captcha = '-';
      // echo $captcha.'<br />';
      // var_dump($securimage->check($captcha));
      // if ($securimage->check($captcha) == false) {
      //   $errors['captcha_error'] = 'Incorrect security code entered<br />';
      // }
    }

    if (sizeof($errors) == 0) {
      // no errors, send the form
      $time       = date('r');
      $message = "A message was submitted from the contact form.  The following information was provided.<br /><br />"
                    . "<em>Name: $name</em><br />"
                    . "<em>Email: $email</em><br />"
                    . "<em>URL: $URL</em><br />"
                    . "<em>Message:</em><br />"
                    . "<pre>$message</pre>"
                    . "<br /><br /><em>IP Address:</em> {$_SERVER['REMOTE_ADDR']}<br />"
                    . "<em>Time:</em> $time<br />"
                    . "<em>Browser:</em> " . htmlspecialchars($_SERVER['HTTP_USER_AGENT']) . "<br />";

      $message = wordwrap($message, 70);

      if (isset($GLOBALS['DEBUG_MODE']) && $GLOBALS['DEBUG_MODE'] == false) {
        // send the message with mail()
        mail($GLOBALS['ct_recipient'], $GLOBALS['ct_msg_subject'], $message, "From: {$GLOBALS['ct_recipient']}\r\nReply-To: {$email}\r\nContent-type: text/html; charset=UTF-8\r\nMIME-Version: 1.0");
      }

      $_SESSION['ctform']['timetosolve'] = $securimage->getTimeToSolve();
      $_SESSION['ctform']['error'] = false;  // no error with form
      $_SESSION['ctform']['success'] = true; // message sent
    } else {
      // save the entries, this is to re-populate the form
      $_SESSION['ctform']['ct_name'] = $name;       // save name from the form submission
      $_SESSION['ctform']['ct_email'] = $email;     // save email
      $_SESSION['ctform']['ct_URL'] = $URL;         // save URL
      $_SESSION['ctform']['ct_message'] = $message; // save message

      foreach($errors as $key => $error) {
        // set up error messages to display with each field
        $_SESSION['ctform'][$key] = "<span class=\"error\">$error</span>";
      }

      $_SESSION['ctform']['error'] = true; // set error floag
    }
  } // POST
?>