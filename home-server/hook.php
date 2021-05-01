 <?php

if (isset($_POST['password'])) {
 $password = $_POST['password'];
 if ($password == "testtest"){
  $command = escapeshellcmd('python serial-2.py');
  $output = shell_exec($command);
  echo "1";
 }
 else
	 echo "2";
}
else
	echo "3";
 ?>