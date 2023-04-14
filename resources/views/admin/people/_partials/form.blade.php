<div class="form-group">
    <label for="name">Nome da Pessoa</label>
    <input type="text" name="name" class="form-control" id="name" placeholder="Nome completo"
        value="{{ $people->name ?? null }}">
</div>

<div class="form-group">
    <label for="document">CPF</label>
    <input type="text" name="document" onblur="validationDocument()" class="form-control" id="document"
        placeholder="CPF" value="{{ $people->document ?? null }}">
</div>
