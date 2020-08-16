@extends('_base')

@section('title', 'Recharger les comptes')

@section('breadcrumb')
    <li class="breadcrumb-item active">Recharger les comptes</li>
@endsection

@section('content')

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                {!! form_open(route_to('recharge.submit')) !!}
                {!! csrf_field() !!}

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Recharger les comptes sélectionnés</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="selected" value="">
                    <div class="form-group">
                        <label class="form-label" for="example-number">Somme</label>
                        <input class="form-control" id="example-number" type="number" name="somme" value="500"
                               min="500">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Oui</button>
                </div>

                {!! form_close() !!}

            </div>
        </div>
    </div>


    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-table'></i> Faire une nouvelle demande de rechargement
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
                                pour indiquer les comptes à recharger, et cliquez sur le bouton <b>Valider</b>
                            </p>
                        </div>
                        <!-- datatable start -->
                        <table id="dt-basic" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                            <tr>
                                <th>ID</th>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prénoms</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($accounts as $account)
                                <tr>
                                    <td>{{ $account->idCompte }}</td>
                                    <td>{{ $account->matriculeinphb }}</td>
                                    <td>{{ $account->nom }}</td>
                                    <td>{{ $account->prenoms }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prénoms</th>
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
                            className: 'btn-validate btn-primary btn-sm mr-1',
                            text: 'Recharger les comptes sélectionnés',
                            action: function () {

                                var selected = table.rows({selected: true}).data().toArray();
                                var arr = [];
                                for (var i = 0; i < selected.length; i++) {
                                    arr = [...arr, selected[i][0]];
                                }

                                if (arr.length > 0) {
                                    $('[name="selected"]').val(JSON.stringify(arr));
                                    $('#modal').modal().show();
                                }

                            }
                        }
                    ]
                });

        })
    </script>
@endsection
