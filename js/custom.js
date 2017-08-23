
/**
 * Comments
 * @param
 * @param
 * @return
 */
function checkSearchBySchool() {
  if(options[options.selectedIndex].value == "school") {
    document.getElementById("school-options").style.display = "inline";
    changeCurrentRooms();
  }
  else {
    document.getElementById("school-options").style.display = "none";
    hideSchoolRooms();
  }
}

/**
 * Comments
 * @param
 * @param
 * @return
 */
function hideSchoolRooms() {
  document.getElementById("marshall-rooms").style.display = "none";
  document.getElementById("fremont-rooms").style.display = "none";
  document.getElementById("sutter-rooms").style.display = "none";
  document.getElementById("malaga-rooms").style.display = "none";
  document.getElementById("fhs-rooms").style.display = "none";

}

/**
 * Comments
 * @param
 * @param
 * @return
 */
function changeCurrentRooms() {
  hideSchoolRooms();

  var selectOptions = document.getElementById("school-options").options;
  var selectedIndex = document.getElementById("school-options").selectedIndex;
  var school = selectOptions[selectedIndex].value;
  school = school.concat("-rooms");
  document.getElementById(school).style.display = "inline";
  document.getElementById(school).selectedIndex = 0;
}

/**
 * Comments
 * @param
 * @param
 * @return
 */
function fillEditDataClass(school, room, asset, serial, model, status, assignment) {
  fillGeneralChromebookInfo(asset, serial, model, status, assignment);

  school = school.toLowerCase();
  var roomOptionsString = school.concat("-rooms");
  var roomOptions = document.getElementById(roomOptionsString).innerHTML;
  document.getElementById("edit-school-select").value = school;
  document.getElementById("edit-room-field").innerHTML = roomOptions;
  document.getElementById("edit-room-field").value = room;
  document.getElementById("original-asset").value = asset;
}

function fillEditDataStudent(school, student, asset, serial, model, status, assignment) {
  console.log(school);
  school = school.toLowerCase();
  var roomOptionsString = school.concat("-rooms");
  var roomOptions = document.getElementById(roomOptionsString).innerHTML;

  fillGeneralChromebookInfo(asset, serial, model, status, assignment);
  document.getElementById("edit-school-select").value = school;
  document.getElementById("edit-room-field").innerHTML = roomOptions;
  document.getElementById("edit-room-field").value = "student";
  document.getElementById("original-asset").value = asset;

}

function fillGeneralChromebookInfo(asset, serial, model, status, assignment) {
  console.log(assignment);

  document.getElementById("edit-asset-field").value = asset;
  document.getElementById("edit-serial-field").value = serial;
  document.getElementById("edit-model-select").value = model;
  document.getElementById("edit-physical-status-select").value = status;
  document.getElementById("edit-assignment-select").value = assignment.toLowerCase();
}

/**
 * Comments
 * @param
 * @param
 * @return
 */
function checkAscending(columnName) {
  var rows = document.getElementsByClassName(columnName);
  for(i = 0; i < (rows.length - 1); i++) {
    if(rows[i + 1].innerHTML < rows[i].innerHTML) {
      return true;
    }
  }
  return false;
}

/**
 * Comments
 * @param
 * @param
 * @return
 */
function sortTable(columnName) {
  if(checkAscending(columnName)) {
    sortAscending(columnName);
  }
  else {
    sortDescending(columnName);
  }
}

/**
 * Comments
 * @param
 * @param
 * @return
 */
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

/**
 * Comments
 * @param
 * @param
 * @return
 */
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

/**
 * Comments
 * @param
 * @param
 * @return
 */
function checkAssignment() {
  var assignment = document.getElementById("edit-assignment-status-select");
  var studentInput = document.getElementsByClassName("student-id");
  var insurance = document.getElementsByClassName("insurance");
  if(assignment.value == "assigned") {
    studentInput[0].style.display = "inline";
    studentInput[1].style.display = "inline";
    insurance[0].style.display = "inline";
    insurance[1].style.display = "inline";

  }
  else {
    studentInput[0].style.display = "none";
    studentInput[1].style.display = "none";
    insurance[0].style.display = "none";
    insurance[1].style.display = "none";
  }
}

/**
 * Comments
 * @param
 * @param
 * @return
 */
function filterSearch(searchBar) {
  var stringInput = document.getElementById(searchBar).value.toUpperCase();
  var assetTagRows = document.getElementsByClassName("asset");
  var serialNumberRows = document.getElementsByClassName("serial");
  var tableRows = document.getElementsByTagName("tr");

  for(var i = 0; i < assetTagRows.length; i++) {
    if(assetTagRows.length && assetTagRows[i].innerHTML.toUpperCase().indexOf(stringInput) > -1 ||
      serialNumberRows.length && serialNumberRows[i].innerHTML.toUpperCase().indexOf(stringInput) > -1) {
      tableRows[i + 1].style.display = "";
    }
    else {
      tableRows[i + 1].style.display = "none";
    }
  }
}

/**
 * Comments
 * @param
 * @param
 * @return
 */
function openRepairForm() {
  var date = new Date();
  $("#myModal").modal("hide");
  $("#repairModal").modal("show");
  document.getElementById("asset-repair-field").value = document.getElementById("edit-asset-field").value;
  document.getElementById("date-field").value = date.toDateString();
}

/**
 * Comments
 * @param
 * @param
 * @return
 */
function determineDamageString(inputString) {
  if(inputString == "screen") {
    return "Broken Screen";
  }
  else {
    return "Broken Keyboard";
  }
}

/**
 * Comments
 * @param
 * @param
 * @return
 */
function calculateRepairCost(repairSelected) {

  if(repairSelected == undefined) {
    repairSelected = determineDamageString(document.getElementById("repair-select").value);
  }
  var costField = document.getElementById("cost");

  if(repairSelected == "Broken Screen") {
    costField.value = "20";
  }
  else {
    costField.value = "50";
  }
}

/**
 * Comments
 * @param
 * @param
 * @return
 */
function fillRepairModal(asset, serial, model, damage, location, amount, assignment) {

  calculateRepairCost(damage);
  document.getElementById("asset").value = asset;
  document.getElementById("serial").value = serial;
  document.getElementById("model").value = model;
  document.getElementById("damage").value = damage;
  document.getElementById("location").value = location;
  document.getElementById("assignment").value = assignment;
}
