@extends('app')
@section('content')
    <div class="container">
      <div class="card">
        <div class="card-body">
            <div class="card-header mt-5">
                <h2>
                    Call Details 
                    <button class="btn btn-primary  btn-md "style="float:right;" data-toggle="modal"id="Createvehicle" data-target="#callModal"><i class="fa fa-plus mr-2"></i>Add new</button>
                </h2> 
                <div class="row">
                    <div class="col-sm-2">
                        <input type="date" class="form-control form-control searchEmail" name="date" id="date"placeholder="Search for Email Only...">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" id="fil_name" class="form-control searchName" placeholder="Search for phone number/name">
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-white  btn-sm tx-10 "style="float:left;background-color:white;" id="filterBtn" ><i class="fa fa-filter fa-thin fa-2x"></i>Filter</button>
                    </div>
            
            </div>
        </div>
        <br>
        <table class="table data-table">
            <thead>
              <tr>
              <th>Phone Number</th>
                    <th>Purpose Of Call</th>
                    <th>Status Of Call</th>
                    <th>Call Duration</th>
                    <th>Comments(If any)</th>
                    <th>Client Name</th>
                    <th>Agent</th>
                    <th>Created</th>
                    <th width="100px">Edit/Delete</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
      </div>
    </div>
    <div class="modal  bs-example-modal-center" id="callModal" tabindex="-1" role="dialog" aria-pledby="mySmallModalp" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0">
          <div style="text-align:right;"class = "m-3">
            <button type="button" class="btn-close" data-dismiss="modal"aria-p="Close"></button>
          </div>
          <div class="modal-header pb-2 bg-white text-black"style="background-color:white;" >
            <h2 class="modal-title my-0" id="client_nameHeading"> Add New Call Details  </h2>
          </div>
          <div class="modal-body">
            <form id="callForm" name="callForm" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="call_id" id="call_id">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <p >Date</p>
                                <input type="date" class="form-control form-control-sm" name="dated" id="dated">
                            <div id="error-dated"class="error"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <p  >Client Name</p>
                              <input type="text" class="form-control form-control-sm" name="client_name" id="client_name">
                            <div id="error-client_name"class="error"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <p >Phone Number</p>
                                <input type="text" class="form-control form-control-sm" name="phone" id="phone">
                            <div id="error-phone_number"class="error"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-sm">
                        <div class="form-group">
                            <p >Name(Optional)</p>
                            <input type="text" class="form-control form-control-sm" name="name" id="name">
                            <div id="error-name"class="error"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-sm">
                        <div class="form-group">
                            <p >Purpose of Call</p>
                                <input type="text" class="form-control form-control-sm" name="purpose" id="purpose">
                            <div id="error-purpose"class="error"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-sm">
                        <div class="form-group">
                            <p >Status of Call</p>
                                <input type="text" class="form-control form-control-sm" name="status" id="status">
                            <div id="error-status"class="error"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-sm">
                        <div class="form-group">
                            <p >Call Duration</p>
                                <input type="text" class="form-control form-control-sm" name="duration" id="duration">
                            <div id="error-duration"class="error"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-sm">
                        <div class="form-group">
                            <p >Comments(If any)</p>
                                <input type="text" class="form-control form-control-sm" name="comments" id="comments">
                            <div id="error-comments"class="error"></div>
                        </div>
                    </div>
                </div>
                
            </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-light btn-sm float-right" data-dismiss="modal"id="closeBtn">Cancel</button>
              <button class="btn btn-primary btn-sm " type="submit"id="saveBtn">Save</button>
          </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
 <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


