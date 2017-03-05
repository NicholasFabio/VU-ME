
$(document).ready(function () {
    $('form').submit(function () {
        return false;
    });
});

/*var strength = {
  0: "Very Weak",
  1: "Weak",
  2: "Reasonable",
  3: "Good",
  4: "Strong"
}

var password = document.getElementById('password');
var meter = document.getElementById('password-strength-meter');
var text = document.getElementById('password-strength-text');

password.addEventListener('input', function() {
  var val = password.value;
  var result = zxcvbn(val);

  // Update the password strength meter
  meter.value = result.score;

  // Update the text indicator
  if (val !== "") {
    text.innerHTML = "Strength: " + strength[result.score]; 
  } else {
    text.innerHTML = "";
  }
});*/


function sendAJAXRequest (action, responseFunction, formID) {
    //Check the types of the parameters
    if (typeof action == 'string' && typeof responseFunction == 'function' && (typeof formID == 'string' || formID == null)) {
        //Validate the form
        if (formID != null) {
            if (validateForm(formID)) {
                //Upon successful validation, build the ajax data object
                var objectJSON = '{"action":"' + action + '"';
                //Generate the input from the input tags of the form
                var form = document.getElementById(formID);
                //console.log(formData);
                if (form != null) {
                    var forms = document.forms.namedItem(formID);
                    var oData = new FormData(forms);
                    oData.append("action",action);
                    console.log(oData);
                    var inputTags = form.getElementsByTagName('input');
                    var selectTags = form.getElementsByTagName('select');
                    var textareaTags = form.getElementsByTagName('textarea');
                    if (inputTags.length > 0) {
                        var inputTag;
                        var i;
                        for (i = 0; i < inputTags.length; i++) {
                            inputTag = inputTags[i];
                            //document.querySelector(inputTag);
                            objectJSON += ', "' + inputTag.name + '":"' + inputTag.value + '"';
                            if(inputTag.name.substr(inputTag.name.length - 6) == "switch"){
                                objectJSON += ', "' + inputTag.name.substr(7) + '":"' + document.getElementById(inputTag.name.substr(7)).checked + '"';
                            }
                        }
                    }
                    if (selectTags.length > 0) {
                        var selectTag;
                        var j;
                        for (j = 0; j < selectTags.length; j++) {
                            selectTag = selectTags[j];
                            objectJSON += ', "' + selectTag.name + '":"' + selectTag.value + '"';
                        }
                    }
                    if (textareaTags.length > 0) {
                        var textareaTag;
                        var k;
                        for (k = 0; k < textareaTags.length; k++) {
                            textareaTag = textareaTags[k];
                            objectJSON += ', "' + textareaTag.name + '":"' + textareaTag.value + '"';
                        }
                    }
                }
                objectJSON += '}';
                console.log(objectJSON);
                var dataObject = JSON.parse(objectJSON);
                //All ajax requests are handled by php/classes/SebenzaServer.php
                $.ajax({
                    type: 'POST',
                    url: 'php/classes/Server.php',
                    data: dataObject,
                    success: responseFunction
                });
            }
        } else {
            $.ajax({
                type: 'POST',
                url: 'php/classes/Server.php',
                data: {action: action},
                success: responseFunction
            });
        }
    }
}

function validateForm(formID) {
    var success = true;
    var focus = false;
    if (typeof formID == 'string') {
        //Collect input tags belonging to the form
        var form = document.getElementById(formID);
        if (form != null) {
            var inputTags = form.getElementsByTagName('input');

            currentInputSuccess = true;
            if (inputTags.length > 0) {
                var inputTag;
                var i;
                for (i = 0; i < inputTags.length; i++) {
                    inputTag = inputTags[i];
                    console.log(inputTag.name + " " + inputTag.value);
                    if (inputTag.name.substring(0,6) != "ignore") {

                        var inputToggleID = inputTag.name + '-info';
                        //remove the line underneath once all forms have been completed
                        //console.log("These are the input tag names: " + inputTag.name);
                        var inputFoundationID = '#' + inputToggleID;
                        var inputClassName = inputTag.className;
                        var inputDisplayProperty = document.getElementById(inputToggleID);

                        //Alpha-numeric validation
                        if (inputClassName.indexOf("AN_VAL") > -1 && !inputTag.value.match(alphaNumericRE)) {
                            currentInputSuccess = false;
                            if(!focus){
                                //console.log("Focusing on " + inputToggleID);
                                document.getElementById(inputTag.name).focus();
                                focus = true;
                            }
                        }

                     /*   //Required field validation
                        if (inputClassName.indexOf("REQ_VAL") > -1 && inputTag.value.length == 0) {
                            currentInputSuccess = false;
                            if(!focus){
                                //console.log("Focusing on " + inputToggleID.substring(0,inputToggleID.length-5) + " " + inputTag.name);
                                document.getElementById(inputTag.name).focus();
                                focus = true;
                            }
                        }

                        //Toggle display of messages
                        if (currentInputSuccess && inputDisplayProperty != '' && inputDisplayProperty != 'none') {
                            $(inputFoundationID).foundation('toggle');
                        } else if (!currentInputSuccess && (inputDisplayProperty == '' || inputDisplayProperty == 'none')) {
                            $(inputFoundationID).foundation('toggle');
                        }*/
                        //Set success to false if applicable
                        success &= currentInputSuccess;
                    }
                }
            } else {
                console.log("The form " + formID + " had no input elements to validate.");
            }
        } else {
            console.log("Could not validate. No form with the id: " + formID);
        }
    } else {
        success = false;
    }
    //console.log(success);
    return success;
}

