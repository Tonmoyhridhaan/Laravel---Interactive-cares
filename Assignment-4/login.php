<?php
require "vendor/autoload.php";
session_start();
$errors = [];
$email = '';
$password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email'])) {
        $errors['email'] = 'Please provide an email address';
    } else {
        $email = sanitize($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please provide a valid email address';
        }
    }

    if (empty($_POST['password'])) {
        $errors['password'] = 'Please provide a password';
    } elseif (strlen($_POST['password']) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    } else {
        $password = sanitize($_POST['password']);
    }
    
    if (empty($errors)) {
        $file = fopen("db/customers.txt", "r");
        $is_authenticated = false;
        
        if ($file) {

            while (($line = fgets($file)) !== false) {
                list($name, $stored_email, $stored_password) = explode(", ", trim($line));
                
                $stored_email = str_replace("Email: ", "", $stored_email);
                $stored_password = str_replace("Password: ", "", $stored_password);

                if ($email == trim($stored_email) && password_verify($password, trim($stored_password))) {
                    $is_authenticated = true;
                    $_SESSION['email'] = $stored_email;
                    header('Location: customer/dashboard.php');
                    exit;
                }
            }
            fclose($file);
            if(!$is_authenticated) {
                $errors['auth_error'] = 'Invalid email or password';
            }
        }else{
            $errors['auth_error'] = 'An error occurred. Please try again';
        }
        
    }
    
}
?>
<!DOCTYPE html>
<html
  class="h-full bg-white"
  lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>

    <link
      rel="preconnect"
      href="https://fonts.googleapis.com" />
    <link
      rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
      rel="stylesheet" />

    <style>
      * {
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont,
          'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans',
          'Helvetica Neue', sans-serif;
      }
    </style>

    <title>Sign-In To Your Account</title>
  </head>
  <body class="h-full bg-slate-100">
    <div class="flex flex-col justify-center min-h-full py-12 sm:px-6 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2
          class="mt-6 text-2xl font-bold leading-9 tracking-tight text-center text-gray-900">
          Sign In To Your Account
        </h2>
      </div>
      
      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
      <?php
      $message = flash('success');
      if ($message) : ?>
          <div class="mt-2 bg-teal-100 border border-teal-200 text-sm text-teal-800 rounded-lg p-4" role="alert">
              <span class="font-bold"><?= $message; ?></span>
          </div>
      <?php endif; ?>

      <?php if (isset($errors['auth_error'])) : ?>
          <div class="mt-2 bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4" role="alert">
              <span class="font-bold"><?= $errors['auth_error']; ?></span>
          </div>
      <?php endif; ?>
        <div class="px-6 py-12 bg-white shadow sm:rounded-lg sm:px-12">
          <form
            class="space-y-6"
            action="login.php"
            method="POST">
            <div>
              <label
                for="email"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Email address</label
              >
              <div class="mt-2">
                <input
                  id="email"
                  name="email"
                  type="email"
                  autocomplete="email"
                  required
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 p-2 sm:text-sm sm:leading-6" />
              </div>
              <?php if (isset($errors['email'])) : ?>
                  <p class="text-xs text-red-600 mt-2" id="email-error"><?= $errors['email']; ?></p>
              <?php endif; ?>
            </div>

            <div>
              <label
                for="password"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Password</label
              >
              <div class="mt-2">
                <input
                  id="password"
                  name="password"
                  type="password"
                  autocomplete="current-password"
                  required
                  class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6" />
              </div>
              <?php if (isset($errors['password'])) : ?>
                  <p class="text-xs text-red-600 mt-2" id="email-error"><?= $errors['password']; ?></p>
              <?php endif; ?>
            </div>

            <div>
              <button
                type="submit"
                class="flex w-full justify-center rounded-md bg-emerald-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                Sign in
              </button>
            </div>
          </form>
        </div>

        <p class="mt-10 text-sm text-center text-gray-500">
          Don't have an account?
          <a
            href="./register.php"
            class="font-semibold leading-6 text-emerald-600 hover:text-emerald-500"
            >Register</a
          >
        </p>
      </div>
    </div>
  </body>
</html>
