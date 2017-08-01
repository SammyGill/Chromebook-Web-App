<?php

 /**
  *
  * Returns a connection to the MySQL Database
  *
  * @return MySQL connection
  */
  function getConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "chromebookapplication";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
  }

 /**
  *
  * Returns a Chromebook object based on asset tag or serial number. The function
  * determines whether the search is by asset tag or serial number and then
  * performs the correct search query. The resulting object is returned to
  * be used in other functions.
  *
  * @param searchInput is the asset tag or serial number input
  * @return $result is the resulting mySQL object
  *         -1 if there is no Chromebook that was found
  */
  function getChromebook($searchInput) {
    $conn = getConnection();

    $input = $searchInput["searchBarInput"];
    $result =
      $conn->query("SELECT locations.School, locations.Room, chromebooks.Asset,
                    chromebooks.Serial_Number, chromebooks.Model,
                    chromebooks.Physical_Status, chromebooks.Assignment_Status
                    FROM locations INNER JOIN chromebooks ON
                    chromebooks.asset=locations.asset WHERE
                    chromebooks.asset = $input");

    if ($conn->error || $result->num_rows == 0) {
      echo("Chromebook not found!");
    }
    else {
      formatTable($result);
    }
    $conn->close();
  }

  /**
   *
   * This functions is similar to the getChromebook() function but performs
   * a search for all of the chromebooks in a particular room. The resulting
   * object from search is then parsed for each chromebook in the room.
   *
   * @param $searchInput are the inputs/filters from the HTML form that are
   *        used to search for the chromebooks.
   * @return $result is the mySQL object that contains all of the chromebooks
   *         -1 if there were no chromebooks found
   */
  function getChromebookRoom($searchInput) {
    $conn = getConnection();

    $school = $searchInput["school-options"];
    $room = $searchInput[$school . "-rooms"];

    if($room == "*") {
      $result =
        $conn->query("SELECT locations.School, locations.Room,
                      chromebooks.Asset, chromebooks.Serial_Number,
                      chromebooks.Model, chromebooks.Physical_Status,
                      chromebooks.Assignment_Status FROM locations INNER JOIN
                      chromebooks ON chromebooks.asset=locations.asset
                      WHERE locations.School = \"$school\"");
    }
    else {
      $result =
        $conn->query("SELECT locations.School, locations.Room,
                      chromebooks.Asset, chromebooks.Serial_Number,
                      chromebooks.Model, chromebooks.Physical_Status,
                      chromebooks.Assignment_Status FROM locations INNER JOIN
                      chromebooks ON chromebooks.asset=locations.asset
                      WHERE locations.School = \"$school\"
                      AND locations.Room = $room");
    }

    if($conn->error) {
      echo("ERROR");
      return -1;
    }
    if(!$result->num_rows) {
      echo("NO CHROMEBOOKS WERE FOUND! TRY AGAIN");
    }
    else {
      formatTable($result);
    }
    $conn->close();
  }

  /**
   *
   * Searches for all of the chromebooks that have the damaged status. There
   * are two different queries that are performed for schools and students
   * since there are different types of information needed for them.
   *
   * @return $result is the mySQL object that contains all of the chromebooks
   *         -1 if there were no chromebooks found
   */
  function getChromebookRepair() {
    $conn = getConnection();

    $resultStudents =
      $conn->query("SELECT chromebooks.Asset, chromebooks.Assignment_Status,
                    chromebooks.Serial_Number, chromebooks.Model, damages.Type,
                    students.Student_ID, students.Amount FROM chromebooks
                    INNER JOIN students ON chromebooks.asset = students.asset
                    INNER JOIN damages ON chromebooks.asset = damages.asset");

    $resultSchools =
      $conn->query("SELECT chromebooks.Asset, chromebooks.Assignment_Status,
                    chromebooks.Serial_Number, chromebooks.Model, damages.Type,
                    locations.School, locations.Room FROM chromebooks INNER JOIN
                    locations ON chromebooks.asset = locations.asset INNER JOIN
                    damages ON chromebooks.asset = damages.asset");

    $result = array($resultStudents, $resultSchools);

    formatTableRepair($result);
    $conn->close();
  }

  /**
   *
   * Performs a search through the database for chromebooks that have the
   * assignment status of unassigned
   *
   * @return $result is the mySQL object that contains all of the chromebooks
   *         -1 if there were no chromebooks found
   */
  function getChromebooksUnassigned() {
    $conn = getConnection();
    $result = $conn->query("SELECT * FROM chromebooks
                            WHERE Assignment_Status = 'Unassigned'");
    formatTableUnassigned($result);
    $conn->close();
  }

  /**
   *
   * Comments
   *
   * @param
   * @param
   * @return
   */
  function quickAdd($chromebook) {
    $conn = getConnection();

    $asset = $chromebook["edit-asset-field"];
    $serial = $chromebook["edit-serial-field"];
    $room = 0;

    if(chromebookExists($asset)) {
      echo("<br>");
      echo("CHROMEBOOK ALREADY EXISTS");
      return -1;
    }

    $conn->query("INSERT INTO chromebooks (room, asset)
                  VALUES ($room, $asset)");


    // Currently going to be adding Chromebook without serial, will add into later version
    echo("<br>");
    echo("CHROMEBOOK SUCCESSFULLY ADDED");
    $conn->close();
  }

  /**
   *
   * Comments
   *
   * @param
   * @param
   * @return
   */
  function chromebookExists($chromebookAsset) {
    $conn = getConnection();

    $result = $conn->query("SELECT * FROM chromebooks WHERE
                         asset = $chromebookAsset");
    $conn->close();
    return $result->num_rows;
  }

  /**
   *
   * Comments
   *
   * @param
   * @param
   * @return
   */
  function formatTable($query) {
    echo("<table style=width:100% id=resultTable>");
    echo("<tr>
            <th onclick='sortTable(\"location\")'> School + Room </th>
            <th onclick='sortTable(\"asset\")'> Asset Tag </th>
            <th onclick='sortTable(\"serial\")'> Serial Number </th>
            <th onclick='sortTable(\"model\")'> Model </th>
            <th onclick='sortTable(\"status\")'> Physical Status </th>
          </tr>");

    while($row = $query->fetch_assoc()) {
      $room = $row["Room"];
      $asset = $row["Asset"];
      $school = $row["School"];
      $serial = $row["Serial_Number"];
      $status = $row["Physical_Status"];
      $model = $row["Model"];

      echo("<tr data-toggle = 'modal' data-target = '#myModal'
                onclick= 'fillEditData(\"$school\", $room, $asset, \"$serial\",
                                       \"$model\", \"$status\")'>

              <td class=location>$school $room</td>
              <td class=asset> $asset </td>
              <td class=serial> $serial </td>
              <td class='model'>$model</td>
              <td class=status>$status</td>

            </tr>");
    }
  }

  /**
   *
   * Comments
   *
   * @param
   * @param
   * @return
   */
  function formatTableRepair($query) {
    echo("<table style=width:100% id=resultTable>");
    echo("<tr>
            <th onclick='sortTable(\"asset\")'> Asset Tag </th>
            <th onclick='sortTable(\"model\")'> Model </th>
            <th onclick='sortTable(\"damage\")'> Damage </th>
          </tr>");

    for($x = 0; $x < count($query); $x++) {
      while($row = $query[$x]->fetch_assoc()) {
        $asset = $row["Asset"];
        $serial = $row["Serial_Number"];
        $model = $row["Model"];
        $damage = $row["Type"];
        $damage = determineDamageString($damage);
        $assignment = $row["Assignment_Status"];
        if("$assignment" == "School" || "$assignment" == "Loaner") {
          $school = $row["School"];
          $room = $row["Room"];
          $location = "$school $room";
          $amount = 0;
        }
        else {
          $location = $row["Student_ID"];
          $amount = $row["Amount"];
        }
        echo("<tr data-toggle = 'modal' data-target = '#myModal'
               onclick='fillRepairModal(\"$asset\", \"$serial\", \"$model\",
                                        \"$damage\", \"$location\", $amount,
                                        \"$assignment\")'>
                <td class=asset> $asset </td>
                <td class=model> $model </td>
                <td class=damage> $damage </td>
            </tr>");
      }
    }
  }

  /**
   *
   * Comments
   *
   * @param
   * @param
   * @return
   */

   // THIS FUNCTION MAY NOT BE NEEDED, NEED TO DOUBLE CHECK
  function determineDamageString($damageInput) {
    if($damageInput == "Broken Screen") {
      return "Broken Screen";
    }
    else {
      return "Broken Keyboard";
    }
  }

  /**
   *
   * Comments
   *
   * @param
   * @param
   * @return
   */
  function formatTableUnassigned($query) {
    echo("<table style=width:100% id=resultTable>");
    echo("<tr>
            <th onclick='sortTable(\"asset\")'> Asset Tag </th>
            <th onclick='sortTable(\"serial\")'> Serial Number </th>
            <th onclick='sortTable(\"model\")'> Model </th>
            <th onclick='sortTable(\"status\")'> Physical Status </th>
          </tr>");

    while($row = $query->fetch_assoc()) {
      $asset = $row["Asset"];
      $serial = $row["Serial_Number"];
      $status = $row["Physical_Status"];
      $model = $row["Model"];

      echo("<tr data-toggle = 'modal' data-target = '#assignModal'>

              <td class=asset> $asset </td>
              <td class=serial> $serial </td>
              <td class='model'> $model </td>
              <td class=status> $status </td>

            </tr>");
    }
  }

  /**
   *
   * Comments
   *
   * @param
   * @param
   * @return
   */
  function updateChromebook($query) {
    $conn = getConnection();

    $room = $query["edit-room-field"];
    $asset = $query["edit-asset-field"];
    $serial = $query["edit-serial-field"];
    $model = $query["edit-model-select"];
    $status = $query["edit-physical-status-select"];
    $oldAsset = $query["original-asset"];

    $conn->query("UPDATE chromebooks SET room = $room, asset = $asset,
                  serial_number =\"$serial\", model=\"$model\",
                  Physical_Status=\"$status\" WHERE asset = $oldAsset");

    $conn->close();
  }

  /**
   *
   * Comments
   *
   * @param
   * @param
   * @return
   */
  function deleteChromebook($chromebookAsset) {
    $conn = getConnection();

    $asset = $chromebookAsset["original-asset"];
    $studentQuery = $conn->query("SELECT * FROM students WHERE Asset = $asset");
    $classroomQuery = $conn->query("SELECT * FROM locations WHERE Asset = $asset");

    if($conn->query("DELETE FROM chromebooks WHERE asset = $asset")) {
      if($studentQuery->num_rows) {
        $conn->query("DELETE FROM students WHERE Asset = $asset");
      }
      else {
        $conn->query("DELETE FROM locations WHERE Asset = $asset");
      }
      echo("CHROMEBOOK DELETED");
    }
    else {
      echo("CHROMEBOOK DELETE FAIL");
    }

    $conn->close();
  }

  /**
   *
   * Comments
   *
   * @param
   * @param
   * @return
   */
  function printRooms($toggleAllOption) {
    $schools = array("marshall", "fremont", "malaga");
    $roomCount = 1;
    for($schoolCount = 0; $schoolCount < count($schools); $schoolCount++) {
      echo("<select id='$schools[$schoolCount]-rooms'
                    name='$schools[$schoolCount]-rooms') class='rooms'>");
      if($toggleAllOption) {
        echo("<option value='*'> All </option>");
      }
      for($roomCount = 1; $roomCount < 26; $roomCount++) {
        echo("<option value='$roomCount'> $roomCount </option>");
      }
      echo("</select>");
    }
  }

  /**
   *
   * Comments
   *
   * @param
   * @param
   * @return
   */
  function addChromebook($chromebookData, $insuranceSelected) {
    $conn = getConnection();
    $asset = $chromebookData["asset-field"];
    $serial = $chromebookData["serial-field"];
    $model = $chromebookData["model-select"];
    $school = $chromebookData["school-options"];
    $room = $chromebookData["$school-rooms"];
    $status = $chromebookData["edit-physical-status-select"];
    $assignment = $chromebookData["edit-assignment-status-select"];
    $student = $chromebookData["student-id"];

    // Check to see if the chromebook is already in database
    if(chromebookExists($asset)) {

      return -1;
    }

    // Add chromebook to chromebooks table and change assignment to student
    if($room == "student") {
      $room = 0;
      $conn->query("INSERT INTO chromebooks VALUES ($asset, \"$serial\", \"$model\", \"$status\", \"$assignment\", null)");
      echo $conn->error;

      // If we are assiging to student also, update the students table
      if("$assignment" == "assigned") {
        if($insuranceSelected) {
          $insurance = "Y";
          $amount = -250;
        }
        else {
          $amount = 0;
          $insurance = "N";
        }
        $studentQuery = $conn->query("SELECT * FROM students WHERE Student_ID = $student");
        if($studentQuery->num_rows == 1) {
          $conn->query("UPDATE students SET Asset = $asset WHERE Student_ID = $student");
        }
        else {
          $conn->query("INSERT INTO students VALUES ($asset, $student, $amount, \"$insurance\")");
        }
      }
      if("$assignment" == "unassigned") {
        $conn->query("INSERT INTO chromebooks VALUES ($asset, \"$serial\", \"$model\", \"$status\", \"$assignment\", null)");
        echo $conn->error;
      }
    }
    if("$assignment" == "classroom" || "$assignment" == "loaner") {
      $conn->query("INSERT INTO chromebooks VALUES ($asset, \"$serial\", \"$model\", \"$status\", \"$assignment\", null)");
      echo $conn->error;
      $conn->query("INSERT INTO locations VALUES (\"$school\", $room, $asset)");
      echo $conn->error;
    }

    $conn->close();
  }

  /**
   *
   * Comments
   *
   * @param
   * @param
   * @return
   */
  function submitRepairRequest($formFields) {
    $conn = getConnection();
    $asset = $formFields["asset-repair-field"];
    $damage = $formFields["repair-type-select"];
    $cost = $formFields["repair-cost"];
    $date = $formFields["repair-submit-date"];

    $updateOne = $conn->query("UPDATE chromebooks SET
                               Physical_Status = 'Damaged'
                               WHERE Asset = $asset");

    $updateTwo = $conn->query("INSERT INTO damages VALUES
                               (\"$damage\", $cost, \"$date\", $asset, 'N')");

    if($updateOne && $updateTwo) {
      echo("REPAIR SUBMITTED");
    }
    else {
      echo($conn->connect_error);
    }

    $conn->close();
  }

  /**
   *
   * Comments
   *
   * @param
   * @param
   * @return
   */
  function calculateCost($damageString) {
    if(damageString == "Broken Screen") {
      $cost = 20;
    }
    if(damageString == "Broken Keyboard") {
      $cost = 50;
    }
    return $cost;
  }

  /**
   *
   * Comments
   *
   * @param
   * @param
   * @return
   */
  function completeRepair($repairUpdates) {
    $conn = getConnection();
    $asset = $repairUpdates["asset"];
    $damage = $repairUpdates["damage"];
    $previousDamage = $conn->query("SELECT Previous_Damage FROM chromebooks
                                    WHERE Asset = $asset");
    $previousDamage = $previousDamage->fetch_assoc();

    if($repairUpdates["assignment"] == "Student") {
      $studentID = $repairUpdates["location"];
      $cost = $repairUpdates["cost"];
      $conn->query("UPDATE students SET Amount = Amount + $cost
                    WHERE Student_ID = $studentID");
    }
    $conn->query("UPDATE chromebooks SET Physical_Status = 'Good'
                  WHERE Asset = $asset");

    if($previousDamage["Previous_Damage"] == null) {
      $conn->query("UPDATE chromebooks SET Previous_Damage = '$damage, '
                    WHERE Asset = $asset");
    }
    else {
      $conn->query("UPDATE chromebooks SET Previous_Damage =
                    concat(Previous_Damage, '$damage, ') WHERE Asset = $asset");
    }
    $conn->query("DELETE from damages WHERE Asset = $asset");
    echo $conn->connect_error;
    echo("<p style='text-align:center;'> REPAIR COMPELTE </p>");

    $conn->close();
  }

  /**
   *
   * Comments
   *
   * @param
   * @param
   * @return
   */
  function assignChromebook($insuranceBoolean) {

  }

 ?>
