
function refresh(){
  localStorage.clear();
  }
function login_instr(){
	localStorage.setItem("inst", "inst");
	window.location.assign("instruloginForm.php");
}

function login_stu(){
	localStorage.setItem("stu", "stu");
	window.location.assign("stuLoginForm.php");
}

function decideEdit(){
if(localStorage.getItem("stu") == "stu"){
	// student, so his options are [drop]
document.getElementById("instructorView").style.visibility = "hidden";
document.getElementById("studentView").style.visibility = "visible";
}
if(localStorage.getItem("inst") == "inst"){
	// instructor, so his options are [edit|drop]
document.getElementById("studentView").style.visibility = "hidden";
document.getElementById("instructorView").style.visibility = "visible";
}
return false;
}

function sortTable() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("myTable");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[0];
      y = rows[i + 1].getElementsByTagName("TD")[0];
      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}

function signup(){

	
	var name = document.getElementById("FName").value;
	var mname = document.getElementById("MName").value;
	var lname = document.getElementById("LName").value;
	var email = document.getElementById("email").value;
	var psw = document.getElementById("psw").value;
	if(name == ""){
		
		alert("you need to enter first name");

	} else if (mname == ""){
 
        		alert("you need to enter middle name");

	} else if (lname == ""){
 
        		alert("you need to enter last name");

	}		else if (!isNaN(name)){
/*if one of them is a number*/
		alert("All the name fields shouldn't conatin digits");

	}else if (email == ""){
		
		alert("you need to enter your email");

		
	}else if (psw == ""){
		
		alert("you need to enter your password");

     
	}if ( name!="" && mname!= "" && lname!= "" && email!="" && psw!=""){
	
	document.forms["myForm"].submit();
	//alert("Welcome! you have signed up successfully");
		//window.location.assign("student.php");

	}
}


function validateLoginForm() {
  var email = document.forms["myForm"]["email"].value;
  var psw = document.forms["myForm"]["password"].value;
  //var name = document.forms["myForm"]["fname"].value;
  if (email == "") {
    alert("Email must be filled out");
    return false;
  }
  if (psw == "") {
    alert("Password must be filled out");
    return false;
  }
 /* if (name == "") {
    alert("Name must be filled out");
    return false;
  }*/
  if ( email!="" && psw!="" ){
		if(window.location.href.includes("stuLoginForm.php")){
			document.forms["myForm"].submit();
			//window.location.assign("user.php?q=std_login");
		}
		if(window.location.href.includes("instruloginForm.php")){
			document.forms["myForm"].submit();
			//window.location.assign("instructor.php");
		}
			return false;

	}
  
}
function validateCourseForm() {
	
  var title = document.forms["myForm"]["title"].value;
  var field = document.forms["myForm"]["field"].value;
  var description = document.forms["myForm"]["description"].value;
  
    if (title == "") {
    alert("Title must be filled out");
    return false;
	event.preventDefault();  
  }
  
  if (field == "") {
    alert("Field must be filled out");
    return false;
	 event.preventDefault();  
  }
  
  if (description == "") {
    alert("Description must be filled out");
    return false;
	 event.preventDefault();  
  }
 else{
return true;
 }	 
//  if ( title!="" && field!="" && description != "" ){
	//  document.forms["myForm"].submit();
		//alert("The course: " + title +" \n has been added successfully");
		//window.location.assign("instructor.php");
		//	return false;
//	}
}
function cancel(){
	window.location.assign("index.php");
	
}

// type letter only function input text
function letterinputFunction(inputletter){
	var ltrinput = /[^a-z ]/gi;
	inputletter.value = inputletter.value.replace(ltrinput, '');
}










