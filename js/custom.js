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
  document.getElementById("marshall-rooms").style.display = "none";
  document.getElementById("fremont-rooms").style.display = "none";
  document.getElementById("sutter-rooms").style.display = "none";
  document.getElementById("malaga-rooms").style.display = "none";
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


function fillEditData(school, room, asset, serial, model, status) {

  document.getElementById("edit-school-select").value = school.toLowerCase();
  document.getElementById("edit-room-input").innerHTML = document.getElementById(school.toLowerCase().concat("-rooms")).innerHTML;
  document.getElementById("edit-room-input").value = room;
  document.getElementById("editAssetField").value = asset;
  document.getElementById("editSerialField").value = serial;
  document.getElementById("edit-model-select").value = model;
  document.getElementById("edit-physical-status-select").value = status;
  document.getElementById("originalAsset").value = asset;
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
