<?php
class Users extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model("User");
  }

  public function register()
  {
    // case 1. receive a post request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // deal with the data we received

      // sanitize post data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $data = [
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),
        'status' => trim($_POST['status']),
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => '',
        'status_err' => ''
      ];

      // validate email
      if (empty($data['email'])) {
        $data['email_err'] = 'Pleae enter email';
      } else {
        // email entered, check if it's already registered
        if ($this->userModel->findUserByEmail($data['email'])) {
          $data['email_err'] = 'Email is already registered.';
        };
      }

      // validate name
      if (empty($data['name'])) {
        $data['name_err'] = 'Pleae enter name';
      }

      // validate Password
      if (empty($data['password'])) {
        $data['password_err'] = 'Pleae enter password';
      } elseif (strlen($data['password']) < 6) {
        $data['password_err'] = 'Password must be at least 6 characters';
      }

      // validate confirm password
      if (empty($data['confirm_password'])) {
        $data['confirm_password_err'] = 'Pleae confirm password';
      } else {
        if ($data['password'] != $data['confirm_password']) {
          $data['confirm_password_err'] = 'Passwords do not match';
        }
      }

      // validate status
      if (empty($data['status'])) {
        $data['status_err'] = 'Please select if you are an event organizer';
      }

      // make sure errors are empty
      if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['status_err'])) {
        // valid input, user is going to be registered
        // hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // register user, return T/F
        if ($this->userModel->register($data)) {
          // SESSON[register_success]=You are...
          flash('register_success', 'You are registered and can log in now.');
          // without helper function: header('location: ' . URLROOT . 'users/login');
          redirect('users/login');
        } else {
          die('Something went wrong');
        }
      } else {
        // load view with errors
        $this->view('users/register', $data);
      }
    }
    // case 2. receive a get request, init data
    else {
      $data = [
        'name' => '',
        'email' => '',
        'password' => '',
        'confirm_password' => '',
        'status' => '',
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => '',
        'status_err' => ''
      ];

      $this->view('users/register', $data);
    }
  }


  public function login()
  {
    // case 1. receive a post request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // sanitize post data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'name_err' => '',
        'email_err' => '',
      ];

      // validate email
      if (empty($data['email'])) {
        $data['email_err'] = 'Pleae enter email';
      }

      // validate Password
      if (empty($data['password'])) {
        $data['password_err'] = 'Pleae enter password';
      } elseif (strlen($data['password']) < 6) {
        $data['password_err'] = 'Password must be at least 6 characters';
      }

      // check for user/email
      if ($this->userModel->findUserByEmail($data['email'])) {
        // user found
      } else {
        // user not found
        $data['email_err'] = 'No user found';
      }

      // make sure errors are empty
      if (empty($data['email_err']) && empty($data['password_err'])) {
        // check and log in the user
        $loggedInUser = $this->userModel->login($data['email'], $data['password']);
        if ($loggedInUser) {
          // name-password match, create session
          $this->createUserSession($loggedInUser);
          redirect('');
        } else {
          // name-password not match
          $data['password_err'] = 'Password incorrect';
          $this->view('users/login', $data);
        }
      } else {
        // load view with errors
        $this->view('users/login', $data);
      }
    }
    // case 2. receive a get request, init data
    else {
      $data = [
        'email' => '',
        'password' => '',
        'email_err' => '',
        'password_err' => '',
      ];

      $this->view('users/login', $data);
    }
  }

  public function createUserSession($user)
  {
    // set session variable by user data
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_name'] = $user->name;
    $_SESSION['status'] = $user->status;
    redirect('events_dashboard');
  }

  // logout is all about destroying sessions
  public function logout()
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    unset($_SESSION['status']);
    session_destroy();
    redirect('users/login');
  }
}
