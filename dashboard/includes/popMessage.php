<?php if(isset($_SESSION['message'])): ?>
  <script type="text/javascript">
    function showMessage(){
      var type = '<?php print $_SESSION['message']['type']; ?>'
      var title = '<?php print $_SESSION['message']['title']; ?>'
      var message = '<?php print $_SESSION['message']['message']; ?>'
      Swal.fire({
        icon: type,
        title: title,
        text: message,
        showConfirmButton: false,
        timer: 2000,
        width: 350
      });
    }
  </script>
<?php endif; ?>