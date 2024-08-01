// JavaScript Document

//Validate Registration Form

function validateRegistration(unameavailability) {

	var password = document.forms["registrationForm"]["password"].value;
	var confirmpassword = document.forms["registrationForm"]["confirmpassword"].value;
	
	//Checks if Password and Confrm assword Fields Match

	if (password != confirmpassword) {
		document.getElementById('pwderror').style.display = "block";
		document.getElementById('password').value = null;
		document.getElementById('confirmpassword').value = null;
		return false;
	}	
}

//Validate New Book Form

function validatenewbookform(){
	
	// Checks if Genre is selected
	var genre = document.forms["newbookform"]["genre"].value;	
	if (genre == "--Select Genre-- *") {
		document.getElementById('genreerror').innerHTML = "Please Select Genre";
		return false;
	}
	
	// Checks if Language is selected
	var language = document.forms["newbookform"]["language"].value;
	if (language == "--Select Book Language-- *") {
		document.getElementById('lanerror').innerHTML = "Please Select Language";
		return false;
	}
	
	
}

//Validate MemId field in General Registration Form

function validatememid(){

	var memid = document.forms["registrationForm"]["memid"].value;
	
	var re = /^[p|sP|S0-9 ]+$/;
	var re2 = /^[p|sP|S ]+$/;
	
	if (!re.test(memid)) {
		if (memid = ""){
			document.getElementById('memiderror').innerHTML = "";
			document.getElementById('submit').disabled=false;
		} else {
			document.getElementById('memiderror').innerHTML = "Invalid ID. Please Check Again!";
			document.getElementById('submit').disabled=true;
		}
		
	} else {// When character s, p, S, P or Numbers Exists
		
		if ( !re2.test(memid.charAt(0))) {		// Check if 1st Character is s,S,p or P.
			document.getElementById('memiderror').innerHTML = "Invalid ID. Please Check Again!";
			document.getElementById('submit').disabled=true;
		}
		else {
			if (memid == "p" || memid == "P" || memid == "s" || memid == "S"){
				document.getElementById('memiderror').innerHTML = "Invalid ID. Please Check Again!";
				document.getElementById('submit').disabled=true;
			} else {
			document.getElementById('memiderror').innerHTML = "";
			document.getElementById('submit').disabled=false;
			}
		}
	}
}

//Validate MemId field in Librarian Registration Form

function validatelibid(){
	var memid = document.forms["registrationForm"]["memid"].value;
	
	var re = /^[l|L0-9 ]+$/;
	var re2 = /^[l|L]+$/;
	
	if (!re.test(memid)) {
		if (memid = ""){
			document.getElementById('memiderror').innerHTML = "";
			document.getElementById('submit').disabled=false;
		} else {
			document.getElementById('memiderror').innerHTML = "Invalid ID. Please Check Again!";
			document.getElementById('submit').disabled=true;
		}
		
	} else {
		// When character l, L or Numbers Exists
		if ( !re2.test(memid.charAt(0))) {		// Check if 1st Character is l or L
			document.getElementById('memiderror').innerHTML = "Invalid ID. Please Check Again!";
			document.getElementById('submit').disabled=true;
		}
		else {
			if (memid == "l" || memid == "L"){
				document.getElementById('memiderror').innerHTML = "Invalid ID. Please Check Again!";
				document.getElementById('submit').disabled=true;
			} else {
			document.getElementById('memiderror').innerHTML = "";
			document.getElementById('submit').disabled=false;
			}
		}
	}
}

// Validate First Name Field

function validatefname(){
	var fname = document.forms["registrationForm"]["fname"].value;
	
	var re = /^[a-zA-Z ]+$/;
	
	if (!re.test(fname)) {
		if (fname = ""){
			document.getElementById('fnameerror').innerHTML = "";
			document.getElementById('submit').disabled=false;
		} else {
			document.getElementById('fnameerror').innerHTML = "Invalid Characters Used!";
			document.getElementById('submit').disabled=true;
		}
		
	} else {
		document.getElementById('fnameerror').innerHTML = "";
		document.getElementById('submit').disabled=false;
	}
}

// Validate Last Name Field

function validatelname(){
	var lname = document.forms["registrationForm"]["lname"].value;
	
	var re = /^[a-zA-Z ]+$/;
	
	if (!re.test(lname)) {
		if (lname = ""){
			document.getElementById('lnameerror').innerHTML = "";
			document.getElementById('submit').disabled=false;
		} else {
			document.getElementById('lnameerror').innerHTML = "Invalid Characters Used!";
			document.getElementById('submit').disabled=true;
		}
		
	} else {
		document.getElementById('lnameerror').innerHTML = "";
		document.getElementById('submit').disabled=false;
	}
}

// Validate Contact Number

function validatecontactno(){
	var contactno = document.forms["registrationForm"]["contactno"].value;
	
	var re = /^[0-9 ]+$/;
	
	if (!re.test(contactno)) {
		if (contactno = ""){
			document.getElementById('contactnoerror').innerHTML = "";
			document.getElementById('submit').disabled=false;
		} else {
			document.getElementById('contactnoerror').innerHTML = "Only Numbers are Allowed!";
			document.getElementById('submit').disabled=true;
		}		
	} else {

		if (contactno.length != 10) {
			document.getElementById('contactnoerror').innerHTML = "Invalid Contact Number!";
			document.getElementById('submit').disabled=true;
		} else {
			document.getElementById('contactnoerror').innerHTML = "";
			document.getElementById('submit').disabled=false;
		}

		
	}
}


// Validate ISBN 10 Field

function validateisbn10(){
	var isbn = document.forms["newbookform"]["isbn10"].value;
	
	var re = /^[x|X0-9 ]+$/;
	
	if (!re.test(isbn)) {
		if (isbn == ""){
			document.getElementById('isbn10error').innerHTML = "";
			document.getElementById('submit').disabled=false;
		} else {
			document.getElementById('isbn10error').innerHTML = "Invalid ISBN!";
			document.getElementById('submit').disabled=true;''
		}
		
	} else {
		
		if (isbn.length != 10) {
			document.getElementById('isbn10error').innerHTML = "Invalid ISBN!";
			document.getElementById('submit').disabled=true;
		} else {
			document.getElementById('isbn10error').innerHTML = "";
			document.getElementById('submit').disabled=false;
		}		
	}

}


// Validate ISBN 13 Field

function validateisbn13(){
	var isbn = document.forms["newbookform"]["isbn13"].value;
	
	var re = /^[x|X0-9 ]+$/;
	
	if (!re.test(isbn)) {
		if (isbn == ""){
			document.getElementById('isbn13error').innerHTML = "";
			document.getElementById('submit').disabled=false;
		} else {
			document.getElementById('isbn13error').innerHTML = "Invalid ISBN!";
			document.getElementById('submit').disabled=true;
		}
		
	} else {
		
		if (isbn.length != 13) {
			document.getElementById('isbn13error').innerHTML = "Invalid ISBN!";
			document.getElementById('submit').disabled=true;
		} else {
			document.getElementById('isbn13error').innerHTML = "";
			document.getElementById('submit').disabled=false;
		}
		
		
	}
}


// Validate Change Password Section
 
function paswordChangeValidate() {
	var password = document.forms["changePwdForm"]["newpassword"].value;
	var confirmpassword = document.forms["changePwdForm"]["confirmpassword"].value;
	
	if (password != confirmpassword) {
		document.getElementById('pwderror').style.display = "block";
		return false;
	}	

}

