<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/project/admin/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])) {
    die();
}

//Prevent the user visiting the logged in page if he/she is already logged in
if (isUserLoggedIn()) {
    session_write_close();
    header("Location:account.php");
    die();
}
$uname = "";
if (!empty($_GET)) {
    $uname = $_GET['uname'];
}
//Forms posted
if (!empty($_POST)) {
    $errors = array();
    $username = removeXSS(sanitize(trim($_POST["username"])));
    $password = removeXSS(trim($_POST["password"]));

    if (!empty($username)) {
        $uname = $username;
    }

    //Perform some validation
    //Feel free to edit / change as required
    if ($username == "") {
        $errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
    }
    if ($password == "") {
        $errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
    }

    if (count($errors) == 0) {
        if (candidateExists($username)) {
            $userdetails = fetchCandDetails($username, $password);

            if (!isset($userdetails["candidateid"])) {
                $errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
            } else {
                $loggedInUser = new loggedInUser();
                $loggedInUser->email = $userdetails["email"];
                $loggedInUser->user_id = $userdetails["id"];
                $loggedInUser->displayname = $userdetails["name"];
                $loggedInUser->username = $userdetails["uname"];
                $loggedInUser->candidate = "Y";
                $loggedInUser->employee = "N";
                $loggedInUser->employeeid = 0;
                $loggedInUser->status = $userdetails["status"];
                $loggedInUser->candidateid = $userdetails["candidateid"];
                $_SESSION["userCakeUser"] = serialize($loggedInUser);
                session_write_close();
                header("Location:account.php");
                exit;
            }
        }

        if (employeeExists($username)) {
            $userdetails = fetchEmployeeDetails($username);
            $entered_pass = generateHash($password, $userdetails["password"]);
            if (!isset($userdetails["empid"])) {
                $errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
            } elseif ($entered_pass != $userdetails["password"]) {
                $errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
            } else {
                $loggedInUser = new loggedInUser();
                $loggedInUser->email = $userdetails["email"];
                $loggedInUser->user_id = $userdetails["id"];
                $loggedInUser->displayname = $userdetails["display_name"];
                $loggedInUser->username = $userdetails["user_name"];
                $loggedInUser->candidate = "N";
                $loggedInUser->employee = "Y";
                $loggedInUser->candidateid = 0;
                $loggedInUser->employeeid = $userdetails["empid"];
                $loggedInUser->managerid = $userdetails["mgrid"];
                $loggedInUser->hash_pw = $userdetails["password"];
                $loggedInUser->permissionid = $userdetails["permissionid"];
                $loggedInUser->permissionname = $userdetails["permissionname"];
                $loggedInUser->updateLastSignIn();
                $_SESSION["userCakeUser"] = serialize($loggedInUser);
                session_write_close();
                header("Location:account.php");
                exit;
            }
        }
        //A security note here, never tell the user which credential was incorrect
        if (!usernameExists($username)) {
            $errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");

        } else {
            $userdetails = fetchUserDetails($username);
            //See if the user's account is activated
            if ($userdetails["active"] == 0) {
                $errors[] = lang("ACCOUNT_INACTIVE");
            } else {
                //Hash the password and use the salt from the database to compare the password.
                $entered_pass = generateHash($password, $userdetails["password"]);

                if ($entered_pass != $userdetails["password"]) {
                    //Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
                    $errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
                } else {
                    //Passwords match! we're good to go'

                    //Construct a new logged in user object
                    //Transfer some db data to the session object
                    /*$loggedInUser = new loggedInUser();
                    $loggedInUser->email = $userdetails["email"];
                    $loggedInUser->user_id = $userdetails["id"];
                    $loggedInUser->hash_pw = $userdetails["password"];
                    $loggedInUser->title = $userdetails["title"];
                    $loggedInUser->displayname = $userdetails["display_name"];
                    $loggedInUser->username = $userdetails["user_name"];

                    //Update last sign in
                    $loggedInUser->updateLastSignIn();
                    $_SESSION["userCakeUser"] = $loggedInUser;*/

                    //Redirect to user account page
                    session_write_close();
                    //header("Location: login.php");
                    header("Location : login.php");
                    die();
                }
            }
        }
    }
}
$page_title = $websiteName;
require_once("models/header.php");

echo "
<body>
<div id='wrapper'>
<div id='top'><div id='logo'></div><div id='logo1'></div></div>
<div id='content'>
<div id='left-nav'>
<ul id='mymenu'>
	<nav class='nav nav-pills nav-stacked'></nav>
	<div class='nav nav-pills nav-stacked'></div>
	<li class ='active'><a href='$root/index.php'>Home</a></li>
	<li class ='active'><a href='$root/login.php'>Login</a></li>
	<li class='active'><a href='$root/register.php'>Register</a></li>";

echo "
</div>
<div id='main'>";

echo resultBlock($errors, $successes);

echo "
<div id='regbox'>
<form name='login' action='" . $_SERVER['PHP_SELF'] . "' method='post' class='ui-widget'>
<p>

<input type='text' name='username' value='$uname' class='ui-corner-all inputs' placeholder='Enter Username '/>
</p>
<p>
<input type='password' name='password' class='ui-corner-all inputs' placeholder='Password'/>
</p>
<p>
<label>&nbsp;</label>
<input type='submit' value='Login' class='ui-corner-all ui-button' />
</p>
</form>
</div>
</div>

</div>
</div> 


</body>
</html>";

?>
