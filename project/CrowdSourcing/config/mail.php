<?php
return [
  "driver" => "smtp",
  "host" => "smtp.gmail.com",
  "port" => 587,
  'encryption' => 'tls',
  "from" => array(
      "address" => "testlaravelphp123@gmail.com",
      "name" => "Laravel"
  ),
  "username" => "testlaravelphp123@gmail.com",
  "password" => "Laravel123",
  "sendmail" => "/usr/sbin/sendmail -bs"
];?>
