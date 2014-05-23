/**
 * @author jefffohl
 */
 
 function validateEmail(email) {
 	var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/;
 	if(!emailRegEx.test(email))	{
 		alert('The email field must contain a valid email address.');
 		return false;
 		}
  	return true;
 }
