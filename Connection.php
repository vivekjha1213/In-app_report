<?php
  
if(!isset($_COOKIE['report_token']))
{
  $token=$_GET['report_token'];
  if($token=="")
  {
    header('location:http://beyondhealth.info/Report/');
  }
  else
  {
    setcookie('report_token', $token, time() + (86400 * 30), "/");
  } 

}
  $mysqli = new mysqli("63.142.255.67","parveen","digifish","mobileca_cafe4u");
  if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
  }
// else
// {
//  echo "database connected Successfully";
// }
?>
