// Variables
var idScan = 0;
var containerElt = document.querySelector(".container_view");
//viewResponsive
function reportWindowSize() {
  if(window.innerWidth >= 1268) {
  containerElt.classList.remove("container_full_view");
  }
  else {
    containerElt.classList.add("container_full_view");
  }
}
window.onresize = reportWindowSize;

/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}


// Hide flash message
function hideMessage(el){
  el.style.display = "none";
}


/////////////////////////// ---  SCAN FUNCTION --- /////////////////////////
// Start a scan
function initScan(id){
  idScan = id;

  Quagga.init({
    inputStream : {
      name : "Live",
      type : "LiveStream",
      target: document.querySelector('#barcode-scanner')    // Or '#yourElement' (optional)
    },
    decoder : {
      readers : ["codabar_reader"]
    }
  }, function(err) {
      if (err) {
          return
      }

      document.getElementById('barcode-scanner').style.display = "block";
      Quagga.start();
  });
}

// Stop scan after detection
Quagga.onDetected(function(result) {
  document.getElementById('codebar'+idScan).value = result.codeResult.code;

  if(document.getElementById('codebar'+idScan).getAttribute('data-id-required') == result.codeResult.code)
    console.log('equivalent');
  else
    console.log('code barre different');

  document.getElementById('barcode-scanner').style.display = "none";
  Quagga.stop();
});


// ----------------------------- CHECK INPUT WITH VALUE ------------- */
// Check than input barcode is equivalent with the one needed
function verifyScan(el,id){
  if(el.getAttribute('data-id-required') == el.value){
    document.querySelector("#el"+id).classList.add("bar-success");
    document.querySelector("#el"+id+" .scan-in-progress").classList.add("d-none");
    document.querySelector("#el"+id+" .scan-success").classList.remove("d-none");
  }
}


// ------------------------------- RESERVATION -------------------------- //

// Get available objects with ajax
function getAvailablesObjets(el){
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4){
      var listObjects = JSON.parse(xhr.responseText);
      var tmpOptions = '';

      for(var i=0, v=listObjects.length ; i<v ; i++){
        tmpOptions += '<option>'+listObjects[i].titre+' ('+listObjects[i].quantite+' max.)</option>';
      }

      document.getElementById('listOfObjects').innerHTML = tmpOptions;
    }
  };
  xhr.open('GET', 'http://127.0.0.1:8000/api/objets-disponibles?date='+el.value);
  xhr.send();
}


// Add an article to reservation
function addArticleToReservation(){
  var objectSelected = document.getElementById('objectSelected').value;
  var quantitySelected = Number(document.getElementById('quantitySelected').value);

  if(objectSelected.length > 0 && typeof quantitySelected == 'number' && quantitySelected > 0){
    var maximumSelection = parseInt(objectSelected.substring(objectSelected.indexOf('(') + 1, objectSelected.indexOf('max') - 1));
    objectSelected = objectSelected.substring(0,objectSelected.indexOf('(') - 1);
    var alreadySelected = 0;
    var hasRow = 0;

    // Verify that the user didn't selected more than possible
    if(maximumSelection >= quantitySelected){
      // Verify that object is not already selected
      var inputsObjects = document.getElementsByTagName('input');
      for(var i=0, v=inputsObjects.length ; i<v ; i++){
        if(inputsObjects[i].name == "listObjects[]"){
          hasRow = 1;
          if(inputsObjects[i].value == objectSelected){
            alreadySelected = 1;
            break;
          }
        }
      }

      // Display the table if no articles in it and about to add one
      if(hasRow == 0){
        document.getElementById('reservez_form_Valider').disabled = false;
      }

      if(alreadySelected == 0){
        // Insert a new row
        var row = document.getElementById('displayListObjectsSelected').insertRow();
        var objectName = row.insertCell(0);
        var quantityDisplayed = row.insertCell(1);
        var deleteObject = row.insertCell(2);

        // Add values
        objectName.innerHTML = '<input type="text" name="listObjects[]" value="'+objectSelected+'" readonly>';
        quantityDisplayed.innerHTML = '<input type="text" name="quantityObjects[]" value="'+quantitySelected+'" readonly>';
        deleteObject.innerHTML = '<span onClick="deleteObjectFromList(this)"><i class="fas fa-trash"></i></span>';

        // Reset inputs
        document.getElementById('objectSelected').value = '';
        document.getElementById('quantitySelected').value = '';
      }
      else
        displayAlert('Cet objet est déjà sélectionné.');
    }
    else
      displayAlert('Impossible de réserver autant d\'articles');
  }
  else
    displayAlert('Un des champs n\'est pas correctement renseigné.');
}

// Delete an object selected
function deleteObjectFromList(el){
  // Delete row
  var row = el.parentNode.parentNode;
  row.parentNode.removeChild(row);

  var hasRow = 0;
  // Verify that object is not already selected
  var inputsObjects = document.getElementsByTagName('input');
  for(var i=0, v=inputsObjects.length ; i<v ; i++){
    if(inputsObjects[i].name == "listObjects[]"){
      hasRow = 1;
      break;
    }
  }

  // Display the table if no articles in it and about to add one
  if(hasRow == 0){
    document.getElementById('reservez_form_Valider').disabled = true;
  }
}


// Display an alert message
function displayAlert(text){
  var alert = document.createElement('div');
  alert.classList.add('alert','alert-danger','alert-custom');
  alert.setAttribute("onclick","hideMessage(this)");
  alert.innerHTML = text;
  document.body.appendChild(alert);

  // Remove after 3 seconds
  setTimeout(function(){
    if(document.getElementsByClassName('alert')[0] != undefined)
      document.getElementsByClassName('alert')[0].remove();
  }, 3000);
}


// Hide modal box
function hideModal(){
  document.getElementById('exampleModal').classList.remove('show');
  document.getElementById('exampleModal').classList.add('hide');
}
