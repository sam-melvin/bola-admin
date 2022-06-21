<?php
// Start the session
session_start();
if(isset($_SESSION["uid"])){ 
  header("Location:home.php");
  exit();
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Simple login form</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <style>
      html, body {
      display: flex;
      justify-content: center;
      font-family: Roboto, Arial, sans-serif;
      font-size: 15px;
      }
      form {
      border: 5px solid #f1f1f1;
      }
      input[type=text], input[type=password] {
      width: 100%;
      padding: 16px 8px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
      }
      button {
      background-color: #8ebf42;
      color: white;
      padding: 14px 0;
      margin: 10px 0;
      border: none;
      cursor: grabbing;
      width: 100%;
      }
      h1 {
      text-align:center;
      fone-size:18;
      }
      button:hover {
      opacity: 0.8;
      }
      .formcontainer {
      text-align: left;
      margin: 24px 50px 12px;
      }
      .container {
      padding: 16px 0;
      text-align:left;
      }
      span.psw {
      float: right;
      padding-top: 0;
      padding-right: 15px;
      }
      /* Change styles for span on extra small screens */
      @media screen and (max-width: 300px) {
      span.psw {
      display: block;
      float: none;
      }
    </style>

  </head>
  <body>
    <form id="signinAdmin" method="post" name="signinAdmin">
      <h1>Manager Page Login</h1>
      <div class="formcontainer">
      <hr/>
      <div class="container">
        <label for="uname"><strong>ID Code:</strong></label>
        <input type="text" placeholder="Enter id code" name="id_code" id="id_code" required>
        <label for="uname"><strong>Password:</strong></label>
        <input type="password" placeholder="Enter Password" name="man_pass" id="man_pass"  required>
      </div>
      <button type="button" id="btnSigninAdmin">Login</button>
      
    </form>
  </body>
</html>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script>
$(function() {

    $('#btnSigninAdmin').on('click', function() {
        console.log("pasok");
        var id_code = $('#id_code').val();
        var man_pass = $('#man_pass').val();
        var weHaveSuccess = false;
        var emptFields = false;

        if(id_code == "" || man_pass == "")
            emptFields = true;

          $.ajax({
              type: "POST",
              url: "signin.php",
              dataType:"text",
              data: {
                  id_code: id_code,
                  man_pass: man_pass
              },
              cache: false,
              success: function(dataResult){
                      console.log("dataResult:" + dataResult);
                      if(dataResult === "success")
                      {
                          weHaveSuccess = true;
                          location.replace("home.php");
                      }
                      else {
                          weHaveSuccess = false;
                      }
                      console.log(dataResult);
                      
              },
              error: function(xhr, status, error){
                  alert("Error!" + xhr.status);
              },
              complete: function(){
                  if(!weHaveSuccess){
                      $('#signinAdmin').find('input:password').val('');
                      alert("Error! Invalid Id Code/password.");
                  }

                  if(emptFields){
                      alert("Error! Some fields are empty.");
                  }
              },
          });
      }); 
      
       
  });
</script>