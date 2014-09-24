<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>PHP Basic: xkcd style password</title>
  <script type="text/javascript" >
	function limitText(limitField, limitCount, limitNum) {
		if (limitField.value.length > limitNum) {
			limitField.value = limitField.value.substring(0, limitNum);
		} else {
			limitCount.value = limitNum - limitField.value.length;
		}
	}
	function numericFilter(txb) {
		txb.value = txb.value.replace(/[^\0-9]/ig, "");
	}
	function clearForm(){
		document.forms["mainForm"].reset();
		document.getElementById("NumberOfWords").value = "0";
		document.getElementById("NumberOfSymbol").value ="0";
	}
	</script>
</head>
<body>
<form name="mainForm" id="mainForm" method="post" action=<?php echo $_SERVER['PHP_SELF'];?>>
  <h1><span style="font-weight: bold;">xkcd Password Generator</span></h1>
  <p>This comic is saying that the password in the top frames "Tr0ub4dor&3" is easier for password cracking software to guess because it has less entropy than "correcthorsebatterystaple" and also more difficult for a human to remember, leading to insecure practices like writing the password down on a post-it attached to the monitor.</p>
<?php  
$log = date('Y-m-d H:i:s') . "... Application Starts. <br />";
$IncludeNumber = 0;
$IncludeNumber =  isset($_POST['IncludeNumber']) && $_POST['IncludeNumber']  ? "1" : "0";
$NumberOfSymbol= (int) (isset($_POST['NumberOfSymbol'])  ?  $_POST['NumberOfSymbol'] : "0");
$NumberOfWords= (int) (isset($_POST['NumberOfWords'])   ?  $_POST['NumberOfWords'] : "0") ;
$PasswordCase = isset($_POST['PasswordCase']) ? $_POST['PasswordCase'] : "1" ;
$log =  $log . date('Y-m-d H:i:s') . '... Include Num: ' .$IncludeNumber . ' Password Case: ' . $PasswordCase . ' # of words: '. $NumberOfWords . ' # of symbol: ' . $NumberOfSymbol. ' . <br>';
$Password = array();
$Separator = !isset($_POST['Separator']) || $_POST['Separator']== '' ? " " : $_POST['Separator']  ;
$PositionToInsertNumber = rand(0, 15);
$strPassword ="";
for ($i = 0; $i < $NumberOfWords; $i++) {
	
	$log =  $log . date('Y-m-d H:i:s') . "... Fetching Password Array index $i <br />";
	$thisString = @file_get_contents("http://randomword.setgetgo.com/get.php");
	if ($thisString === FALSE) {
		$thisString = getLocalRandomWord();
		$log =  $log . date('Y-m-d H:i:s') . "... Unable to connect to default web API.<br />";
	}
	if ($i > 0 ){
		if ($Password[$i-1] == $thisString) { 
			$log =  $log . date('Y-m-d H:i:s') . "... Retrieving word from local library.<br />";
			$thisString = getLocalRandomWord();
		}
	}
	$Password[$i] = trim($thisString);
	$strPassword = $strPassword . $Password[$i].   $Separator   ;
}

$log = $log . date('Y-m-d H:i:s') . "... Result: $strPassword <br />";
$log = $log . date('Y-m-d H:i:s') . "... Application ended. <br />";

function getLocalSpecialChar(){
	$_localCharArray = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", ",", ".", "?", ";", ":", "|", "-", "=", "+","_");
	return $_localCharArray[array_rand($_localCharArray)];
}
function getLocalRandomWord(){
	$_localWordArray = array("food", "computer", "programming", "pearl", "glasses", "suppress", "mouse", "chocolate", "random", "words");
	return $_localWordArray[array_rand($_localWordArray)];
}
function CheckBoxValue($_IncludeNumber) {
  if ($_IncludeNumber == 1) {
  return "checked"; } else
  { return ''; }
}
//http://www.programmableweb.com/api/setgetgo-random-word
//http://codingforums.com/php/213384-random-word-generator.html
//http://stackoverflow.com/questions/3689645/random-word-selection
//http://randomword.setgetgo.com/

?>
Number of Words: <input type="text" onKeyUp="numericFilter(this);" name="NumberOfWords" id="NumberOfWords" /><br>
<script type="text/javascript">
  document.getElementById('NumberOfWords').value = "<?php echo $NumberOfWords;?>";
</script>
<br>
Include a number: <input type="checkbox" name="IncludeNumber" id="name="IncludeNumber" value="1" <?php echo CheckBoxValue($IncludeNumber);  ?> ><br>

  <br>
Number of Special Symbol: <input type="text" onKeyUp="numericFilter(this);"  name="NumberOfSymbol"   id="NumberOfSymbol" /><br>
<script type="text/javascript">
  document.getElementById('NumberOfSymbol').value = "<?php echo $NumberOfSymbol;?>";
</script>
Separator: <input name="Separator" id="Separator" type="text" onKeyDown="limitText(this.form.limitedtextfield,this.form.countdown,1);" 
onKeyUp="limitText(this.form.limitedtextfield,this.form.countdown,1);" maxlength="1"  > (required and default to single space)<br />
<script type="text/javascript">
  document.getElementById('Separator').value = "<?php echo $Separator;?>";
</script>
Case of Password:<select id="PasswordCase" name="PasswordCase">
  <option value="1"  <?php echo (($PasswordCase==1) ? "selected" : "") ?> > First letter of each word upper case</option>
  <option value="2"  <?php echo (($PasswordCase==2) ? "selected" : "") ?> >All lower case</option>
  <option value="3"  <?php echo (($PasswordCase==3) ? "selected" : "" )?> >All upper case</option>
</select>
<script type="text/javascript">
  document.getElementById('PasswordCase').value = "<?php echo $PasswordCase;?>";
</script>
  <br>
  <input name="submit" type="submit"><button onclick="clearForm()">Reset</button></br>
  Log:</br>
<?php echo $log;?>

</form>
</body>
</html>