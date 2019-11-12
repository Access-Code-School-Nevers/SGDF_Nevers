// Variables
var idScan = 0;

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
          console.log(err);
          return
      }

      document.getElementById('barcode-scanner').style.display = "block";
      Quagga.start();
  });
}

// Stop scan after detection
Quagga.onDetected(function(result) {
  document.getElementById('codebar'+idScan).value = result.codeResult.code;
  document.getElementById('barcode-scanner').style.display = "none";
  Quagga.stop();
});



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
    objectSelected = objectSelected.substring(0,objectSelected.indexOf('(') - 1);
    var alreadySelected = 0;
    var hasRow = 0;

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
      document.getElementById('tableArticlesList').style.display = "flex";
    }

    if(alreadySelected == 0){
      // Insert a new row
      var row = document.getElementById('displayListObjectsSelected').insertRow();
      var objectName = row.insertCell(0);
      var quantityDisplayed = row.insertCell(1);
      var deleteObject = row.insertCell(2);

      // Add values
      objectName.innerHTML = '<input type="text" name="listObjects[]" value="'+objectSelected+'" disabled>';
      quantityDisplayed.innerHTML = '<input type="text" name="listObjects[]" value="'+quantitySelected+'" disabled>';
      deleteObject.innerHTML = '<span onClick="deleteObjectFromList(this)"><i class="fas fa-trash"></i></span>';
    }
    else
      console.log('Cet objet est déjà sélectionné.')
  }
  else
    console.log('champ non renseigné.');
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

  // Hide table if no articles in it
  if(hasRow == 0){
    document.getElementById('tableArticlesList').style.display = "none";
  }
}
