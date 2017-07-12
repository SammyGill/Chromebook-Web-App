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

function fillEditData(row) {
  document.getElementById("editRoomField").value = document.getElementById("resultTable").rows[row].cells[0].innerHTML;
  document.getElementById("editAssetField").value = document.getElementById("resultTable").rows[row].cells[1].innerHTML;
  document.getElementById("originalAsset").value = document.getElementById("resultTable").rows[row].cells[1].innerHTML;
}

function sortTable(columnName) {
  var columns = document.getElementsByClassName(columnName);
  for(i = 1; i < (columns.length - 1); i++) {
    var indexElement = columns[i].innerHTML;
    var j = i;
    while( j > 0 && (columns[j-1].innerHTML > indexElement)) {
      columns[j].innerHTML = columns[j - 1].innerHTML;
      j--;
    }
    columns[j].innerHTML = indexElement;
  }
}
