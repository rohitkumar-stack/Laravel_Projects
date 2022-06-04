@extends('inc')

@section('container')
    <h1 class="text-center">Hello, world!</h1>
    <p class="text-center">here we perform curd operation</p>

    <div class="container">
        <div class="col-md-6 offset-md-3">
            <form method="POST" action="/curd_post">
            @csrf
                <div class="form-group">
                    <label>title</label>
                    <input type="text" class="form-control" name="title" placeholder="Enter title">
                </div>

                <div class="form-group">
                    <label>post</label>
                    <input type="text" class="form-control" name="post" placeholder="Enter post">
                </div>

                <div class="form-group">
                    <label>description</label>
                    <input type="text" class="form-control" name="description" placeholder="Enter description">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
