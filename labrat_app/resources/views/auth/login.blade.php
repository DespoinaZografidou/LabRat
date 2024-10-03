@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h5>Σύνδεση</h5></div>

                <div class="card-body">

                    @if(isset($message))

                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @endif
                   <a href= "{{ route('sso.login')}}" style="color: white;" class="btn btn-block btn-success dtn-sm">Σύνδεση μέσω SSO</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
