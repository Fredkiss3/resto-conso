@extends('_base')

@section('title', 'Valider les rechargements')


@section('breadcrumb')
    <li class="breadcrumb-item active">Valider les rechargements</li>
@endsection

@section('content')

    <div class="modal fade" id="modalAccept" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                {!! form_open(route_to('recharge.accept')) !!}
                {!! csrf_field() !!}

                <div class="modal-header">
                    <h4 class="modal-title" id="ModalLabel">Valider les rechargements les comptes sélectionnés ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="accepted" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Oui</button>
                </div>

                {!! form_close() !!}

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCancel" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                {!! form_open(route_to('recharge.cancel')) !!}
                {!! csrf_field() !!}

                <div class="modal-header">
                    <h4 class="modal-title" id="ModalLabel">Refuser les rechargements des comptes sélectionnés ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="canceled" value="">
                    <div class="form-group">
                        <label class="form-label" for="example-number">Dites-nous pourquoi</label>
                        <textarea class="form-control" id="example-number" name="reason" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Oui</button>
                </div>

                {!! form_close() !!}

            </div>
        </div>
    </div>


    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-table'></i> Valider les rechargements
        </h1>
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
                        <div class="panel-tag">
                            <p>
                                Sélectionnez les différentes lignes, en appuyant sur <b>Ctrl+Clic</b> <br>
                                pour indiquer les comptes à recharger, et cliquez sur les boutons :
                                <li><b>Accepter</b> pour accepter les rechargements</li>
                                <li><b>Refuser</b> pour refuser les rechargements</li>
                            </p>
                        </div>
                        <!-- datatable start -->
                        <table id="dt-basic" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                            <tr>
                                <th>ID</th>
                                <th>Origine</th>
                                <th>date</th>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prénoms</th>
                                <th>Somme</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recharges as $re)
                                <tr>
                                    <td>{{ $re->idRecharge }}</td>
                                    <td>{{ $re->nomPersonnel }} {{ $re->prenomPersonnel }}</td>
                                    <td>{{ $re->date }}</td>
                                    <td>{{ $re->matriculeinphb }}</td>
                                    <td>{{ $re->nom }}</td>
                                    <td>{{ $re->prenoms }}</td>
                                    <td>{{ $re->montant }} FCFA</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Origine</th>
                                <th>date</th>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prénoms</th>
                                <th>Somme</th>
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
    <script>
        $(document).ready(function () {
            var table = $('table').DataTable(
                {
                    dom:
                        "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    responsive: true,
                    lengthChange: false,
                    select: true,
                    buttons: [
                        {
                            className: 'btn-success btn-sm mr-1',
                            text: 'Accepter',
                            action: function () {

                                var selected = table.rows({selected: true}).data().toArray();
                                var arr = [];
                                for (var i = 0; i < selected.length; i++) {
                                    arr = [...arr, selected[i][0]];
                                }


                                if (arr.length > 0) {
                                    $('[name="accepted"]').val(JSON.stringify(arr));
                                    $('#modalAccept').modal().show();
                                }

                            }
                        },
                        {
                            className: 'btn-danger btn-sm mr-1',
                            text: 'Refuser',
                            action: function () {

                                var selected = table.rows({selected: true}).data().toArray();
                                var arr = [];
                                for (var i = 0; i < selected.length; i++) {
                                    arr = [...arr, selected[i][0]];
                                }
                                // console.log(arr);


                                if (arr.length > 0) {
                                    $('[name="canceled"]').val(JSON.stringify(arr));
                                    $('#modalCancel').modal().show();
                                }
                            }
                        },
                    ]
                });

        })
    </script>
@endsection
