
	//this function limits the length of text enters in text box
	function limitText(limitField, limitCount, limitNum) {
		if (limitField.value.length > limitNum) {
			limitField.value = limitField.value.substring(0, limitNum);
		} else {
			limitCount.value = limitNum - limitField.value.length;
		}
	}
	//this function ensures the text entered is numeric
	function numericFilter(txb) {
		txb.value = txb.value.replace(/[^\0-9]/ig, "");
	}
	//this function ensure the number of words field is less than 10 else the submit button will be disabled
	function checkNumberOfWords (){
		var fieldVal = document.getElementById('NumberOfWords').value;
		if(fieldVal <= 10){
			document.getElementById('submit').disabled = false;
		}
		else
		{
			document.getElementById('submit').disabled = true;
		}
	}
	//this function clears the form and set default values. 
	function clearForm(){
		document.forms["mainForm"].reset();
		document.getElementById("NumberOfWords").value = "1";
		document.getElementById("NumberOfSymbol").value ="0";
		document.getElementById("Separator").value ="-";
		document.getElementById("log").value =" ";
		document.getElementById("Password").value =" ";
	}
