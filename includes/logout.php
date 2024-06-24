<?php

$_SESSION = [];
session_write_close();
session_unset();
session_destroy();

header('Location: login/home');
