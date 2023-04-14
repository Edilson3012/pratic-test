@if (isset($contacts))
    @foreach ($contacts as $key => $contact)
        <div class="form-group col-md-4 contact-{{ $contact->id }}" style="margin-top: 5px;">
            <input type="text" name="fone[{{ $contact->id }}]" class="form-control fone fone-{{ $contact->id }}"
                placeholder="(00) 00000-0000" value="{{ $contact->fone }}"> &nbsp;
            <button type="button" class="btn btn-danger" onclick="delContact('{{ $contact->id }}')"> <i
                    class="fas fa-trash-alt"></i>
            </button>
        </div>
    @endforeach
@endif
