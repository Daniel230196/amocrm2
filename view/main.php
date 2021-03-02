<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../resources/style.css">
    <title>Document</title>
</head>
<body>
<form action="apiRequest/create" name="add">
    <h3>Add Entities</h3>
    <label for="count"> Select count of entities (1 - 10000)</label>
    <input type="number" name="count">
    <input type="submit" id="count">
    <div id="alert" class="none">
    </div>
</form>
<form action="apiRequest/text">
    <h3>Add a text</h3>
    <label for="id">EntityID</label>
    <input type="number" name="id">
    <label for="type">Entity type</label>
    <select name="type">
        <option value="leads">leads</option>
        <option value="companies">companies</option>
        <option value="contacts">contacts</option>
        <option value="customers">customers</option>
    </select>
    <label for="data">Text</label>
    <textarea name="data"  cols="30" rows="1"></textarea>
    <input type="submit">
</form>
<form action="apiRequest/note">
    <h3> Add a note </h3>
    <label for="id">Entity ID</label>
    <input type="number" name="id">
    <label for="noteType">Note type</label>
    <select name="noteType">
        <option value="call_in">incoming call</option>
        <option value="common">Text note</option>
    </select>
    <label for="entityType">Entity type</label>
    <select name="entityType">
        <option value="companies">Company</option>
        <option value="leads">Lead</option>
        <option value="customers">Customer</option>
        <option value="contacts">Contact</option>
    </select>
    <input type="submit">
</form>
<form action="apiRequest/task">
    <h3>Add a task</h3>
    <label for="entity">Entity ID</label>
    <input type="number" name="entity">
    <label for="type">Entity type</label>
    <select name="type">
        <option value="companies">Company</option>
        <option value="leads">Lead</option>
        <option value="customers">Customer</option>
        <option value="contacts">Contact</option>
    </select>
    <label for="text">Task text</label>
    <textarea name="text"  cols="30" rows="1"></textarea>
    <label for="time">Complete Till</label>
    <input type="date" name="time">
    <label for="user">Responsible user ID</label>
    <input type="number" name="user">
    <input type="submit">
</form>
<form action="apiRequest/taskComplete">
    <h3>Complete task by ID</h3>
    <label for="id">Task id</label>
    <input type="number" name="id">
    <label for="result">Result</label>
    <input type="text" name="result">
    <input type="submit">
</form>
<form action="">
    <input id="test" type="submit">
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../resources/script.js"></script>
</body>
</html>