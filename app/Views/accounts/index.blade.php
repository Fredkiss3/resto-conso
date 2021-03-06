@extends('_base')

@section('title', 'Liste des Comptes')

@section('breadcrumb')
    <li class="breadcrumb-item active">Liste des comptes</li>
@endsection

@section('content')
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                {!! form_open(route_to('accounts.store')) !!}
                {!! csrf_field() !!}

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Ajouter un compte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label class="form-label" for="single-default">
                            Choisissez un étudiant
                        </label>
                        <select class="select2 form-control w-100" id="single-default" name="etudiant">
                            @foreach($students as $student)
                                <option value="{{ $student->idEtudiant }}">{{ $student->matriculeinphb }} -
                                    {{ $student->fullName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="single-default2">
                            Choisissez la facturation à appliquer
                        </label>
                        <select class="select2 form-control w-100" id="single-default2" name="facturation">
                            @foreach($facturations as $facturation)
                                <option value="{{ $facturation->idFacturation }}">{{ $facturation->libelle }}</option>
                            @endforeach
                        </select>
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

    <div class="modal fade" id="modalQR" tabindex="-1" role="dialog" aria-labelledby="modalQRLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalQRLabel">Code QR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="qr-content" style="width: 400px;height: 400px;text-align: center" class="m-auto">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLock" tabindex="-1" role="dialog" aria-labelledby="modalLockLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                {!! form_open(route_to('accounts.toggle')) !!}
                {!! csrf_field() !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLockLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="toggle_id" value="0">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
                {!! form_close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalReset" tabindex="-1" role="dialog" aria-labelledby="modalResetLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                {!! form_open(route_to('accounts.reset')) !!}
                {!! csrf_field() !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="modalResetLabel">Êtes-vous certain de vouloir réinitialiser le code de
                        facturation de l'étudiant ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="reset_id" value="0">
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
                {!! form_open(route_to('accounts.delete')) !!}
                {!! csrf_field() !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDeleteLabel">Êtes-vous certain de vouloir supprimer ce compte ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="delete_id" value="0">
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
                {!! form_open(route_to('accounts.edit')) !!}
                {!! csrf_field() !!}

                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Modifier un compte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit_id" value="0">
                    <div class="form-group">
                        <label class="form-label" for="facturation_edit">
                            Choisissez la nouvelle facturation à appliquer
                        </label>
                        <select class="select2 form-control w-100" id="facturation_edit" name="facturation">
                            @foreach($facturations as $facturation)
                                <option id="factu-value-{{ $facturation->idFacturation }}" value="{{ $facturation->idFacturation }}">{{ $facturation->libelle }}</option>
                            @endforeach
                        </select>
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


    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-table'></i> Liste des comptes
        </h1>

        <button class="btn btn-primary" data-toggle="modal" data-target="#Modal">Ajouter un nouveau compte
        </button>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Panel
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <!-- datatable start -->
                        <table id="dt-basic-" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                            <tr>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prénoms</th>
                                <th>Solde</th>
                                <th>Facturation</th>
                                <th>Code QR</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($accounts as $account)
                                <tr>
                                    <td>{{ $account->matriculeinphb }}</td>
                                    <td>{{ $account->nom }}</td>
                                    <td>{{ $account->prenoms }}</td>
                                    <td>{{ $account->solde }} FCFA</td>
                                    <td>{{ $account->libelleFacturation }}</td>
                                    <td>
                                        <button class="btn btn-qr btn-outline-secondary btn-sm btn-icon waves-effect waves-themed"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                data-original-title="Voir"
                                                data-qr="{{ $account->codeDeFacturation }}"
                                        >
                                            <i class="fal fa-eye"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-edit btn-primary btn-sm btn-icon rounded-circle waves-effect waves-themed"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                data-factu="{{ $account->facturation }}"
                                                data-id="{{ $account->idCompte }}"
                                                data-original-title="Modifier le compte"
                                        >
                                            <i class="fal fa-edit"></i>
                                        </button>
                                        @if($account->actif)
                                            <button class="btn btn-lock btn-success btn-sm btn-icon rounded-circle waves-effect waves-themed"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-id="{{ $account->idCompte }}"
                                                    data-original-title="Bloquer le compte"
                                            >
                                                <i class="fal fa-lock-open"></i>
                                            </button>
                                        @else
                                            <button
                                                    class="btn btn-unlock btn-warning btn-sm btn-icon rounded-circle waves-effect waves-themed"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-id="{{ $account->idCompte }}"
                                                    data-original-title="Débloquer le compte"
                                            >
                                                <i class="fal fa-lock"></i>
                                            </button>
                                        @endif

                                        <button
                                                class="btn btn-info btn-reset btn-sm btn-icon rounded-circle waves-effect waves-themed"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                data-id="{{ $account->idCompte }}"
                                                data-original-title="Réinitialiser le code de facturation"
                                        >
                                            <i class="fal fa-sync"></i>
                                        </button>
                                        <button
                                                class="btn btn-danger btn-delete btn-sm btn-icon rounded-circle waves-effect waves-themed"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                data-id="{{ $account->idCompte }}"
                                                data-original-title="Supprimer le compte"
                                        >
                                            <i class="fal fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prénoms</th>
                                <th>Solde</th>
                                <th>Facturation</th>
                                <th>Code QR</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- datatable end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after-js')
    {!! script_tag('js/qrcode.min.js') !!}

    <script>
        $(document).ready(function () {
            var qrcode = new QRCode(document.getElementById("qr-content"), {
                text: "",
                width: 400,
                height: 400,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            $('.btn-qr').on('click', function (e) {
                $('#modalQR').modal().show();
                qrcode.clear();
                qrcode.makeCode($(this).data('qr'));
            });

            $('.btn-lock').on('click', function (e) {
                $('#modalLock').modal().show();
                $('#modalLockLabel').text("Êtes-vous certain de vouloir bloquer ce compte ?");
                $('[name="toggle_id"]').val($(this).data('id'))
            });

            $('.btn-unlock').on('click', function (e) {
                $('#modalLock').modal().show();
                $('#modalLockLabel').text("Êtes-vous certain de vouloir débloquer ce compte ?");
                $('[name="toggle_id"]').val($(this).data('id'))
            });

            $('.btn-reset').on('click', function (e) {
                $('#modalReset').modal().show();
                $('[name="reset_id"]').val($(this).data('id'))
            });

            $('.btn-delete').on('click', function (e) {
                $('#modalDelete').modal().show();
                $('[name="delete_id"]').val($(this).data('id'))
            });

            $('.btn-edit').on('click', function (e) {
                $('#modalEdit').modal().show();
                $('[name="edit_id"]').val($(this).data('id'));
            });

            var options = {
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            };

            // initialize datatable
            $('#dt-basic-').dataTable(
                {
                    responsive: true,
                    lengthChange: false,
                    dom:
                        "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        /*{
                            extend:    'colvis',
                            text:      'Column Visibility',
                            titleAttr: 'Col visibility',
                            className: 'mr-sm-3'
                        },*/
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            titleAttr: 'Generate PDF',
                            className: 'btn-outline-danger btn-sm mr-1',
                            ...options

                        },
                        {
                            extend: 'excelHtml5',
                            text: 'Excel',
                            titleAttr: 'Generate Excel',
                            className: 'btn-outline-success btn-sm mr-1',
                            ...options

                        },
                        {
                            extend: 'csvHtml5',
                            text: 'CSV',
                            titleAttr: 'Generate CSV',
                            className: 'btn-outline-primary btn-sm mr-1',
                            ...options

                        },
                        {
                            extend: 'copyHtml5',
                            text: 'Copier',
                            titleAttr: 'Copy to clipboard',
                            className: 'btn-outline-primary btn-sm mr-1',
                            ...options

                        },
                        {
                            extend: 'print',
                            text: 'Imprimer',
                            titleAttr: 'Print Table',
                            className: 'btn-outline-primary btn-sm',
                            ...options
                        }
                    ]
                });

        });
    </script>
@endsection