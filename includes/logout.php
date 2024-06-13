<?php

$_SESSION = [];
session_write_close();
session_destroy();

header('Location: login/home');
