@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                <center>Create License</center>
                @include('layouts._message')
                <table class="table col-md-8 offset-md-2" border='1' id='userInfo' style='border-collapse: collapse;'>
                    <tbody></tbody>
                </table>
                <div class="form-group row">
                            <label for="client_id" class="col-md-4 col-form-label text-md-right">Client ID</label>

                            <div class="col-md-6">
                                <input id="client_id" type="text" class="form-control @error('client_id') is-invalid @enderror" name="client_id" value="{{ old('client_id') }}" required autocomplete="client_id" autofocus>

                                @error('client_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
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
                        
                <div class="form-group row mt-3">
                    <label for="license_for" class="col-md-4 col-form-label text-md-right">License For</label>

                    <div class="col-md-4">
                        <select id="license_for" type="text" class="form-control @error('license_for') is-invalid @enderror" name="license_for" value="{{ old('license_for') }}" required autocomplete="license_for" autofocus>
                            <option value="3">3</option>
                            <option value="6">6</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="col-md-2">Months</div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-3 offset-md-7">
                        <button id="create_key" type="button" class="btn btn-secondary  col-md-12">
                            Create Key
                        </button>
                    </div>
                </div>
                <div class="col-md-6 offset-md-4">
                     Return To  <a href="{{route('login')}}">Login </a>Page
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!-- jQuery CDN -->
<script type='text/javascript'>
    $(document).ready(function(){
        $('#client_id').on('keyup',function(e){
            if(e.key==='Enter' || e.keyCode===13){
                var id=$('#client_id').val();
                fetchRecords(id);
            }
        });
        $("#create_key").click(function(e) { 
            var u_id= $('#client_id').val();
            if(u_id ==''){
                alert("Please enter client Id")
            }
            var duration=$('#license_for').val();
            generate_key(u_id,duration);
        });
    });
    function generate_key(u_id,duration){
        $.ajax({
            url: 'key_gen/'+u_id+'/'+duration,
            type: 'get',
            dataType: 'json',
            success: function(response){
                if(response['data'] != null){
                    $('#license_key').val(response['data']);
                }else{
                    alert('No valid client found!');
                }
            }
        });
    }
    function fetchRecords(id){
        $.ajax({
            url: 'user/'+id,
            type: 'get',
            dataType: 'json',
            success: function(response){
            var len = 0;
            $('#userInfo tbody').empty(); 
            if(response['data'] != null){
                var first_name = response['data'].first_name;
                var last_name = response['data'].last_name;
                var organization = response['data'].organization;
                var street = response['data'].street;
                var city = response['data'].city;
                var phone = response['data'].phone;
                var email = response['data'].email;
                var license = response['data'].license_key;
                var tr_str = "<tr>" +
                "<th align='center'>First name</th>"+
                "<td align='center'>" + first_name + "</td>" +
                "</tr>"+
                "<tr>" +
                "<th align='center'>Last name</th>"+
                "<td align='center'>" + last_name + "</td>" +
                "</tr>"+
                "<tr>" +
                "<th align='center'>Name of Organizatione</th>"+
                "<td align='center'>" + organization + "</td>" +
                "</tr>"+
                "<tr>" +
                "<th align='center'>Street</th>"+
                "<td align='center'>" + street + "</td>" +
                "</tr>"+
                "<tr>" +
                "<th align='center'>City</th>"+
                "<td align='center'>" + city + "</td>" +
                "</tr>"+
                "<tr>" +
                "<th align='center'>Phone</th>"+
                "<td align='center'>" + phone + "</td>" +
                "</tr>"+
                "<tr>" +
                "<th align='center'>Email</th>"+
                "<td align='center'>" + email + "</td>" +
                "</tr>"+
                "<tr>" +
                "<th align='center'>License Key</th>"+
                "<td align='center'>" + license + "</td>" +
                "</tr>";
                        
                $("#userInfo tbody").append(tr_str);
            }
            else{
                var tr_str = "<tr>" +
                "<td align='center' colspan='4'>No record found.</td>" +
                "</tr>";
                $("#userInfo tbody").append(tr_str);
            }
        }
    });
}
</script>