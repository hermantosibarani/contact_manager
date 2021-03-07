@extends('layout.backend.app',[
	'title' => 'Welcome',
	'pageTitle' => 'Assigment',
])
@section('content')
<style type="text/css">
	.dataTables_filter {
       float: left !important;
    }
    a {
        cursor: pointer;
        text-decoration: none;
    }
    #table_contact.dataTable th {
      word-break: keep-all;
      white-space: nowrap;
    }

    #table_contact.dataTable td {
      word-break: keep-all;
      white-space: nowrap;
    }
    #table_contact.dataTable th:nth-child(2) {
      width: 90px!important;
      max-width: 90px;
    }
    #table_contact.dataTable td:nth-child(2) {
      width: 90px!important;
      max-width: 90px;
    }
</style>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped display" id="table_contact" width="100%" cellspacing="0">
            <thead>
                <th>No</th>
                <th>Action</th>
                <th>Name</th>                      
                <th>Phone</th>
                <th>Email</th>
                <th>Status</th>
                <th>Agent</th>
                <th>Remark</th>
                <th>Creator</th>
                <th>Created at</th>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="mUpdate" data-backdrop="static" style="width: 50%;margin-left: 25%;">
    <div class="modal-dialog modal-base-dialog">
        <div class="modal-content main-modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Follow-Up Contact</b></h5>
                <button type="button" class="close" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">                                
                        <label>Name</label><label class="required">*</label> 
                        <input class="form-control" name="e_name" type="text" id="e_name" readonly />

                        <label>Phone</label><label class="required">*</label>
                        <input class="form-control" type="text" id="e_phone" name="e_phone" readonly /> 

                        <label>Email</label><label class="required">*</label>
                        <input class="form-control" type="text" id="e_email" name="e_email" readonly /> 

                        <label>Status</label><label class="required">*</label>
                        <select name="e_status" id="e_status" class="form-control">
                        	<option value="" style="display: none;"> Select Status</option>
                        	<option value="Uncontacted">Uncontacted</option>
                        	<option value="Pending">Pending</option>
                        	<option value="Qualified">Qualified</option>
                        	<option value="Lost">Lost</option>
                        </select>

                        <label>Remark</label><label class="required">*</label>
                        <input class="form-control" type="text" id="e_remark" name="e_remark" /> 
                        <input type="hidden" name="e_id" id="e_id">                     
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal"><i class="fas fa-times"></i>  CLOSE</button>
                </div>
                <button type="button" class="btn btn-primary" id="next" onclick="actionUpdateContact()">Save <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function(event) { 
        datatables();

    });

    function datatables(){
        var table = $("#table_contact").DataTable({
            ajax: {"url": "{{ route('datatables_user_contact')}}"},

            "order": [],

            "columnDefs": [
                { "orderable": false, "targets": 0 },
                { targets: -1, className: 'dt-body-center' },
            ], 
            "columns": [
                { "data": "no","orderable": false },
                { "data": "id"},
                { "data": "name" },
                { "data": "phone" },
                { "data": "email" },
                { "data": "status" },
                { "data": "agent" },
                { "data": "remark" },
                { "data": "created_by" },
                { "data": "created_at" },
            ],
            fixedColumns: false,
            pageLength:25,
            scrollY:        400,
            scrollX:        true,
            scrollCollapse: true,
            dom:"<'myfilter'f>Bt<'mylength'l>ip",
            buttons: [
                {
                    className: "btn btn-primary",
                    text: 'Export',
                    extend: 'excelHtml5',
                    title: 'Bast Cash In Database',
                    exportOptions: {
                        columns: [ 0]
                    }
                },
            ],     
            rowCallback: function(nRow, aData, iDisplayIndex) {

                var html = "<a data-toggle='tooltip' title=' data-original-title='Update Contact' class='link' onclick=\"update('"+aData['id']+"','"+aData['name']+"','"+aData['phone']+"','"+aData['email']+"')\"><i class='far fa-lg fa-edit'></i></a>";

                $('td:eq(1)', nRow).html( html );
            }
        });
    }

    function update(id,name,phone,email) {
        $('#e_id').val(id);
        $('#e_name').val(name);
        $('#e_phone').val(phone);
        $('#e_email').val(email);
        $('#mUpdate').modal('show');
    }

    function actionUpdateContact() {

        var contact = {};
            contact['remark']    = $('#e_remark').val();
            contact['status']   = $('#e_status').val();

        var id_contact = $('#e_id').val();

        swal({
            title: "Confirm",
            text: "Are you sure submit this data ? ",
            type: "warning",
            showCancelButton: true,
            // confirmButtonColor: "#0F4DA8",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            cancelButtonColor: "#DD6B55",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function(isConfirm){
            if (isConfirm) {
                setTimeout(function () {
                    updateContact(contact,id_contact);
                }, 800)
            } 
        })
    }

    function updateContact(contact,id_contact) {
        $.ajax({
            url:"{{ route('user_updatecontact') }}",
            type:"POST",
            async: false,
            data: {
                    "_token": "{{ csrf_token() }}",
                    "contact": contact,
                    "id_contact": id_contact
                },
            //async:false,
            success:function(resp) {
                console.log(resp)
                if (resp.code == 200) {
                    swal({
                        title: "Success",
                        text: resp.data.MESSAGE,
                        type: "success"
                    }, function() {
                        window.location.reload();
                    });
                } else {
                    swal({
                        title: "Error",
                        text: resp.data.TYPE+' - '+resp.data.MESSAGE,
                        type: "error"
                    });               
                }
            },
            error:function(err) {
                console.log(err)
            }
        })
    }

</script>
@stop

