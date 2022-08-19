
<?php
/*

    php sessions are stored on the server side in temporary files
    session variable is a temporary variable

    we store user information in a session variable
    we destroy the session when user logout

    $_SESSION allow us to get data from another piece of code, even without including that piece of code by a require statement.

    set a super global variable - $_SESSION['user'] = "Caroline", SESSON[key]=>value)
    destroy - unset($_SESSION['user'])
    on every page we want to use it, we need to have - session_start()
        we include it in the helper so that it works throughout the app

    */

session_start();

/*

  flash message helper
  flash(key/name of the message, message content, optional class: 'alert alert-danger')
  SESSON[key] => message content

  Usage:

  In login view -  <?php flash('register_success'); ?>
  it will echo the message only if $_SESSION['register_success'] is not empty

  In User.register(), if user successrully registered, before redirecting, we set $_SESSION['register_success']='xxx' by flash('register_success', 'You are now registered and welcome to log in'). The corresponding result of this is: in login view -  <?php flash('register_success'); ?>, we display the message content, which is $_SESSION['register_success']
  
  */
function flash($name = '', $message = '', $class = 'alert alert-success')
{
  if (!empty($name)) { // exclude the case when flash() is called without parameter

    // 1. if the function has 2 parameters, we got the name(key) and the message, we are going to overwrite SESSON[myKey]=myMessage
    if (!empty($message) && empty($_SESSION[$name])) {
      // destroy, if it's already set
      if (!empty($_SESSION[$name])) {
        unset($_SESSION[$name]);
      }

      if (!empty($_SESSION[$name . '_class'])) {
        unset($_SESSION[$name . '_class']);
      }

      // eg. flash('register_success', 'You are now registered', 'alert alert-danger');
      // $_SESSION['register_success'] = 'You are now registered';
      // $_SESSION['register_success_class'] = 'alert alert-danger';
      // $_SESSION[message_name]=message_content, $_SESSION[message_class]=css class of message

      $_SESSION[$name] = $message;
      $_SESSION[$name . '_class'] = $class;
    }

    // 2. if we have a name(key), and we are not providing a new message
    elseif (empty($message) && !empty($_SESSION[$name])) {
      $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
      // display the key's corresponding class and message
      echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
      // destroy, prevent the message from being display more then once
      unset($_SESSION[$name]);
      unset($_SESSION[$name . '_class']);
    }
  }
}


// see if session exists ~ if user logged in
function isLoggedIn()
{
  return isset($_SESSION['user_id']);
}
