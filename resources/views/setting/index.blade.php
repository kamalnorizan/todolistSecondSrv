@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Access Token</div>
                <div class="card-body">
                    @foreach (Auth::user()->clients as $client)
                        <strong>Id:</strong>{{$client->id}}<br>
                        <strong>Name:</strong>{{$client->name}}<br>
                        <strong>Redirect:</strong>{{$client->redirect}}<br>
                        <strong>Secret:</strong>{{$client->secret}}<br>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Access Token</div>
                <div class="card-body">
                    <form action="/oauth/clients" method="post">
                        @csrf
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId">
                        </div>
                        <div class="form-group">
                          <label for="name">Redirect</label>
                          <input type="text" class="form-control" name="redirect" id="redirect" aria-describedby="helpId">
                        </div>
                        <button type="submit">Generate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
