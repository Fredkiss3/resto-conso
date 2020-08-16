@extends('_base')

@section('title', 'Liste des repas')

@section('breadcrumb')
    <li class="breadcrumb-item active">Liste des repas</li>
@endsection

@section('content')

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                {!! form_open(route_to('dishes.store')) !!}
                {!! csrf_field() !!}

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Ajouter un nouveau repas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="example-number">Nom du repas</label>
                        <input class="form-control" id="example-number" type="text" name="libelle"
                               placeholder="Ex: Petit-Déjeuner" required>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="heureDebutS">Heure de début en semaine</label>
                                <input class="form-control" id="heureDebutS" type="time" name="heureDebutSemaine"
                                       value="06:00" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="heureFinS">Heure de fin en semaine</label>
                                <input class="form-control" id="heureFinS" type="time" name="heureFinSemaine"
                                       value="18:00" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="heureDebutW">Heure de début en weekend</label>
                                <input class="form-control" id="heureDebutW" type="time" name="heureDebutWeekend"
                                       value="06:00" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="heureFinW">Heure de fin en weekend</label>
                                <input class="form-control" id="heureFinW" type="time" name="heureFinWeekend"
                                       value="18:00" required>
                            </div>
                        </div>
                    </div>
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
                {!! form_open(route_to('dishes.edit')) !!}
                {!! csrf_field() !!}

                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Modifier un repas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit_id" value="0">

                    <div class="form-group">
                        <label class="form-label" for="libelleEdit">Nom du repas</label>
                        <input class="form-control" id="libelleEdit" type="text" name="libelle"
                               placeholder="Ex: Petit-Déjeuner" required>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="heureDebutSEdit">Heure de début en semaine</label>
                                <input class="form-control" id="heureDebutSEdit" type="time" name="heureDebutSemaine"
                                       value="06:00" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="heureFinSEdit">Heure de fin en semaine</label>
                                <input class="form-control" id="heureFinSEdit" type="time" name="heureFinSemaine"
                                       value="18:00" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="heureDebutWEdit">Heure de début en weekend</label>
                                <input class="form-control" id="heureDebutWEdit" type="time" name="heureDebutWeekend"
                                       value="06:00" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="heureFinWEdit">Heure de fin en weekend</label>
                                <input class="form-control" id="heureFinWEdit" type="time" name="heureFinWeekend"
                                       value="18:00" required>
                            </div>
                        </div>
                    </div>
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
                {!! form_open(route_to('dishes.delete')) !!}
                {!! csrf_field() !!}

                <div class="modal-header">
                    <h4 class="modal-title" id="modalDeleteLabel">Êtes-vous certain de vouloir supprimer Ce repas ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="delete_id" value="0">

                    <div class="form-group">
                        <label class="form-label" for="libelleDelete">Nom du repas</label>
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
            <i class='subheader-icon fal fa-table'></i> Liste des repas
        </h1>

        <button class="btn btn-primary" data-toggle="modal" data-target="#modal">Ajouter un nouveau repas
        </button>
    </div>

    <div class="row">
        @forelse($dishes as $re)
            <div class="col-md-4">
                <div class="card mb-3" style="width: 18rem;">
                    <div class="card-body p-5">
                        <h4 class="card-title text-uppercase"><b>{{ $re->libelle }}</b></h4>
                        <p class="card-text">
                        <ul class="ml-0 pl-4 mb-2">
                            <li><b>Début Semaine :</b> {{ $re->getTime("heureDebutSemaine") }}</li>
                            <li><b>Fin Semaine :</b> {{ $re->getTime("heureFinSemaine") }}</li>
                            <li><b>Début Weekend</b> {{ $re->getTime("heureDebutWeekend") }}</li>
                            <li><b>Fin Weekend :</b> {{ $re->getTime("heureFinWeekend") }}</li>
                        </ul>
                        </p>
                        <button
                                data-libelle="{{ $re->libelle }}"
                                data-id="{{ $re->idRepas }}"
                                data-heureDebutSemaine="{{ $re->getTime("heureDebutSemaine") }}"
                                data-heureFinSemaine="{{ $re->getTime("heureFinSemaine")  }}"
                                data-heureDebutWeekend="{{ $re->getTime("heureDebutWeekend") }}"
                                data-heureFinWeekend="{{ $re->getTime("heureFinWeekend") }}"
                                class="btn-edit btn btn-primary rounded btn-sm">
                            <i class="fal fa-edit"></i> Modifier
                        </button>
                        <button
                                data-libelle="{{ $re->libelle }}"
                                data-id="{{ $re->idRepas }}"
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
                        <h5 class="card-title">Aucun Repas pour l'instant</h5>
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
                $('#heureDebutSEdit').val($(this).data('heuredebutsemaine'));
                $('#heureFinSEdit').val($(this).data('heurefinsemaine'));
                $('#heureDebutWEdit').val($(this).data('heuredebutweekend'));
                $('#heureFinWEdit').val($(this).data('heurefinweekend'));

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
