@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                <center>Activate License</center>
                @include('layouts._message')
                
                <form method="POST" action="{{ route('license.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="license_key" class="col-md-4 col-form-label text-md-right">License Key</label>

                        <div class="col-md-6">
                            <input id="license_key" type="text" class="form-control @error('license_key') is-invalid @enderror" name="license_key" value="{{ old('license_key') }}" required autocomplete="license_key" autofocus>

                            @error('license_key')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary col-md-12">
                                    Save
                            </button>
                        </div>
                    </div>
                </form>
                        
                <div class="col-md-6 offset-md-4">
                     Return To  <a href="{{route('license')}}"> License </a>Page
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
