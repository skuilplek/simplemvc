<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <title>Browsing the shopping list entries</title>
  </head>
    <h3>Shopping list entries</h3>
    <a href="/shoppinglist/edit/0">[ADD NEW]</a>
    <table width="100%" border="1">
          <tr style="font-weight:bold;"><td>#</td><td>Entry</td><td>Checked</td><td>Action</td></tr>
      <?php
    foreach ($entries as $entry) {
      $delete = '<a href="/shoppinglist/delete/' . $entry['id'] . '">[DELETE]</a>';
      $edit = '<a href="/shoppinglist/edit/' . $entry['id'] . '">[EDIT]</a>';
      $check = '<a href="/shoppinglist/check/'.$entry['id'].'">[CHECK]</a>';
      if($entry['checked'] > 0)
        $check = '<a href="/shoppinglist/check/'.$entry['id'].'">[UNCHECK]</a>';
      echo '<tr ><td>' . $entry['id'] . '</td><td>' . $entry['name'] . '</td><td>' . (($entry['checked'] < 1) ? 'No' : 'Yes').'</td>
      <td>
      '.$edit.' ' . $check . ' '.$delete.'
      </td>
      </tr>';
        }
      ?>
      </table>
  </body>
</html>
