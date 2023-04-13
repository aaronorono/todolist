<?php
// initialize errors variable
$errors = "";

// connect to database
$db = mysqli_connect("localhost", "root", "", "todo");

// insert a quote if submit button is clicked
if (isset($_POST['submit'])) {
    if (empty($_POST['task'])) {
        $errors = print "You must fill in the task";
    } else {
        $task = $_POST['task'];
        $sql = "INSERT INTO tasks (task) VALUES ('$task')";
        mysqli_query($db, $sql);
        header('location: index.php');
    }
}// Edit an existing task
if (isset($_POST['edit_task'])) {
    $id = mysqli_real_escape_string($db, $_POST['id']);
    $task = mysqli_real_escape_string($db, $_POST['task']);
    $query = "UPDATE `tasks` SET `id`='[value-1]',`task`='[value-2]' WHERE 1";
    $result = mysqli_query($db, $query);
    if ($result) {
        echo "Task edited successfully!";
    } else {
        echo "Error editing task: " . mysqli_error($db);
    }
}


if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];

    mysqli_query($db, "DELETE FROM tasks WHERE id=" . $id);
    header('location: index.php');
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TO DO List App</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="heading">
        <h2 style="font-style: 'TimesNewsRoman';">My ToDo List Application</h2>
    </div>
    <form method="post" action="index.php" class="input_form">
        <input type="text" name="task" class="task_input">
        <button type="submit" name="submit" id="add_btn" class="add_btn" required >Add Task</button>
    </form>
    <table>
        <thead>
            <tr>
                <th style="text-align:left ;">No.</th>
                <th>Tasks</th>
                <th  colspan="2" style="text-align:center;">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
            // select all tasks if page is visited or refreshed
            $tasks = mysqli_query($db, "SELECT * FROM tasks");

            $i = 1;
            while ($row = mysqli_fetch_array($tasks)) { ?>
                <tr>
                    <td> <?php echo $i; ?> </td>
                    <td class="task"> <?php echo $row['task']; ?> </td>
                    <td class="delete">
                        <a href="index.php?del_task=<?php echo $row['id'] ?>">x</a>
                    </td>
                    <td class="edit">
                        <a href="index.php?edit_task=<?php echo $row['id'] ?>">edit</a>
                    </td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>
    <?php if (isset($errors)) { ?>
        <p><?php echo $errors; ?></p>
    <?php } ?>
</body>

</html>