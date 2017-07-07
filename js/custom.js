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

function saveData(row) {
  sessionStorage.setItem("room", document.getElementById("resultTable").rows[row].cells[0].innerHTML);
  sessionStorage.setItem("asset", document.getElementById("resultTable").rows[row].cells[1].innerHTML);
  window.open("edit.php");
}

function loadData() {
  
}
