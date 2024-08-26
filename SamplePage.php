<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Sample Page</h1>
<?php

  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);

  VerifyEmployeesTable($connection, DB_DATABASE);
  VerifyDepartmentsTable($connection, DB_DATABASE);
  VerifyProjectsTable($connection, DB_DATABASE);

  $employee_name = htmlentities($_POST['NAME']);
  $employee_address = htmlentities($_POST['ADDRESS']);
  $department_name = htmlentities($_POST['DEPT_NAME']);
  $dept_date_established = htmlentities($_POST['DATE_ESTABLISHED']);
  $project_name = htmlentities($_POST['PROJECT_NAME']);
  $project_budget = htmlentities($_POST['BUDGET']);
  $project_start_date = htmlentities($_POST['START_DATE']);
  $project_manager = htmlentities($_POST['MANAGER']);

  if (strlen($employee_name) || strlen($employee_address)) {
    AddEmployee($connection, $employee_name, $employee_address);
  }

  if (strlen($department_name) || strlen($dept_date_established)) {
    AddDepartment($connection, $department_name, $dept_date_established);
  }

  if (strlen($project_name) || strlen($project_budget) || strlen($project_start_date) || strlen($project_manager)) {
    AddProject($connection, $project_name, $project_budget, $project_start_date, $project_manager);
  }
?>

<h2>Add Employee</h2>
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>NAME</td>
      <td>ADDRESS</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="NAME" maxlength="45" size="30" />
      </td>
      <td>
        <input type="text" name="ADDRESS" maxlength="90" size="60" />
      </td>
      <td>
        <input type="submit" value="Add Employee" />
      </td>
    </tr>
  </table>
</form>

<h2>Add Department</h2>
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>DEPT_NAME</td>
      <td>DATE_ESTABLISHED</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="DEPT_NAME" maxlength="50" size="30" />
      </td>
      <td>
        <input type="date" name="DATE_ESTABLISHED" />
      </td>
      <td>
        <input type="submit" value="Add Department" />
      </td>
    </tr>
  </table>
</form>

<h2>Add Project</h2>
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>PROJECT_NAME</td>
      <td>BUDGET</td>
      <td>START_DATE</td>
      <td>MANAGER</td>
    </tr>
    <tr>
      <td><input type="text" name="PROJECT_NAME" maxlength="100" size="30" /></td>
      <td><input type="number" name="BUDGET" maxlength="10" size="10" /></td>
      <td><input type="date" name="START_DATE" /></td>
      <td><input type="text" name="MANAGER" maxlength="45" size="30" /></td>
      <td><input type="submit" value="Add Project" /></td>
    </tr>
  </table>
</form>

<h2>Employees</h2>
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>NAME</td>
    <td>ADDRESS</td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>";
  echo "</tr>";
}

?>

</table>

<h2>Departments</h2>
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>DEPT_NAME</td>
    <td>DATE_ESTABLISHED</td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT * FROM DEPARTMENTS");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>";
  echo "</tr>";
}

?>

</table>

<h2>Projects</h2>
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>PROJECT_NAME</td>
    <td>BUDGET</td>
    <td>START_DATE</td>
    <td>MANAGER</td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT * FROM PROJECTS");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>",
       "<td>",$query_data[3], "</td>",
       "<td>",$query_data[4], "</td>";
  echo "</tr>";
}

mysqli_free_result($result);
mysqli_close($connection);

?>

</table>

<?php

function AddEmployee($connection, $name, $address) {
   $n = mysqli_real_escape_string($connection, $name);
   $a = mysqli_real_escape_string($connection, $address);

   $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS) VALUES ('$n', '$a');";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
}

function AddDepartment($connection, $dept_name, $date_established) {
   $d_name = mysqli_real_escape_string($connection, $dept_name);
   $d_date = mysqli_real_escape_string($connection, $date_established);

   $query = "INSERT INTO DEPARTMENTS (DEPT_NAME, DATE_ESTABLISHED) VALUES ('$d_name', '$d_date');";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding department data.</p>");
}

function AddProject($connection, $name, $budget, $start_date, $manager) {
   $p_name = mysqli_real_escape_string($connection, $name);
   $p_budget = mysqli_real_escape_string($connection, $budget);
   $p_start_date = mysqli_real_escape_string($connection, $start_date);
   $p_manager = mysqli_real_escape_string($connection, $manager);

   $query = "INSERT INTO PROJECTS (PROJECT_NAME, BUDGET, START_DATE, MANAGER) VALUES ('$p_name', '$p_budget', '$p_start_date', '$p_manager');";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding project data.</p>");
}

function VerifyEmployeesTable($connection, $dbName) {
  if(!TableExists("EMPLOYEES", $connection, $dbName))
  {
     $query = "CREATE TABLE EMPLOYEES (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         NAME VARCHAR(45),
         ADDRESS VARCHAR(90)
       )";

     if(!mysqli_query($connection, $query)) echo("<p>Error creating EMPLOYEES table.</p>");
  }
}

function VerifyDepartmentsTable($connection, $dbName) {
  if(!TableExists("DEPARTMENTS", $connection, $dbName))
  {
     $query = "CREATE TABLE DEPARTMENTS (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         DEPT_NAME VARCHAR(50),
         DATE_ESTABLISHED DATE
       )";

     if(!mysqli_query($connection, $query)) echo("<p>Error creating DEPARTMENTS table.</p>");
  }
}

function VerifyProjectsTable($connection, $dbName) {
  if(!TableExists("PROJECTS", $connection, $dbName))
  {
     $query = "CREATE TABLE PROJECTS (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         PROJECT_NAME VARCHAR(100),
         BUDGET DECIMAL(10, 2),
         START_DATE DATE,
         MANAGER VARCHAR(45)
       )";

     if(!mysqli_query($connection, $query)) echo("<p>Error creating PROJECTS table.</p>");
  }
}

function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;

  return false;
}
?>
