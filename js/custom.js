function checkSelectionStatus() {
  if(options[options.selectedIndex].value == "asset") {
    document.getElementById("testpara").innerHTML = "Asset";
  }
  else {
    document.getElementById("testpara").innerHTML = "PID";
  }
}

function validateSearch(input) {
  if(input != "sam") {
    document.getElementById("testpara").innerHTML = "INCORRECT ASSET";
  }
}
