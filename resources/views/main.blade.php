<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <title>Buku Tamu</title>
  </head>
  <body>
    <div class="container">
        <nav class="navbar navbar-light bg-light">
            <span class="navbar-brand mb-0 h1">Online Guest-Book</span>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif 
            <span class="navbar-text">
                @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                @endauth
            </span>
        </nav>

        <div class="main">
            @auth 
                <button type="button" class="btn btn-primary mt-5" data-toggle="modal" data-target="#addData">
                    Add <i class="bi bi-plus"></i>
                </button>
            @endauth
            <table class="table table-bordered mt-1">
                <thead class="thead-light">
                    <tr>
                    <th scope="col">Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Invitation Category</th>
                    <th scope="col">Timestamp</th>
                    <th scope="col">Comment</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tamus as $tamu)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$tamu->name}}</td>
                            <td>{{$tamu->email}}</td>
                            <td>
                                @foreach ($tamu->tamuKategoris as $tamuKategori)
                                    - {{$tamuKategori->kategori->name}} <br>
                                @endforeach
                            </td>
                            <td>{{$tamu->timestamp}}</td>
                            <td>{{$tamu->comment}}</td>
                            <td>
                                @auth
                                    <div class="btn-group" role="group" aria-label="choices button">
                                        <button type="button" data-toggle="modal" data-target="#editData" class="btn btn-primary mr-2 rounded">Edit</button>
                                        <button type="button" data-toggle="modal" data-target="#deleteData" class="btn btn-danger rounded">Delete</button>
                                    </div>
                                @endauth
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>      
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addData" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addDataLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{url('/tamu/create')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addDataLabel">Add Guest</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name">
                        @if($errors->has('name'))
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" aria-describedby="emailHelp">
                        @if($errors->has('email'))
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="kategori">Category</label><br>
                        <select class="js-example-basic-multiple" id= "kategori" multiple="multiple" style="width: 37%">
                            @foreach ($kategoris as $kategori)    
                                <option value="{{$kategori->number}}">{{$kategori->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="timestamp">Timestamp</label>
                        <input type="time" class="form-control {{$errors->has('timestamp') ? 'is-invalid' : ''}}" id="timestamp" name="timestamp">
                        @if($errors->has('timestamp'))
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('timestamp') }}</strong>
                                </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea type="text" class="form-control {{$errors->has('comment') ? 'is-invalid' : ''}}" id="comment" name="comment"></textarea>
                        @if($errors->has('comment'))
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('comment') }}</strong>
                                </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success">Confirm</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    @foreach ($tamus as $tamu)
    <div class="modal fade" id="editData" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('/tamu/update/'.$tamu->number)}}">          
                    @csrf    
                    <div class="modal-header">
                            <h5 class="modal-title" id="editDataLabel">Edit Guest</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" value="{{$tamu->name}}" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name">
                                @if($errors->has('name'))
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" value="{{$tamu->email}}" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" aria-describedby="emailHelp">
                                @if($errors->has('email'))
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="kategori{{$tamu->number}}">Category</label><br>
                                <select name="kategori[]" id= "kategori{{$tamu->number}}" multiple="multiple" style="width: 37%">
                                    @foreach ($kategoris as $kategori)    
                                        <option value="{{$kategori->number}}" {{$tamu->hasKategoriByNumber($kategori->number) ? 'selected' : ''}}>{{$kategori->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="timestamp">Timestamp</label>
                                <input type="time" value="{{$tamu->timestamp}}" class="form-control {{$errors->has('timestamp') ? 'is-invalid' : ''}}" id="timestamp" name="timestamp">
                                @if($errors->has('timestamp'))
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('timestamp') }}</strong>
                                        </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <textarea type="text" value="{{$tamu->comment}}" class="form-control {{$errors->has('comment') ? 'is-invalid' : ''}}" id="comment" name="comment"></textarea>
                                @if($errors->has('comment'))
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('comment') }}</strong>
                                        </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-success">Confirm</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteData" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('/tamu/delete/'.$tamu->number)}}">          
                    @csrf    
                    <div class="modal-body" style="display:flex; align-items:center">
                        <h5>Are you sure?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kategori').select2();
        });
    </script>

    @foreach ($tamus as $tamu)
        <script>
            $(document).ready(function() {
                $('#kategori'.$tamu->number).select2();
            });
        </script>
    @endforeach
  </body>
</html>