function handleResponse(response) {
    var success = JSON.parse(response);
    if (success) {
        console.log("Result: ");
        console.log(success);
    } else {
        //var displayProperty = document.getElementById('invalid-credentials-message').style.display.toLowerCase();
        // if (displayProperty == '' || displayProperty == 'none') {
        //   $('#invalid-credentials-message').foundation('toggle');
        //}
    }
}

function handleLoginResponse(response){
    var success = JSON.parse(response);
    if(success){
        console.log("Logged in!");
        window.location = 'Feeds.php';
    }else{
        console.log("Cannot log in");
    }
}

function handleLogoutResponse(response) {
    window.location = '/';
}

function handleServerValidation(response) {
    var success = JSON.parse(response);
    if (success) {
        // do nothing as the user can proceed
    } else {
        // if no session exists send the user back to the login screen
        window.location = 'Login.php';
    }
}

function handleFetchUserDetials(response){
    $response = JSON.parse(response);
    console.log($response);
    var p = document.getElementById("details");
    p.innerHTML = "Welcome " + $response[0]["Name"] + "!";
   // p.val =  "" ;//response[0]['Name'];
}

function handleFetchUsers(response){
    $response = JSON.parse(response);
    console.log($response);
    var t = document.getElementById("feeds-table");
    //t.innerHTML = "<tbody> <tr></tr>";
    for(var i = 0; i < $response.length; i++){
        var count = i ;

        t.innerHTML +=  $response[i]["Username"] + "<br>" + "POST HERE" + "<hr width='50%'>" ;

    }
    //t.innerHTML = "</tbody> ";

}

function handleFetchFollowers(response){
    var res = JSON.parse(response);
    console.log(res);
    var UserName = "";
    var PPic = "" ;
    var display = document.getElementById("followers-Display");
    display.innerHTML = "" ;
    for(var i = 0; i < res.length ;i++){
        UserName = res[i][0]['Username'] ;
        PPic = res[i][0]['ProfilePicture'] ;
        // display.innerHTML = "<img src='" + PPic + "'>";
        //display.innerHTML += UserName ;
        DisplayImage_text(PPic,'followers-Display', UserName);

    }


    //document.getElementById("followers").disabled = true;
}

function handleFetchFollowing(response){
    var res = JSON.parse(response);
    console.log(res);
    var UserName = "";
    var PPic = "" ;
    var display = document.getElementById("following-Display");
    display.innerHTML = "" ;
        for (var i = 0; i < res.length; i++) {
            UserName = res[i][0]['Username'];
            PPic = res[i][0]['ProfilePicture'];
            // display.innerHTML = "<img src='" + PPic + "'>";
            //display.innerHTML += UserName ;
            DisplayImage_text(PPic, 'following-Display', UserName);

        }


    // document.getElementById("following").disabled = true;

}

function DisplayImage_text(path, ElementId, username) {
    var image = document.createElement("IMG");
    var Uname = document.createTextNode(username);
    image.src = path;
    image.width=100;
    image.height=100;
    document.getElementById(ElementId).appendChild(Uname) ;
    document.getElementById(ElementId).appendChild(image);
    document.getElementById(ElementId).innerHTML += '&nbsp' ;
    //document.getElementById(ElementId).innerHTML += "<br><hr width='40%'>" ;
}