<script type="text/javascript">

  $(function () {
    

    $('#callModal').hide();    

    // alert(fil_name);
    var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('call') }}",
                data: function (d) {
                    d.created_at = $('.searchEmail').val(),
                    d.nameNumber = $('.searchName').val()
                    // d.search = $('input[type="search"]').val()
                }
            },
        dom: 'B',
        columns: [
            {data: 'phone_number', name: 'phone_number'},
            {data: 'purpose', name: 'purpose'},
            {data: 'status', name: 'status'},
            {data: 'duration', name: 'duration'},
            {data: 'comments', name: 'comments'},
            {data: 'client', name: 'client'},
            {data: 'user', name: 'user'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action'},
        ],
    });
        // $(".searchEmail").change(function(){
        //     table.draw();
        // });
        // $(".searchName").keyup(function(){
        //     table.draw();
        // });
   $('#filterBtn').click(function () {
        table.draw();
   });
    var user = {!! json_encode((array)auth()->user()->role) !!}
    if(user ==1){

        table.column(6).visible( true );

    }else{

        table.column(6).visible( false );
   }
   $('#Createvehicle').click(function () {
        $('#call_id').val('');
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        $('#dated').val(today);
        $('#saveBtn').val("create-Equipment");
        $('#client_name').val('');
        $('#phone').val('');
        $('#name').val('');
        $('#duration').val('');
        $('#purpose').val('');
        $('#comments').val('');
        $('#status').val('');
        $(".error").html('');
        $('#saveBtn').show();
        $('#callModal').show();    

    });
    $("#saveBtn").on('click', function(e){
        e.preventDefault();

        formData = new FormData(callForm);

        $.ajax({

            data:formData,
            url: "{{ URL('callStore') }}",
            type: "POST",
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {

                // alert("hi");
                $('#callForm').trigger("reset");
                $('#callModal').hide();
                table.ajax.reload();
                location.reload('true');
            },
            error: function (errors) {
                var messages = [];
                var data = JSON.parse(errors.responseText);
                if(typeof data.errors.phone != 'undefined'){

                    var message = data.errors.phone;
                    var result = String(message).fontcolor("red");
                    $('#error-phone_number').html(result);

                }else{

                    $('#error-phone_number').html('');
                }
                if(typeof data.errors.client_name != 'undefined'){

                    var message = data.errors.client_name;
                    var result = String(message).fontcolor("red");
                    $('#error-client_name').html(result);

                }else{

                    $('#error-client_name').html('');
                }
                if(typeof data.errors.purpose != 'undefined'){

                    var message = data.errors.purpose;
                    var result = String(message).fontcolor("red");
                    $('#error-purpose').html(result);

                }else{

                    $('#error-purpose').html('');
                }
                if(typeof data.errors.status != 'undefined'){

                    var message = data.errors.status;
                    var result = String(message).fontcolor("red");
                    $('#error-status').html(result);

                }else{

                    $('#error-status').html('');
                }
                if(typeof data.errors.duration != 'undefined'){

                    var message = data.errors.duration;
                    var result = String(message).fontcolor("red");
                    $('#error-duration').html(result);

                }else{

                    $('#error-duration').html('');
                }
            }
        });
    });
    $('body').on('click', '.edit-call', function () {
        $(".error").html('');
        var call_id = $(this).data('id');
        $.get("{{ URL('call') }}" +'/' + call_id +'/edit', function (data) {
        
            $('#call_id').val(data.id);
            $('#dated').val(data.date);
            $('#phone').val(data.phone_number);
            $('#name').val(data.name);
            $('#client_name').val(data.client);
            $('#status').val(data.status);
            $('#duration').val(data.duration);
            $('#comments').val(data.comments);
            $('#purpose').val(data.purpose);
            $('#modelHeading').html("Edit Call Details");
            $('#saveBtn').show();
            $('#saveBtn').html('Save'); 
            $('#callModal').show();  
        });
    });
    $('body').on('click', '.delete-driver', function () {
        
        var call_id = $(this).data('id');
        var result =confirm("Are You sure want to delete !");
        if(result == true){

            $.ajax({
                data: {
            "_token": "{{ csrf_token() }}",
            "id": call_id
            },
                type: "DELETE",
                url: "{{ URL('call') }}"+'/'+call_id,

                success: function (response) {
                if(typeof response.success != 'undefined' && response.success !=''){
                    //  formCustomErrorAndSuccessMessages('SUCCESS',response);
                }else{
                    if(typeof response.error != 'undefined' && response.error !=''){
                    //  formCustomErrorAndSuccessMessages('ERROR',response);
                    }
                }
                    table.ajax.reload( null, false );

                },

                    error: function (data) {
                }
            });
        }
    });

  });
   

</script>
