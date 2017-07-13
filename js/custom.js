var ascending = false;
var lastFilter;

function checkSearchBySchool() {
  if(options[options.selectedIndex].value == "school") {
    document.getElementById("school-options").style.display = "inline";
    checkSchool();
  }
  else {
    document.getElementById("school-options").style.display = "none";
  }
}

function hideSchools() {
  document.getElementById("mar-rooms").style.display = "none";
  document.getElementById("fre-rooms").style.display = "none";
  document.getElementById("sut-rooms").style.display = "none";
  document.getElementById("mal-rooms").style.display = "none";
  document.getElementById("fhs-rooms").style.display = "none";
}

function checkSchool() {
  hideSchools();

  var select = document.getElementById("school-options").options;
  var index = document.getElementById("school-options").selectedIndex;
  var school = select[index].value;
  school = school.concat("-rooms");
  document.getElementById(school).style.display = "inline";
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
