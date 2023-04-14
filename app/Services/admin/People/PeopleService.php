<?php

namespace App\Services\Admin\People;

use App\Models\Contact;
use App\Models\People;
use Exception;
use Illuminate\Support\Facades\DB;

class PeopleService
{
    public function store($dataPeople, $dataContact, $idUser)
    {
        try {
            DB::beginTransaction();
            $dataPeople['user_id'] = $idUser;
            $validateDocument = $this->_validateDocument($dataPeople['document']);

            if (isset($validateDocument))
                return $validateDocument;

            People::create($dataPeople);
            $people = People::latest()->first();

            if (isset($dataContact['fone'])) {
                $auxContact['people_id'] = $people->id;
                $auxContact['user_id'] = $idUser;
                $validate = $this->_saveContact($dataContact, $auxContact, $people->id);
                if ($validate['type'] == 'error')
                    return $validate;
            }

            DB::commit();
            return [
                'type' => 'success',
                'message' => "Pessoa registrada com sucesso!"
            ];
        } catch (Exception $ex) {
            DB::rollBack();
            return [
                'type' => 'error',
                'message' => 'Ops! Ocorreu um erro ao salvar: ' . $ex->getMessage()
            ];
        }
    }

    private function _validateDocument($document, $id = null)
    {
        if (!validateCPF($document)) {
            return [
                'type' => 'error',
                'message' => 'Documento informado está incorreto!'
            ];
        }

        if (People::existDocument($document, $id)) {
            return [
                'type' => 'error',
                'message' => 'Número de documento já existe! Informe outro!'
            ];
        }
    }

    public function update($people, $dataPeople, $dataContact, $idUser)
    {
        try {
            $validateDocument = $this->_validateDocument($dataPeople['document'], $people->id);
            if (isset($validateDocument))
                return $validateDocument;

            $people->update($dataPeople);

            Contact::where('people_id', $people->id)->delete();

            if (isset($dataContact['fone'])) {
                $auxContact['people_id'] = $people->id;
                $auxContact['user_id'] = $idUser;
                $validate = $this->_saveContact($dataContact, $auxContact);

                if (isset($validate['type']))
                    return $validate;
            }

            return [
                'type' => 'success',
                'message' => "Pessoa alterada com sucesso!"
            ];
        } catch (Exception $ex) {
            return [
                'type' => 'error',
                'message' => 'Ops! Ocorreu um erro ao alterar: ' . $ex->getMessage()
            ];
        }
    }

    private function _saveContact($dataContact, $auxContact, $id = null)
    {
        foreach ($dataContact['fone'] as $fone) {
            if (!isset($fone))
                continue;

            if ($validateContact =  $this->_validateContact($fone, $id)) {
                return $validateContact;
            }
            $auxContact['fone'] = $fone;
            Contact::create($auxContact);
        }
    }

    private function _validateContact($contact, $id)
    {
        $fone = Contact::existContact($contact, $id);
        if ($fone) {
            return [
                'type' => 'error',
                'message' => 'Número de contato já existe! Informe outro!'
            ];
        }
    }

    public function destroy($people)
    {
        try {
            if (Contact::where('people_id', $people->id)->get()->count() > 0) {
                return [
                    'type' => 'error',
                    'message' => 'Não é possível excluir Pessoa que possui contatos!'
                ];
            }

            $people->delete();

            return [
                'type' => 'success',
                'message' => "Pessoa excluída com sucesso!"
            ];
        } catch (Exception $ex) {
            return [
                'type' => 'error',
                'message' => 'Ops! Ocorreu um erro ao salvar: ' . $ex->getMessage()
            ];
        }
    }
}
