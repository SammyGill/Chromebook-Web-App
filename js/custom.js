function checkSearchParam() {
  switch(options[options.selectedIndex].value) {
    case "asset":
      document.getElementById("testpara").innerHTML = "Asset";
      break;
    case "pid":
      document.getElementById("testpara").innerHTML = "PID";
      break;
    case "room":
      document.getElementById("testpara").innerHTML = "Room Number";
      break;
  }
}

function validateSearch(input) {
  if(input != "sam") {
    document.getElementById("testpara").innerHTML = "INCORRECT ASSET";
  }
}
