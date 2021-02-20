<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="apiRequest/create">
    <h3>Add Entities</h3>
    <label for="count"> Select count of entities (1 - 10000)</label>
    <input type="number" name="count">
    <input type="submit">
</form>
<form action="apiRequest/text">
    <h3>Add a text</h3>
    <label for="data">Text</label>
    <textarea name="data"  cols="30" rows="5"></textarea>
    <label for="type">Choose a type of entity:</label>
    <select name="type">
        <option value="leads">lead</option>
        <option value="companies">company</option>
        <option value="contacts">contact</option>
        <option value="customer">customer</option>
    </select>
    <label for="id">EntityID</label>
    <input type="number" name="id">
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
    <select name="entityType">
        <option value="companies">Company</option>
        <option value="leads">Lead</option>
        <option value="customers">Customer</option>
        <option value="contacts">Contact</option>
    </select>
    <input type="submit">
</form>
<script>

</script>
</body>
</html>