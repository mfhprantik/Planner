<?php
require_once('Settings/config.php');
session_start();

$verified = 1;

if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
	$email = $_SESSION['email'];
	$password = $_SESSION['password'];

	$sql = "SELECT COUNT(*) FROM `user` WHERE `email`='" . $email . "' AND `password`='" . $password . "' LIMIT 1";
	$result = $conn->query($sql);
	$value = $result->fetch_assoc();

	if ($value['COUNT(*)'] == 0) {
		unset($_SESSION);
		$verified = 0;
	} else {
		$verified = 1;
	}
} else {
	$verified = 0;
}