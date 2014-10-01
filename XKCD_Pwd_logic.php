<?php  
	//main body v2.0
	$log = ""; //log valuable used to capture local application log 
	$log =  writeLog("Application Starts.");  
	
	//number of words required; default is 0 - 10; 0 is also allowed for symbol only password
	$NumberOfWords= (int) (isset($_POST['NumberOfWords'])   ?  $_POST['NumberOfWords'] : "1") ;	
	
	//Did user selected included number.  If not, default to 0 = unchecked
	$IncludeNumber =  isset($_POST['IncludeNumber']) && $_POST['IncludeNumber']  ? "1" : "0";
	$IsNumberAdded = False;  //flag to track if number is added to password 
	$PositionToInsertNumber = rand(0, $NumberOfWords-1);  // random number to insert the number in the password 
	
	//Did user entered number of symbol wanted? default is 0
	$NumberOfSymbol= (int) (isset($_POST['NumberOfSymbol'])  ?  $_POST['NumberOfSymbol'] : "0");
	$NumberOfSymbolAdded = 0;   //numeric value to keep track of how many symbol is added 
	
	//item delimiter / separator is a single character defined by user.  HTML forced user to use single char
	$Separator = !isset($_POST['Separator']) || $_POST['Separator']== '' ? "-" : $_POST['Separator']  ;
	
	//valuable to handle the format of password, default is First Char Upper
	$PasswordCase = isset($_POST['PasswordCase']) ? $_POST['PasswordCase'] : "1" ;
	
	//Password array is used to keep track of the random words in the password.  Also used to check for duplication to ensure 
	//words in the password is unique
	$Password = array();
	
	//Write log to summarize what was captured from HTML POST
	$log =  $log . writeLog("Include Num: $IncludeNumber Password Case:  $PasswordCase  # of words:  $NumberOfWords  # of symbol:  $NumberOfSymbol ");
	$log =  $log . writeLog("If include number is 1, it will be added in position  $PositionToInsertNumber  .");
	
	//Valuable to keep to final result return to HTML client side 
	$strPassword ="";

	for ($i = 0; $i < $NumberOfWords; $i++) {
		$log =  $log . writeLog("Fetching Password Array index $i"); 
		$thisString = getWord($Password, $log); //fetching for random word 
		switch ($PasswordCase) {
			case 1:
				$thisString = ucfirst($thisString);
				break;
			case 2:
				$thisString = strtolower($thisString);
				break;
			case 3:
				$thisString = strtoupper($thisString);
				break;
		} //end case
		$Password[$i] = $thisString; //saving return string in password array to ensure every word in the password is unique
		$strPassword = $strPassword . $thisString; ;
		
		//Add a symbol to the current position of the password.  
		if ($NumberOfSymbol > 0 && $NumberOfSymbol > $NumberOfSymbolAdded) 
		{
			$strPassword = $strPassword . $Separator. getLocalSpecialChar($log);  //add special character to the password
			$NumberOfSymbolAdded++;
		}//end if
		
		//Check if current position is selected random position to enter the number.
		if ($IsNumberAdded == False and $IncludeNumber ==1 and $PositionToInsertNumber == $i) {
			$IsNumberAdded = addNumberToPassword( $strPassword, $log);  //add number to the password 
		}//end if 
		
		//ensure the separator is not added to the end of the password. 
		if ($i <> $NumberOfWords-1){
			$strPassword = $strPassword .$Separator;
		}//end if 
	}//end for 
	//add symbol when number of symbol is greater than the number of word
	if ($NumberOfSymbol > $NumberOfSymbolAdded ){
		for  ($j = 0; $j < ($NumberOfSymbol-$NumberOfSymbolAdded); $j++) {
			$strPassword = $strPassword . getLocalSpecialChar($log);
		}//end for 
	}//end if 
	//add number to the password if number of words = 0
	if ($IsNumberAdded == False and $IncludeNumber ==1){ 
		$IsNumberAdded = addNumberToPassword( $strPassword, $log);
	}
	$log = $log . writeLog("Result: $strPassword");
	$log = $log . writeLog("Application ended.");
	//end of main

	//this function adds a number to the password.  Password and the log is passed into the function as reference. 
	//function return boolean 
	function addNumberToPassword (&$strPassword, &$log)
	{
		$Number = rand(0, 9);
		$log =  $log . writeLog("Add number to the password:  $Number  ");
		$strPassword = $strPassword .$Number  ;
		return True;
	}
	
	//recursive function that call third party web api to get random word. 
	//if API is not accessable, the function will call getLocalRandomWord 
	//this function also check if word is unique by using foreach loop to check the current array. 
	function getWord ($PasswordArray, &$log) 
	{
		$log =  $log . writeLog("Enter fetch word function...");
		$_localString = "";
		
		if (count($PasswordArray) % 2 == 1) {
			$log =  $log . writeLog("getting word from online api...");
			$_localString = trim(@file_get_contents("http://randomword.setgetgo.com/get.php"));
			if ($_localString === FALSE) {
				$_localString = getLocalRandomWord();
				$log =  $log . writeLog("Unable to connect to default web API; get word from local library");
			}
		} else { 
			$log =  $log . writeLog("fetch word from local library");
			$_localString = getLocalRandomWord();
		}
		//the following logic is for me to practice array, reference as parameter, and recursive function call. 
		// the number of word in the password is limited to 10 because I have a small array of words built in this application 
		// 10 words only in local function getLocalRandomWord() if user requested 11 words and they the application API is off-line 
		//will cause infinite loop
		if (isset($PasswordArray) && (sizeof($PasswordArray) > 1))
		{
			foreach ($PasswordArray as $word) {
				if (strtoupper($_localString) == strtoupper($word)) {
					$log =  $log . writeLog("word duplicated: $word");
					$_localString = getWord($PasswordArray, $log);
				}//end if 
			}//end for each
		}//end if 
		$log =  $log . writeLog("exit getWord function returning unique word: $_localString (recursive function call) ");
		return $_localString;
	}// end getWord

	//Write log valuable 
	function writeLog ($msg) {
		$_log = date('Y-m-d H:i:s') . "... " . $msg ." \n";
		return $_log;
	}//end writeLog
 
	//Get special character from predefined local array 
	function getLocalSpecialChar(&$log){
		$_localCharArray = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", ",", ".", "?", ";", ":", "|", "-", "=", "+","_");
		$_localChar = $_localCharArray[array_rand($_localCharArray)];
		$log =  $log . writeLog("Add symbol to  password:  $_localChar  ");
		return $_localChar;
	}//end getLocalSpecialChar
	//Get a word from local predefined local array word list
	function getLocalRandomWord(){
		$_localWordArray = array("food", "computer", "programming", "pearl", "glasses", "suppress", "mouse", "chocolate", "random", "words");
		return $_localWordArray[array_rand($_localWordArray)];
	}//end getLocalRandomWord
	
	//translate numeric IncludeNumber int into HTML terms "checked" 
	function CheckBoxValue($_IncludeNumber) {
		if ($_IncludeNumber == 1) {
			return "checked"; 
		} else { return ''; } //end if
	}//end CheckBoxValue
