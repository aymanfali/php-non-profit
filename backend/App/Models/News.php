<?php

namespace App\Models;

use App\Core\App;

class News
{
    function search($query)
    {
        $stm = App::db()->prepare("SELECT * FROM news WHERE image LIKE :q");
        $stm->execute(['q' => "%$query%"]);
        return $stm->fetchAll();
    }

    function all()
    {
        $stm = App::db()->prepare("SELECT * FROM news");

        $stm->execute();

        return $stm->fetchAll();
    }

    function find($id)
    {
        $stm = App::db()->prepare("SELECT * FROM news WHERE id=:id");
        $stm->execute(['id' => $id]);
        return $stm->fetch();
    }

    function create($title, $image, $content)
    {
    $stm = App::db()->prepare("INSERT INTO news(title, image, content) VALUES (:title, :image, :content)");
    $stm->execute(['title' => $title, 'image' => $image, 'content' => $content]);
    $id = App::db()->lastInsertId();
    return $this->find($id);
    }

    function update($id, $title, $image, $content = null)
    {
        $stm = App::db()->prepare("UPDATE news SET title=:title, image=:image, content=:content WHERE id = :id");
        $stm->execute(['id' => $id, 'title' => $title, 'image' => $image, 'content' => $content]);
    }

    function delete($id)
    {
        $stm = App::db()->prepare("DELETE FROM news WHERE id=:id");
        $stm->execute(['id' => $id]);
    }
}
