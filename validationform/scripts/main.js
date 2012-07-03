//main.js - Form Validation

//global variables

var btnSubmit, btnReset, form;
var un, pass, pass2, email, atPosition, periodPosition, eLen, check, month, day, year, sQuestion, sAnswer, illegalNumbers, passReqs, illegalChars; 

window.onload = function()
{
	form = document.getElementById("form");
	un = document.getElementById("username");
	btnSubmit = document.getElementById("btnSubmit");
	btnReset = document.getElementById("btnReset");
	pass = document.getElementById("pass");
	pass2 = document.getElementById("pass2");
	email = document.getElementById("email");
	atPosition = email.value.indexOf("@");
	periodPosition = email.value.lastIndexOf(".");
	eLen = email.length;
	check = document.getElementById("check");
	month = document.getElementById("dobMonth");
	//alert( typeof month + " " + month);
	day = document.getElementById("dobDay");
	year = document.getElementById("dobYear");
	question = document.getElementById("sQuestion");
	answer = document.getElementById("sAnswer");
	illegalNumbers = /[\d]/;
	passReqs = /[\W\d]/;
	illegalChars = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
	
	form.onsubmit = validate;
	btnReset.onclick = clearForm;
	
	un.onfocus = highlight;
	un.onblur = unhighlight;
	pass.onfocus = highlight;
	pass.onblur = unhighlight;
	pass2.onfocus = highlight;
	pass2.onblur = unhighlight;
	email.onfocus = highlight;
	email.onblur = unhighlight;
	month.onfocus = highlight;
	month.onblur = unhighlight;
	day.onfocus = highlight;
	day.onblur = unhighlight;
	year.onfocus = highlight;
	year.onblur = unhighlight;
	answer.onfocus = highlight;
	answer.onblur = unhighlight;
	check.onfocus = highlight;
	check.onblur = unhighlight;
	
}


function validate()
{	
	var valid = true;
	clearOldErrorMessages();
/*********
username
***********/

	//remove the leading space on the username
	while(un.value.substr(0, 1) == ' '){
		un.value = un.value.substr(1);	//strip off the first character
	}

	//remove the trailing space on the username
	while(un.value.substr( un.value.length-1, 1) == ' '){
		un.value = un.value.substr(0, un.value.length-1);	//strip off the last character
	}
	
	if(illegalNumbers.test(un.value) ){
		addError("Sorry, you can't have any numbers in your username", un);	
		valid = false;
	}
		
	if(un.value.length < 5){
		addError('The username must be at least 5 characters long.', un);	
		valid = false;
	}
	
	
//password	
	
	
	//remove the leading space on the password
	while(pass.value.substr(0, 1) == ' '){
		pass.value = pass.value.substr(1);	//strip off the first character
	}

	//remove the trailing space on the password
	while(pass.value.substr( pass.value.length-1, 1) == ' '){
		pass.value = pass.value.substr(0, pass.value.length-1);	//strip off the last character
	}
	//illegalChars.test(pass.value)
	//check if the password is empty & has at least one number and letter and is between 8 and 20 chars long.
	if(pass.value.length < 8 || pass.value.length > 20 ){	
		addError('The password must be between 8 and 20 characters', pass);	
		valid = false;
	}9
	if( !(passReqs.test(pass.value))){
		addError('The password must have at least one number and letter', pass);
		valid = false;
	}
	
//re-type password
	while(pass2.value.substr(0, 1) == ' '){
		pass2.value = pass2.value.substr(1);	//strip off the first character
	}

	//remove the trailing space on the password
	while(pass2.value.substr( pass2.value.length-1, 1) == ' '){
		pass2.value = pass2.value.substr(0, pass2.value.length-1);	//strip off the last character
	}
	
	if(pass2.value != pass.value){
		addError('The passwords must match.', pass2);	
		valid = false;
	}
	
	
//e-mail address
	while(email.value.substr(0, 1) == ' '){
		email.value = email.value.substr(1);	//strip off the first character
	}

	//remove the trailing space on the password
	while(email.value.substr( email.value.length-1, 1) == ' '){
		email.value = email.value.substr(0, email.value.length-1);	//strip off the last character
	}
	

	if ( !(email.value.match(illegalChars))) {
  	 addError('The email address is invalid.', email);	
	 valid = false;
   }

//date of birth - month
	var m = month.value;

	while(m.substr(0, 1) == ' '){
		m = m.substr(1);	//strip off the first character
	}

	//remove the trailing space on the password
	while(m.substr( m.length-1, 1) == ' '){
		m = m.substr(0, m.length-1);	//strip off the last character
	}
	m = parseInt(m);
	if(m<1 || m > 12 || isNaN(m)  ){
		addError('There are only 12 months in a year.', year);	
		valid = false;
	}
	
//date of birth - day
	var d = day.value;
	while(d.substr(0, 1) == ' '){
		d = d.substr(1);	//strip off the first character
	}

	//remove the trailing space on the password
	while(d.substr( d.length-1, 1) == ' '){
		d = d.substr(0, d.length-1);	//strip off the last character
	}
	
	d = parseInt(d);
	if(d<1 || d > 31 || isNaN(d)){
		addError('There are up to 31 days in a month.', year);	
		valid = false;
	}
	
//date of birth - year
	var y = year.value;
	while(y.substr(0, 1) == ' '){
		y = y.substr(1);	//strip off the first character
	}

	//remove the trailing space on the password
	while(y.substr( y.length-1, 1) == ' '){
		y = y.substr(0, y.length-1);	//strip off the last character
	}
	
	y = parseInt(y);
	if( y > 2008 || isNaN(y)){
		addError("Please submit a year before 2009.", year);	
		valid = false;
	}
	
//secret question and answer
	while(answer.value.substr(0, 1) == ' '){
		answer = answer.value.substr(1);	//strip off the first character
	}

	//remove the trailing space on the password
	while(answer.value.substr( answer.value.length-1, 1) == ' '){
		answer.value = answer.value.substr(0, answer.value.length-1);	//strip off the last character
	}
	
	if(answer.value <6){
		addError("Answer needs to be longer than 5 characters.", answer);	
		valid = false;
	}
	
//check box
	if(check.checked != true ){
		addError("Please check the box.", check);	
		valid = false;
	}
	
	return valid;
	
}


function addError(msg, field)
{
	//display the error message beside the field indicated - do it in a generic way that will work for ALL fields
	//alert(msg);
	//find the parent of the field
	//create a new span
	var span = document.createElement('span');
	//create a text node
	var txt = document.createTextNode(msg);
	//put the text inside the span
	span.appendChild(txt);
	//append the span inside the parent
	field.parentNode.appendChild(span);
	//set the className on the span to "error"
	span.className = 'error';
}

function clearOldErrorMessages()
{
	//find all the spans with the classname error and remove them from their parents	
	var spans = document.getElementsByTagName('span');
	//loop through each span
	for(var s=spans.length-1; s>=0; s--){
		//check if the span has the classname error
		if( spans[s].className == 'error'){
			//remove it
			spans[s].parentNode.removeChild(spans[s]);
		}
	}
}

function clearForm()
{
	if(confirm("Are you sure you want to reset the form?")){
		document.form.reset();	
	}
}

function highlight()
{
	this.className = this.className + ' highlighted';
}

function unhighlight()
{
	var pos = this.className.indexOf(' highlighted');
	this.className = this.className.substring(0, pos);	
}
