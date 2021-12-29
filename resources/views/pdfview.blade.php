<html>
<head>
    <title> CKEditor In Laravel </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-2 mt-5">
                <div class="card">
                    <div class="card-header bg-info">
                        <h6 class="text-white"> CKEditor In Laravel </h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('ckeditor.store')}}" enctype="multipart/form-data" id="submitform">
                            @csrf
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="title" class="form-control" value="@if(isset($data)){{$data->title}}@endif"/>
                            </div>
                            <div class="form-group">
                                <label><strong>Description :</strong></label>
                                <textarea class="ckeditor form-control" name="ckeditor">@if(isset($data)){{$data->content}}@endif</textarea>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success btn-sm">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script type="text/javascript">

    CKEDITOR.replace( 'ckeditor', {
        filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    $(document).redy(function(){
        $('body').on('submit','#submitform',function(e){
            e.preventDefault();

            $.ajax({
                url : $(this).attr('action'), // Url of backend (can be python, php, etc..)
                type: "POST", // data type (can be get, post, put, delete)
                data : new FormData(this), // data in json format
                contentType : false,
                cache : false, // enable or disable async (optional, but suggested as false if you need to populate data afterwards)
                processData : false,
                success: function(data) {
                    console.log(data.msg);
                    alert(data.msg)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        })
    })

</script>

</html>
