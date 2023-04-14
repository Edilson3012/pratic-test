<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Http\Requests\StorePeopleRequest;
use App\Http\Requests\UpdatePeopleRequest;
use App\Models\Contact;
use App\Services\Admin\People\PeopleService;
use Exception;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    protected $service;

    public function __construct(PeopleService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $peoples = People::where('user_id', $this->getIdUser())->get();

        return view('admin.people.index', [
            'peoples' => $peoples
        ]);
    }

    public function create()
    {
        return view('admin.people.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePeopleRequest  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    public function store(StorePeopleRequest $request)
    {
        try {
            $dataPeople = $request->only('name', 'document');

            $dataContact = $request->only('fone');

            $service = $this->service->store($dataPeople, $dataContact, $this->getIdUser());

            if ($service['type'] == 'error')
                return redirect()->back()->with(['type' => $service['type'], 'message' => $service['message']]);

            return redirect()->route('people.index')->with(['type' => $service['type'], 'message' => $service['message']]);
        } catch (Exception $ex) {
            return redirect()->back()->with(['type' => 'error', 'message' => 'Ops! Ocorreu um erro ao salvar: ' . $ex->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $people = People::find($id);

            $contacts = Contact::where('people_id', $people->id)->get();

            return view('admin.people.show', [
                'people' => $people,
                'contacts' => $contacts
            ]);
        } catch (Exception $ex) {
            return redirect()->back()->with(['type' => 'error', 'message' => "Ocorreu um erro ao salvar: " . $ex->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $people = People::find($id);

            if (!$people)
                return redirect()->back()->with(['error' => 'Registro não encontrado.']);

            $contacts = Contact::where('people_id', $people->id)->select(['id', 'fone'])->get();

            return view('admin.people.edit', [
                'people' => $people,
                'contacts' => $contacts,
            ]);
        } catch (Exception $ex) {
            return redirect()->back()->with(['type' => 'error', 'message' => "Ocorreu um erro ao salvar: " . $ex->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePeopleRequest  $request
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePeopleRequest $request, $id)
    {
        try {
            $people = People::find($id);

            if (!$people)
                return redirect()->back()->with(['error' => 'Registro não encontrado.']);

            $dataPeople = $request->only('name', 'document');
            $dataContact = $request->only('fone');

            $service = $this->service->update($people, $dataPeople, $dataContact, $this->getIdUser());

            if ($service['type'] == 'error')
                return redirect()->back()->with(['type' => $service['type'], 'message' => $service['message']]);


            return redirect()->route('people.index')->with(['type' => $service['type'], 'message' => $service['message']]);
        } catch (Exception $ex) {
            return redirect()->back()->with(['type' => $service['type'], 'message' => "Ocorreu um erro ao salvar: " . $ex->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $people = People::find($id);

            if (!$people)
                return response()->json(['type' => 'error', 'message' => 'Registro não encontrado.']);

            $service = $this->service->destroy($people);

            return response()->json(['type' => $service['type'], 'message' => $service['message']]);
        } catch (Exception $ex) {
            return redirect()->json(['type' => $service['type'], 'message' => 'Ops, ocorreu um erro: ' . $ex->getMessage()]);
        }
    }

    public function search(Request $request)
    {
        $filters = $request->except('_token');

        $peoples = People::search($request->filter);

        return view('admin.people.index', [
            'peoples' => $peoples,
        ]);
    }
}
