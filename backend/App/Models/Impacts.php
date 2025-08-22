<?php

namespace App\Models;

use App\Core\App;

class Impacts
{
    function search($query)
    {
        $stm = App::db()->prepare("SELECT * FROM impacts WHERE image LIKE :q");
        $stm->execute(['q' => "%$query%"]);
        return $stm->fetchAll();
    }

    function countImpacts()
    {
        $stm = App::db()->prepare("SELECT COUNT(*) FROM impacts");
        $stm->execute();
        return $stm->fetchColumn();
    }

    function all()
    {
        $stm = App::db()->prepare("SELECT * FROM impacts");

        $stm->execute();

        return $stm->fetchAll();
    }

    function find($id)
    {
        $stm = App::db()->prepare("SELECT * FROM impacts WHERE id=:id");
        $stm->execute(['id' => $id]);
        return $stm->fetch();
    }

    function create($title, $image, $content)
    {
        $stm = App::db()->prepare("INSERT INTO impacts(title, image, content) VALUES (:title, :image, :content)");
        $stm->execute(['title' => $title, 'image' => $image, 'content' => $content]);
        $id = App::db()->lastInsertId();
        return $this->find($id);
    }

    function update($id, $title, $image, $content = null)
    {
        $stm = App::db()->prepare("UPDATE impacts SET title=:title, image=:image, content=:content WHERE id = :id");
        $stm->execute(['id' => $id, 'title' => $title, 'image' => $image, 'content' => $content]);
    }

    function delete($id)
    {
        $stm = App::db()->prepare("DELETE FROM impacts WHERE id=:id");
        $stm->execute(['id' => $id]);
    }
}
