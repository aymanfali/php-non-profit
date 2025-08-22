<?php

namespace App\Models;

use App\Core\App;

class About
{
    function find($id)
    {
        $stm = App::db()->prepare("SELECT * FROM about_us WHERE id=:id");
        $stm->execute(['id' => $id]);
        return $stm->fetch();
    }

    function update($id, $ourHistory, $ourHistoryImage, $ourValues, $ourValuesImage)
    {
        $stm = App::db()->prepare("UPDATE about_us SET our_history=:our_history, our_history_image=:our_history_image, our_values=:our_values, our_values_image=:our_values_image WHERE id = :id");
        $stm->execute([
            'id' => $id,
            'our_history' => $ourHistory,
            'our_history_image' => $ourHistoryImage,
            'our_values' => $ourValues,
            'our_values_image' => $ourValuesImage
        ]);
    }
}
