<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <title>Editing entry</title>
  </head>
  <body>
    <h3>Add/Edit Shopping list entry</h3>
    <form action="/shoppinglist/edit/<?php echo $id; ?>" method="POST">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <input type="text" name="name" value="<?php echo $name; ?>">
      <button type="submit">Save</button>
    </form>
  </body>
</html>
