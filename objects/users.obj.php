<?php

class Users
{

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login_users()
    {
        $sql = "SELECT id, firstname, lastname, position, role, username, password FROM users WHERE (username=? OR email=?) AND password=?";
        $login_user = $this->conn->prepare($sql);

        $login_user->bindParam(1, $this->username_email);
        $login_user->bindParam(2, $this->username_email);
        $login_user->bindParam(3, $this->password);

        $login_user->execute();
        return $login_user;
    }

    public function check_access()
    {
        $sql = "SELECT count(user_id) AS count FROM access WHERE user_id = ? AND system_id = ? AND status != 0";
        $check_access = $this->conn->prepare($sql);

        $check_access->bindParam(1, $this->user_id);
        $check_access->bindParam(2, $this->system_id);

        $check_access->execute();
        return $check_access;
    }

    public function get_access()
    {
        $sql = "SELECT user_id AS access_user_id, role_id, role FROM access WHERE user_id = ? AND system_id = ? AND status != 0";
        $get_access = $this->conn->prepare($sql);

        $get_access->bindParam(1, $this->user_id);
        $get_access->bindParam(2, $this->system_id);

        $get_access->execute();
        return $get_access;
    }

    public function logout_user()
    {

        session_start();
        if (session_destroy()) {
            unset($_SESSION["id"]);
            unset($_SESSION["firstname"]);
            unset($_SESSION["lastname"]);
            unset($_SESSION["position"]);
            unset($_SESSION["user_name"]);
            unset($_SESSION["access_user_id"]);
            unset($_SESSION["access_role_id"]);
            unset($_SESSION["role"]);
            return true;
        } else {
            return false;
        }
    }

    public function update_profiles()
    {

        $sql = "UPDATE users SET firstname=?, lastname=?, password=? WHERE id=?";
        $update_profile = $this->conn->prepare($sql);

        $update_profile->bindParam(1, $this->firstname);
        $update_profile->bindParam(2, $this->lastname);
        $update_profile->bindParam(3, $this->password);
        $update_profile->bindParam(4, $this->id);

        return ($update_profile->execute()) ? true : false;
    }

    public function get_userPasswords()
    {
        $sql = "SELECT password FROM users WHERE id = ? LIMIT 1";
        $get_userPassword = $this->conn->prepare($sql);

        $get_userPassword->bindParam(1, $this->id);

        $get_userPassword->execute();
        return $get_userPassword;
    }

    public function get_emails()
    {

        $sql = "SELECT * FROM users WHERE email=? AND status != 0";
        $get_emails = $this->conn->prepare($sql);

        $get_emails->bindParam(1, $this->email);

        $get_emails->execute();
        return $get_emails;
    }

    public function email_by_id()
    {

        $sql = "SELECT id FROM users WHERE email = ? AND status != 0";
        $email_by_id = $this->conn->prepare($sql);

        $email_by_id->bindParam(1, $this->email);

        $email_by_id->execute();
        return $email_by_id;
    }

    public function change_password()
    {

        $sql = "UPDATE users SET password=? WHERE id=? AND status != 0";
        $change_password = $this->conn->prepare($sql);

        $change_password->bindParam(1, $this->password);
        $change_password->bindParam(2, $this->id);

        if ($change_password->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function select_users()
    {
        $sql = "SELECT id, concat(firstname, ' ', lastname) AS fullname FROM users WHERE status != 0";
        $select_user = $this->conn->prepare($sql);

        $select_user->execute();
        return $select_user;
    }
}
