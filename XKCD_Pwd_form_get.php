<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>PHP Basic: XKCD style password</title>
	<script  src="XKCD_Pwd_logic.js"></script>
	<?php require('XKCD_Pwd_logic.php'); ?>
	<link href="P2CSS.css" rel="stylesheet" type="text/css">
</head>
<body>
	<form name="mainForm" id="mainForm" method="get" action=<?php echo $_SERVER['PHP_SELF'];?>>
		<div id="Header"><h1>xkcd Password Generator</h1></div>
		<div id="Container"> 
			<div id="Container2">
				<div id="columnSpace">&nbsp;</div>
				<div id="main">
				<br />
				<h2>Password Created:<br /> <textarea name="Password" id="Password" rows="4" cols="50" style="resize: none;" disabled><?php echo $strPassword;?> </textarea><br /></h2>
					<div id="footnote">
						Press Submit below to generate new password!
					</div>
				<hr>
				<h3>Available Options :</h3>
					# of Words: 
						<input type="text" onKeyUp="numericFilter(this); checkNumberOfWords();" name="NumberOfWords" id="NumberOfWords" maxlength="2" /> (0-10 Words)
						<script type="text/javascript"> document.getElementById('NumberOfWords').value = "<?php echo $NumberOfWords;?>"; </script>
						<br /> 
					# of Special Symbol:
						<input type="text" onKeyUp="numericFilter(this);"  name="NumberOfSymbol"  maxlength="3"   id="NumberOfSymbol" />
						<script type="text/javascript">document.getElementById('NumberOfSymbol').value = "<?php echo $NumberOfSymbol;?>";</script>
						<br />
					Case:
						<select id="PasswordCase" name="PasswordCase">
							<option value="1"  <?php echo (($PasswordCase==1) ? "selected" : "") ?> >First letter of each word upper case</option>
							<option value="2"  <?php echo (($PasswordCase==2) ? "selected" : "") ?> >All lower case</option>
							<option value="3"  <?php echo (($PasswordCase==3) ? "selected" : "" )?> >All upper case</option>
						</select>
						<script type="text/javascript">document.getElementById('PasswordCase').value = "<?php echo $PasswordCase;?>";</script>
						<br />
					Include a number: <input type="checkbox" name="IncludeNumber" id="IncludeNumber" value="1" <?php echo CheckBoxValue($IncludeNumber);  ?> ><br />
					Separator: <input name="Separator" id="Separator" type="text" style="width: 10px;" onKeyDown="limitText(this.form.limitedtextfield,this.form.countdown,1);" 
								onKeyUp="limitText(this.form.limitedtextfield,this.form.countdown,1);" maxlength="1"  ><br />
								<script type="text/javascript">document.getElementById('Separator').value = "<?php echo $Separator;?>";</script><br />
					<div id="options">
						<input id="submit" name="submit" type="submit" value="Submit" > <button  type="button" onclick="clearForm();return false;">Reset</button>
					</div><br /><hr>
					<p>This comic is saying that the password in the top frames "Tr0ub4dor&3" is easier for password cracking software to guess because it has less entropy than "correcthorsebatterystaple" and also more difficult for a human to remember, leading to insecure practices like writing the password down on a post-it attached to the monitor.</p>
					<p><img id="Pic" src="password_strength.png" /> </p>
					<hr>
					<div id="logs"  >
					Optional Application Log:<br />
					<textarea name="log" id="log" rows="10" cols="100" style="resize: none;" disabled><?php echo $log;?> </textarea><br />
					</div>
			</div>
			<div id="columnSpace">&nbsp;</div>
			<div id="Footer" >Copyright &copy; www.SimonLeeToronto.me 2014</div>
		</div>
	</div>	
	</form>
</body>
</html>