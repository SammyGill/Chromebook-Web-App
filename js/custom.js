
/**
 * Used in the search page to determine if the user is searching by a certain
 * school. If a certain school is selected, then the appropriate rooms will
 * be shown along side it
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
 * Helper method used to hide all of the rooms. This method is called so that
 * the appropriate school and its rooms can be shown afterwards
 */
function hideSchoolRooms() {
  document.getElementById("marshall-rooms").style.display = "none";
  document.getElementById("fremont-rooms").style.display = "none";
  document.getElementById("sutter-rooms").style.display = "none";
  document.getElementById("malaga-rooms").style.display = "none";
  document.getElementById("fhs-rooms").style.display = "none";

}

/**
 * Helper method that is used to display the correct rooms according to the
 * selected school during chromebook search. The function works by first hiding
 * all the schools, determing which school is selected, and then changing the
 * display for the corresponding rooms
 */
function changeCurrentRooms() {
  // Hide all the rooms before displaying the correct school and rooms
  hideSchoolRooms();

  var selectOptions = document.getElementById("school-options").options;
  var selectedIndex = document.getElementById("school-options").selectedIndex;
  var school = selectOptions[selectedIndex].value;
  school = school.concat("-rooms");
  document.getElementById(school).style.display = "inline";
  document.getElementById(school).selectedIndex = 0;
}

/**
 * Used to disable and enable the optional student button and student ID field
 * when adding a chromebook to the database. These two fields should only be
 * enabled when the school is either Sutter or FHS and when the room is
 * selected as "Student Assigned"
 */
function disableInsuranceButton() {
  var schoolSelect = document.getElementById("school-options");
  var studentIDText = document.getElementById("student-id");
  var insuranceButton = document.getElementById("insurance-button");
  if(schoolSelect.value == "fhs" || schoolSelect.value == "sutter") {
    var schoolRooms = schoolSelect.value.concat("-rooms");
    if(document.getElementById(schoolRooms).value == "student") {
        insuranceButton.disabled = false;
        studentIDText.disabled = false;
    }
    else {
      insuranceButton.disabled = true;
      studentIDText.disabled = true;
    }
  }
  else {
    insuranceButton.disabled = true;
    studentIDText.disabled = true;
  }
}

/**
 * General helper method that is used to fill in the information into the
 * edit modal independent on where the chromebook is being assigned. This
 * information is only the metadata for the chromebook itself and is called
 * in other methods when the chromebook is being added/edited to the database
 * @param asset is the asset tag for the chromebook
 * @param serial is the serial number for the chromebook
 * @param model is the model type for the chromebook
 * @param status is the Physical Status of the chromebook at the time
 * @param assignment is the assignment type of the chromebook at the time
 */
function fillGeneralChromebookInfo(asset, serial, model, status, assignment) {
  document.getElementById("edit-asset-field").value = asset;
  document.getElementById("edit-serial-field").value = serial;
  document.getElementById("edit-model-select").value = model;
  document.getElementById("edit-physical-status-select").value = status;
  document.getElementById("edit-assignment-select").value = assignment.toLowerCase();
}

/**
 * Used to fill in the data for the classrooms table in the database. This
 * adds the appropriate information for the chromebook into edit modal. The
 * function gets the appropriate information from the chromebooks table and the
 * classrooms table and then inputs it into the modal for display
 * @param school is the school location for the chromebook
 * @param room is the room location for the chromebook
 * @param asset is the asset tag for the chromebook
 * @param serial is the serial number for the chromebook
 * @param model is the model type for the chromebook
 * @param status is the Physical Status of the chromebook at the time
 * @param assignment is the assignment type of the chromebook at the time
 */
function fillEditDataClass(school, room, asset, serial, model, status, assignment) {
  // First fill in the appropriate information from the chromebooks table
  fillGeneralChromebookInfo(asset, serial, model, status, assignment);

  // Then fill in the information we got from the classrooms table
  school = school.toLowerCase();
  var roomOptionsString = school.concat("-rooms");
  var roomOptions = document.getElementById(roomOptionsString).innerHTML;
  document.getElementById("edit-school-select").value = school;
  document.getElementById("edit-room-field").innerHTML = roomOptions;
  document.getElementById("edit-room-field").value = room;
  document.getElementById("original-asset").value = asset;
}

/**
 * Similar to the fill in classroom function except it pulls data from the
 * students table because the chromebook is assigned to a student
 * @param school is the school location for the chromebook
 * @param student is the student ID for the student who holds the chromebooks
 * @param asset is the asset tag for the chromebook
 * @param serial is the serial number for the chromebook
 * @param model is the model type for the chromebook
 * @param status is the Physical Status of the chromebook at the time
 * @param assignment is the assignment type of the chromebook at the time
 */
function fillEditDataStudent(school, student, asset, serial, model, status, assignment) {
  school = school.toLowerCase();
  var roomOptionsString = school.concat("-rooms");
  var roomOptions = document.getElementById(roomOptionsString).innerHTML;

  fillGeneralChromebookInfo(asset, serial, model, status, assignment);
  document.getElementById("edit-school-select").value = school;
  document.getElementById("edit-room-field").innerHTML = roomOptions;
  document.getElementById("edit-room-field").value = "student";
  document.getElementById("original-asset").value = asset;

}

/**
 * Helper method used to determine
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

// PROBABLY NOT NEEDED ANY MORE, WILL NEED TO DO SOME TESTING TO FIND OUT THOUGH
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
 * Helps filter search textboxes while the user is typing. Every input into
 * the textbox refines the results a little more by hiding all of the results
 * that are not similar to the input
 * @param searchBar is the HTML text field where the user searches
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
 * Used to hide the edit chromebook modal and open up the repair modal in
 * order to subtmit a repair request
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
