# PHP Basics

## Live URL
<http://p2.simonleetoronto.me>

## Description
The goal of this project is to gain hands-on practice with working with the basics of PHP.

XKCD_Pwd_form.php is the main form.  It is linked to Javascript file (client side logic), XKCD_Pwd_logic.js, 
and PHP file (Server side logic) XKCD_Pwd_logic.php.  CSS file, P2CSS.css, is used. 

## Demo
http://www.screencast.com/t/DTI4yPay

## Details for teaching team
This web page allows user to request for a password with 10 words or below. Optional separator, number and symbol
are available on the same web page.  If Include a Number is selected, a random single digit number will be inserted 
in a random position in the password.  

User can also select how many random symbol to be inserted into the password.  Symbols are randomly selected from 
local string array.  

Javascript is used to ensure the user enter numeric value in the numeric text boxes.  It is also applied to the # of Words
text box to restrict user to submit a number greater than 10.  It is done by disabling the submit button if user entry is 
greater than 10. 

I choose to use POST over GET in this project because I have used Javascript to restrict user's input.  Exposing the 
query string in the URL defeats the purpose of this feature. I understand that Susan said that this application is for user to 
"get" a password, unlike a login screen, we are not "posting" sensitive information.  However, I realize that exposing the 
query string allows user to submit string in the # of Words field, and error checking as such was not part of the requirement...
Anyway, I have submitted a "Get" version of the code in my GitHub in case it is required. 

v2.0 > version number that is ready for presentation. Sept 28/2014

## Outside code
Although XKCD_Pwd_logic.php has a string array that holds 10 words, the program will go to 
http://randomword.setgetgo.com/get.php to fetch for random word one at a time. 