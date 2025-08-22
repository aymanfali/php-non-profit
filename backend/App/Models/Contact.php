<?php

namespace App\Models;

use App\Core\App;

class Contact
{
    function search($query)
    {
        $stm = App::db()->prepare("SELECT * FROM contacts WHERE subject LIKE :q");
        $stm->execute(['q' => "%$query%"]);
        return $stm->fetchAll();
    }

    function countMessages()
    {
        $stm = App::db()->prepare("SELECT COUNT(*) FROM contacts");
        $stm->execute();
        return $stm->fetchColumn();
    }

    function all()
    {
        $stm = App::db()->prepare("SELECT * FROM contacts");

        $stm->execute();

        return $stm->fetchAll();
    }

    function find($id)
    {
        $stm = App::db()->prepare("SELECT * FROM contacts WHERE id=:id");
        $stm->execute(['id' => $id]);
        return $stm->fetch();
    }

    function create($name, $email, $subject, $message)
    {
        $stm = App::db()->prepare("INSERT INTO contacts(name, email, subject, message) VALUES (:name, :email, :subject, :message)");
        $stm->execute(['name' => $name, 'email' => $email, 'subject' => $subject, 'message' => $message]);
        $id = App::db()->lastInsertId();
        return $this->find($id);
    }

    function delete($id)
    {
        $stm = App::db()->prepare("DELETE FROM contacts WHERE id=:id");
        $stm->execute(['id' => $id]);
    }
}
