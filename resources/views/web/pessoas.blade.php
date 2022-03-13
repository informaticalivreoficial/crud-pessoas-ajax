@extends('web.master.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 my-5">
            <h1>
                <img width="32" src="{{url(asset('frontend/assets/images/favicon-mario.png'))}}" alt=""> 
                Teste Crud Pessoas
            </h1>
            
            <a class="btn btn-success mb-3" href="javascript:void(0)" id="createNewPessoa"> Cadastrar</a>
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>Gênero</th>
                        <th>Pais</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="pessoaForm" name="pessoaForm" class="form-horizontal">
                   <input type="hidden" name="pessoa_id" id="pessoa_id">
                    <div class="form-group" id="expira">
                        <label for="name" class="col-form-label"><b>Nome</b></label>                        
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" maxlength="50" required="">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"><b>*Data de Nascimento</b></label>
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control nascimento" id="nascimento" name="nascimento"/>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
     
                    <div class="form-group">
                       <label class="col-form-label">Gênero:</label>
                        <select id="genero" name="genero" class="custom-select genero">
                            <option value="Não informado">Não informado</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Pais:</label>
                        <select name="pais_id" class="custom-select pais">
                            @if (!empty($paises) && $paises->count() > 0)
                                @foreach($paises as $pais)
                                    <option value="{{$pais->id}}">{{$pais->nome}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Salvar
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>

<script>
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('web.pessoas.index') }}",
            columns: [
                {data: 'id', name: '#'},                
                {data: 'nome', name: 'nome'},
                {data: 'nascimento', name: 'nascimento'},
                {data: 'genero', name: 'genero'},
                {data: 'pais_id', name: 'pais_id'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createNewPessoa').click(function () {
            $('#saveBtn').val("cadastro");
            $('#pessoa_id').val('');
            $('#pessoaForm').trigger("reset");
            $('#modelHeading').html("Cadastrar Pessoa");
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.editPessoa', function () {
            var pessoa_id = $(this).data('id');
            $.get("{{ route('web.pessoas.index') }}" +'/' + pessoa_id +'/edit', function (data) {
                $('#modelHeading').html("Editar Pessoa");
                $('#saveBtn').val("edit-pessoa");
                $('#ajaxModel').modal('show');
                $('#pessoa_id').val(data.id);
                $('#nome').val(data.nome);
                $('#nascimento').val(data.nascimento);
                $('#genero').val(data.genero);
                $('#pais_id').val(data.pais_id);
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Salvar');
        
            $.ajax({
                data: $('#pessoaForm').serialize(),
                url: "{{ route('web.pessoas.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
            
                    $('#pessoaForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Salvar');
                }
            });
        });

        $('body').on('click', '.deletePessoa', function () {
     
            var pessoa_id = $(this).data("id");
            confirm("Tem certeza que quer excluir!");
        
            $.ajax({
                type: "DELETE",
                url: "{{ route('web.pessoas.store') }}"+'/'+ pessoa_id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

        $.fn.datepicker.defaults.format = "dd/mm/yyyy";
        $( "#datepicker" ).datepicker({            
            locale: 'pt-br'
        });
    });

   
</script>
@endsection