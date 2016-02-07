<?php
ini_set('display_errors', 'On');

function redirect($page)
{
  header('Location: ' . $page);
  exit();
}
?>
