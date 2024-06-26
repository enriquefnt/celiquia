<?php

namespace ClassGrl;

class Authentication
{

	public function __construct(private DataTables $users, private string $usernameColumn, private string $passwordColumn)
	{
		session_start();
	}


	public function login(string $username, string $password): bool
	{

		$user = $this->users->find($this->usernameColumn, strtolower($username));

		if (!empty($user) && password_verify($password, $user[0][$this->passwordColumn])) {
			session_regenerate_id();

			$_SESSION['username'] = $username;
			$_SESSION['password'] = $user[0][$this->passwordColumn];
			$_SESSION['inicio'] = time();

			return true;
		} else {
			return false;
		}
	}

	public function isLoggedIn(): bool
	{
		if (empty($_SESSION['username'])) {
			return false;
		}
		$user = $this->users->find($this->usernameColumn, strtolower($_SESSION['username']));

		if (!empty($user) && $user[0][$this->passwordColumn] === $_SESSION['password']) {
			return true;
		} else {
			return false;
		}
	}


	public function getUser(): ?array
	{
		if ($this->isLoggedIn()) {
			$user = $this->users->find($this->usernameColumn, strtolower($_SESSION['username']))[0];
			return $user;
		} else {
			return false;
		}
	}




	public function logout()
	{
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		unset($_SESSION['tipo']);
		session_regenerate_id();
	}
}
