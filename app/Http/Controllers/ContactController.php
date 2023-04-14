<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Exception;

class ContactController extends Controller
{
    public function destroy($id)
    {
        try {
            $contact = Contact::find($id);

            if (!$contact)
                return response()->json(['type' => 'error', 'message' => 'Registro não encontrado.']);

            $contact->delete();

            return response()->json(['type' => 'success', 'message' => 'Contato excluido com sucesso!']);
        } catch (Exception $ex) {
            return redirect()->json(['type' => 'error', 'message' => $ex->getMessage()]);
        }
    }
}
