<?php
 //create MDS constants
 define("MONASH_DIR", "ldap.monash.edu.au");
 define("MONASH_FILTER","o=Monash University, c=au");
 session_start(); 
 ob_start();
?>

<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <title>Sign-In</title>
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #eee;
      }
      .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin .checkbox {
        font-weight: normal;
      }
      .form-signin .form-control {
        position: relative;
        height: auto;
        -webkit-box-sizing: border-box;
           -moz-box-sizing: border-box;
                box-sizing: border-box;
        padding: 10px;
        font-size: 16px;
      }
      .form-signin .form-control:focus {
        z-index: 2;
      }
      .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
      }
      .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
      }
    </style>
  </head>

  <body>

  <?php
   $form = '';
   if (empty($_POST["uname"]))
   {
    $form = "<form class='form-signin' method='post' action='login.php'>";

    if (empty($_SESSION['error']) || !isset($_SESSION['error'])) {
      //donothing
    } else {
      echo "<center style='color: red;'><h1>".$_SESSION['error']."<h1></center>";
    }
    if (empty($_GET["next"])) {
      //do nothing
    } else {
      $form = "<form class='form-signin' method='post' action='login.php?next=" .$_GET["next"]."'>";
    }
    ?>
    <div class="container">
      <?php echo $form ?>
        <h2 class="form-signin-heading">Please sign in with your Authcate account</h2>
        <label for="inputEmail" class="sr-only">Authcate ID</label>
        <input type="text" name="uname" id="inputEmail" class="form-control" placeholder="Authcate id" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="pword" id="inputPassword" class="form-control" placeholder="Password" required="">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    </div>
    <?php
     }
     else
     {
       $LDAPconn=@ldap_connect(MONASH_DIR);
       if($LDAPconn)
       {
         $LDAPsearch=@ldap_search($LDAPconn,MONASH_FILTER,
         "uid=".$_POST["uname"]);
         if($LDAPsearch)
         {
           $LDAPinfo = @ldap_first_entry($LDAPconn,$LDAPsearch);
           if($LDAPinfo)
           {
             $LDAPresult= @ldap_bind($LDAPconn, ldap_get_dn($LDAPconn, $LDAPinfo),
             $_POST["pword"]);
             $_SESSION['error'] = null;
           }
          else
          {
            $_SESSION['error'] = "Username or Password is invalid";
            $LDAPresult=0;
          }
         } 
         else
         {
          $_SESSION['error'] = "Unable to connect to Monash auth service";
          $LDAPresult=0;
         }
       }
       else
       {
        $_SESSION['error'] = "Unable to connect to Monash auth service";
        $LDAPresult=0;
       }

      $action = '';
      if(!empty($_GET["next"])) {
        $action = '?next='.$_GET["next"];
      }

       if($LDAPresult)
       {
        $_SESSION['auth'] = TRUE;
        header("location: index.php".$action);

       }
       else
       {
        $_SESSION['auth'] = FALSE; //probably dont need this
        header("location: login.php".$action);
       }
     }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>

</html>