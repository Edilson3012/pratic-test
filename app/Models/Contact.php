<?php

namespace App\Models;

use App\Traits\Uuid;

class Contact extends EsferaModel
{
    use Uuid;

    protected $fillable = [
        'fone', 'people_id', 'user_id'
    ];

    public static function existContact($fone, $id = null)
    {
        if (isset($id)) {
            $contact = Self::where('fone', $fone)->where('id', '<>', $id)->select('fone')->first();
        } else {
            $contact = Self::where('fone', $fone)->select('fone')->first();
        }

        return isset($contact);
    }
}
