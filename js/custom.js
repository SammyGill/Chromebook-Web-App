function checkSearchParam() {
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

function checkSearchType() {
  if(type[type.selectedIndex].value == "single") {
    document.getElementById("otherpara").innerHTML = "Single";
  }
  else {
    document.getElementById("otherpara").innerHTML = "Mass";
  }
}
