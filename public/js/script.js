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
var idScan = 0;

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
  // console.log(result);
  // console.log(result.codeResult.code);
  document.getElementById('codebar'+idScan).value = result.codeResult.code;
  document.getElementById('barcode-scanner').style.display = "none";
  Quagga.stop();
});
