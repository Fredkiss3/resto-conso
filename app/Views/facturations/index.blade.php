@extends('_base')

@section('title', 'Liste des facturations')

@section('breadcrumb')
    <li class="breadcrumb-item active">Liste des facturations</li>
@endsection

@section('content')

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! form_open(route_to('facturations.store')) !!}
                {!! csrf_field() !!}

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Ajouter une nouvelle facturation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="example-number">Nom de la facturation</label>
                        <input class="form-control" id="example-number" type="text" name="libelle"
                               placeholder="Ex: Facturation Etudiant" required>
                    </div>

                    @foreach($dishes as $dish)
                        <div class="form-group mb-2">
                            <label class="form-label" for="repas-{{$dish->idRepas}}">Prix pour le repas <b>{{ $dish->libelle }}</b></label>
                            <input class="form-control" id="repas-{{$dish->idRepas}}" type="number" name="repas[{{$dish->idRepas}}]"
                                   required value="100">
                        </div>
                    @endforeach

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>

                {!! form_close() !!}

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! form_open(route_to('facturations.edit')) !!}
                {!! csrf_field() !!}

                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Modifier une facturation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit_id" value="0">

                    <div class="form-group">
                        <label class="form-label" for="libelleEdit">Nom de la facturation</label>
                        <input class="form-control" id="libelleEdit" type="text" name="libelle"
                               placeholder="Ex: Facturation Etudiant" required>
                    </div>

                    @foreach($dishes as $dish)
                        <div class="form-group mb-2">
                            <label class="form-label" for="repasEdit-{{$dish->idRepas}}">Prix pour le repas <b>{{ $dish->libelle }}</b></label>
                            <input class="form-control" id="repasEdit-{{$dish->idRepas}}" type="number" name="repas[{{$dish->idRepas}}]"
                                   required value="100">
                        </div>
                    @endforeach

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>

                {!! form_close() !!}

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                {!! form_open(route_to('facturations.delete')) !!}
                {!! csrf_field() !!}

                <div class="modal-header">
                    <h5 class="modal-title" id="modalDeleteLabel">Êtes-vous certain de vouloir supprimer cette facturation ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="delete_id" value="0">

                    <div class="form-group">
                        <label class="form-label" for="libelleDelete">Nom de la facturation</label>
                        <input class="form-control" id="libelleDelete" type="text"
                               placeholder="Ex: Petit-Déjeuner" disabled>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Valider</button>
                </div>

                {!! form_close() !!}

            </div>
        </div>
    </div>


    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-table'></i> Liste des facturations
        </h1>

        <button class="btn btn-primary" data-toggle="modal" data-target="#modal">Ajouter une nouvelle facturation
        </button>
    </div>

    <div class="row">
        @forelse($facturations as $fa)
            <div class="col-md-4">
                <div class="card mb-3" style="width: 18rem;">
                    <div class="card-body p-5">
                        <h4 class="card-title text-uppercase"><b>{{ $fa->libelle }}</b></h4>

                        <p class="card-text">
                        <ul class="ml-0 pl-4 mb-2">
                            @foreach($fa->repas as $re)
                                <li><b>Prix {{ $re->libelle }} :</b> {{ $re->montant }} FCFA</li>
                            @endforeach
                        </ul>
                        </p>

                        <button
                                data-libelle="{{ $fa->libelle }}"
                                data-id="{{ $fa->idFacturation }}"
                                data-repas="{{ json_encode($fa->repas) }}"
                                class="btn-edit btn btn-primary rounded btn-sm">
                            <i class="fal fa-edit"></i> Modifier
                        </button>

                        <button
                                data-libelle="{{ $fa->libelle }}"
                                data-id="{{ $fa->idFacturation }}"
                                class="btn btn-delete btn-danger rounded btn-sm">
                            <i class="fal fa-times"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-4">
                <div class="card mb-3" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Aucune facturation pour l'instant</h5>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

@endsection

@section('after-js')
    <script>
        $(document).ready(function () {
            $('.btn-edit').on('click', function (e) {

                $('#libelleEdit').val($(this).data('libelle'));
                $('[name="edit_id"]').val($(this).data('id'));

                var repas = $(this).data('repas');

                for (var i = 0; i < repas.length; i++) {
                    $('#repasEdit-' + repas[i].idRepas).val(repas[i].montant);
                }

                $('#modalEdit').modal().show();
            });

            $('.btn-delete').on('click', function (e) {

                $('#libelleDelete').val($(this).data('libelle'));
                $('[name="delete_id"]').val($(this).data('id'));

                $('#modalDelete').modal().show();
            });
        })
    </script>
@endsection
