<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Client Side Form Validation using jQuery in Laravel 8 - NiceSnippets.com</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
</head>
<style type="text/css">
    body{
        background: #ddd;
    }
    .container{
        background: #fff;
        margin-top:100px;
    }
    .error{
        color:red;
    }
</style>
<body>
    <div class="container">
        <h2 class="text-center">Client Side Form Validation using jQuery in Laravel 8 - NiceSnippets.com </h2><br/>
        <form method="" action="" id="form">
            @csrf
            <div class="row">
                <div class="col-md-3"></div>
                <div class="form-group col-md-6">
                    <label for="Name">Name:</label>
                    <input type="text" class="form-control" name="name">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="form-group col-md-6">
                    <label for="Email">Email:</label>
                    <input type="text" class="form-control" name="email">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="form-group col-md-6">
                    <label for="Number">Phone Number:</label>
                    <input type="text" class="form-control" name="number">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="form-group col-md-6" style="margin-top:10px">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $('#form').validate({ 
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                number: {
                    required: true,
                    digits: true
                    
                },
            },
            // errorElement: 'span',
            //     errorPlacement: function (error, element) {
            //     error.addClass('invalid-feedback');
            //     element.closest('.form-group').append(error);
            // },
            // highlight: function (element, errorClass, validClass) {
            //     $(element).addClass('is-invalid');
            // },
            // unhighlight: function (element, errorClass, validClass) {
            //     $(element).removeClass('is-invalid');
            // }
        });
    });
</script>
</html>