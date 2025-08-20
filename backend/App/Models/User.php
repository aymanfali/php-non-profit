<?php

namespace App\Models;

use App\Core\App;

class User
{
    function search($query)
    {
        $stm = App::db()->prepare("SELECT * FROM users WHERE email LIKE :q");
        $stm->execute(['q' => "%$query%"]);
        return $stm->fetchAll();
    }

    function all()
    {
        $stm = App::db()->prepare("SELECT * FROM users");

        $stm->execute();

        return $stm->fetchAll();
    }

    function find($id)
    {
        $stm = App::db()->prepare("SELECT * FROM users WHERE id=:id");
        $stm->execute(['id' => $id]);
        return $stm->fetch();
    }

    function create($name, $email, $role = null, $password)
    {
        if ($role === null) {
            $stm = App::db()->prepare("INSERT INTO users(name, email, password) VALUES (:name, :email, :password)");
            $stm->execute(['name' => $name, 'email' => $email, 'password' => $password]);
        } else {
            $stm = App::db()->prepare("INSERT INTO users(name, email, role, password) VALUES (:name, :email, :role, :password)");
            $stm->execute(['name' => $name, 'email' => $email, 'role' => $role, 'password' => $password]);
        }
    }

    function findByEmail($email)
    {
        $stm = App::db()->prepare("SELECT * FROM users WHERE email=:email");
        $stm->execute(['email' => $email]);
        return $stm->fetch();
    }

    function update($id, $name, $email, $role, $password = null)
    {
        if ($password) {
            $stm = App::db()->prepare("UPDATE users SET name=:name, email=:email, role=:role, password=:password WHERE id = :id");
            $stm->execute(['id' => $id, 'name' => $name, 'email' => $email, 'role' => $role,'password' => $password]);
        } else {
            $stm = App::db()->prepare("UPDATE users SET name=:name, email=:email, role=:role WHERE id = :id");
            $stm->execute(['id' => $id, 'name' => $name, 'email' => $email, 'role' => $role]);
        }
    }

    function delete($id)
    {
        $stm = App::db()->prepare("DELETE FROM users WHERE id=:id");
        $stm->execute(['id' => $id]);
    }
}
