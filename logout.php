<?php
require 'config/constants.php';

//destroy the previous sessions and redirect the user to the login page
session_destroy();
header('location: ' . ROOT_URL);
die();
