<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>PHP Basic: xkcd style password</title>
  <script >
	function numericFilter(txb) {
		txb.value = txb.value.replace(/[^\0-9]/ig, "");
	}
	</script>
</head>
<body>
<form name="mainForm" method="post" action=<?php echo $_SERVER['PHP_SELF'];?>>
  <h1><span style="font-weight: bold;">Sample Form</span></h1>
<?php  
$IncludeNumber = 0;
$IncludeNumber = isset($_POST['IncludeNumber']) && $_POST['IncludeNumber']  ? "1" : "0";
echo $IncludeNumber . $_POST['PasswordCase'] . '. # of words '. $_POST['NumberOfWords'] . '. # of symbol ' . $_POST['NumberOfSymbol']. ' . <br>';

function CheckBoxValue($IncludeNumber) {
  if ($IncludeNumber == 1) {
  return "checked"; } else
  { return ''; }
}
?>
Number of Words: <input type="text" onKeyUp="numericFilter(this);" name="NumberOfWords" id="NumberOfWords" /><br>
<script type="text/javascript">
  document.getElementById('NumberOfWords').value = "<?php echo $_POST['NumberOfWords'];?>";
</script>
<br>
Include a number: <input type="checkbox" name="IncludeNumber" id="name="IncludeNumber" value="1" <?php echo CheckBoxValue($IncludeNumber);  ?> ><br>

  <br>
Number of Special Symbol: <input type="text" onKeyUp="numericFilter(this);" name="NumberOfSymbol"   id="NumberOfSymbol" /><br>
<script type="text/javascript">
  document.getElementById('NumberOfSymbol').value = "<?php echo $_POST['NumberOfSymbol'];?>";
</script>
  <br>
Case of Password:<select id="PasswordCase" name="PasswordCase">
  <option value="FirstUpper">First letter of each word upper case</option>
  <option value="AllLower">All lower case</option>
  <option value="AllUpper">All upper case</option>
</select>
<script type="text/javascript">
  document.getElementById('PasswordCase').value = "<?php echo $_POST['PasswordCase'];?>";
</script>
  <br>
  <input name="submit" type="submit"><input name="reset" type="reset"><br>
</form>
</body>
</html>