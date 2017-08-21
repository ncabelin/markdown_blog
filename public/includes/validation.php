<?php
  function validateFormData($formData) {
    $formData = trim(stripslashes(htmlspecialchars($formData)));
    return $formData;
  }
?>
