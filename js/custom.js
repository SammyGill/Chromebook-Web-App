var selectedValue = document.getElementById("options");

function check() {
  if(options[options.selectedIndex].value == "asset") {
    document.getElementById("testpara").innerHTML = "Asset";
  }
  else {
    document.getElementById("testpara").innerHTML = "PID";
  }
}
