var ascending = false;
var lastFilter;

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
  document.getElementById("editSerialField").value = document.getElementById("resultTable").rows[row].cells[2].innerHTML;
  document.getElementById("editModelField").value = document.getElementById("resultTable").rows[row].cells[3].innerHTML;
  document.getElementById("editStatusField").value = document.getElementById("resultTable").rows[row].cells[4].innerHTML;
  document.getElementById("originalAsset").value = document.getElementById("resultTable").rows[row].cells[1].innerHTML;
}

function checkAscending(columnName) {
  var rows = document.getElementsByClassName(columnName);
  for(i = 0; i < (rows.length - 1); i++) {
    if(rows[i + 1].innerHTML < rows[i].innerHTML) {
      return true;
    }
  }
  return false;
}

function sortTable(columnName) {
  if(checkAscending(columnName)) {
    sortAscending(columnName);
  }
  else {
    sortDescending(columnName);
  }
}


function sortAscending(columnName) {
  var rows = document.getElementsByClassName(columnName);
  for(i = 0; i < (rows.length); i++) {
    var indexElement = rows[i].innerHTML;
    var j = i;
    while( j > 0 && (rows[j-1].innerHTML > indexElement)) {
      var parentRow = document.getElementById("resultTable").rows[j];
      var childRow = document.getElementById("resultTable").rows[j + 1];
      var table = parentRow.parentNode;
      table.insertBefore(childRow, parentRow);
      j--;
    }
  }
}

function sortDescending(columnName) {
  var rows = document.getElementsByClassName(columnName);
  for(i = 0; i < (rows.length); i++) {
    var indexElement = rows[i].innerHTML;
    var j = i;
    while( j > 0 && (rows[j-1].innerHTML < indexElement)) {
      var parentRow = document.getElementById("resultTable").rows[j];
      var childRow = document.getElementById("resultTable").rows[j + 1];
      var table = parentRow.parentNode;
      table.insertBefore(childRow, parentRow);
      j--;
    }
  }
}
