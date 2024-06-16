<?php

function hashPassword($password, $usuario) {
    $options = [
      'cost' => 12, // Ajustar el costo de acuerdo a la necesidad
    ];
    return password_hash($password, PASSWORD_BCRYPT, $options);
  }

  function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
  }

?>