@extends('_layout')

@section('title', 'Connexion')

@section('after-css')
    <style>
        @media (min-width: 992px) {
            .nav-function-fixed:not(.nav-function-top):not(.nav-function-hidden):not(.nav-function-minify) .page-content-wrapper {
                padding-left: 0 !important;
            }
        }

    </style>
@endsection

@section('body')
    <div class="page-inner bg-brand-gradient">
        <div class="page-content-wrapper bg-transparent m-0">
            <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                <div class="d-flex align-items-center container p-0">
                    <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9">
                        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                            <img src="{{ base_url() . '/img/logo.png' }}" alt="SmartAdmin WebApp"
                                 aria-roledescription="logo"
                                 style="width: 30px;height: 30px;">
                            <span class="page-logo-text mr-1">GI-INPHB</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex-1"
                 style="background-size: cover;">
                <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                    <div class="row">
                        <div class="col col-md-6 col-lg-7 hidden-sm-down">
                            <h2 class="fs-xxl fw-500 mt-4 text-white">
                                <p style="word-break: break-word">INPHB </p>
                                <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60">
                                    {{--                                    INPHB--}}
                                    Institut National Polytechnique Felix Houphouet Boigny. <br>
                                    Logiciel de gestion integrée.
                                </small>
                            </h2>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto">
                            <h1 class="text-white fw-300 mb-3 d-sm-block d-md-none">
                                Connexion Sécurisée
                            </h1>
                            <div class="card p-4 rounded-plus bg-faded">
                                {!! form_open('', ['id' => 'js-login', 'novalidate' => '']) !!}
                                {!! csrf_field() !!}

                                @if(!empty($message['error']))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{$message['error']}} <br>
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label class="form-label" for="username">Nom d'utilisateur</label>
                                    <input type="text" id="username" class="form-control form-control-lg"
                                           placeholder="Votre nom d'utilisateur"
                                           name="username"
                                           required>
                                    <div class="invalid-feedback">Le nom d'utilisateur est Requis</div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="password">Mot de passe</label>
                                    <input type="password" id="password"
                                           class="form-control form-control-lg"
                                           name="password"
                                           placeholder="Votre Mot de passe" required>
                                    <div class="invalid-feedback">Le mot de passe est requis</div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col-lg-12 pl-lg-1 my-2">
                                        <button id="js-login-btn" type="submit"
                                                class="btn btn-danger btn-block btn-lg">Connexion
                                        </button>
                                    </div>
                                </div>
                                {!! form_close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                        GI-INPHB version 1.0.1 - Logiciel de gestion integrée © 2020
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after-js')
    <script>
        $("#js-login-btn").click(function (event) {

            // Fetch form to apply custom Bootstrap validation
            var form = $("#js-login");

            if (form[0].checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.addClass('was-validated');
            // Perform ajax submit here...
        });
    </script>
@endsection