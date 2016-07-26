<!DOCTYPE html>
<html>
  <head>
    <base href="<?php echo $_GET['path']; ?>" />
    <script src="aframe.js"></script>
  </head>
  <body>
    <a-scene>
      <a-sky src="<?php echo $_GET['src']; ?>" rotation="0 -130 0"></a-sky>
    </a-scene>
  </body>
</html>
