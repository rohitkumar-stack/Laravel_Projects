@extends('inc')

@section('container')
    <h1 class="text-center">Edit Form!</h1>
    <p class="text-center">here we perform curd operation</p>

    <div class="container">
        <div class="col-md-6 offset-md-3">
            <form action="/update_curd" method="POST">
            @csrf
            <input type="hidden" name="id"  value="{{$data['id']}}">
             
                <div class="form-group">
                    <label>title</label>
                    <input type="text"  class="form-control" name="title"  value="{{$data['title']}}">
                </div>

                <div class="form-group">
                    <label>post</label>
                    <input type="text" class="form-control" name="post" placeholder="Enter post" value="{{$data['post']}}">
                </div>

                <div class="form-group">
                    <label>description</label>
                    <input type="text" class="form-control" name="description" placeholder="Enter description" value="{{$data['description']}}">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
