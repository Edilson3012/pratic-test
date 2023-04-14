<?php

namespace App\Models;

use App\Traits\Uuid;

class People extends EsferaModel
{
    use Uuid;

    protected $fillable = [
        'name', 'document', 'user_id'
    ];

    public static function existDocument($document, $id = null)
    {
        if (isset($id)) {
            $documento = Self::where('document', $document)->where('id', '<>', $id)->select('document')->first();
        } else {
            $documento = Self::where('document', $document)->select('document')->first();
        }

        return isset($documento);
    }

    public static function search($filter = null)
    {
        $results = Self::where('name', 'LIKE', "%{$filter}%")->get();
        return $results;
    }
}
