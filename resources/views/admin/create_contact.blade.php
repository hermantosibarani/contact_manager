@extends('layout.backend.app',[
    'title' => 'Create Contact',
    'pageTitle' => 'Create Contact'
])
@section('content')
<!-- Content Row -->
<style type="text/css">
    .dataTables_filter {
       float: left !important;
    }
    a {
        cursor: pointer;
        text-decoration: none;
    }
    table.dataTable th {
      word-break: keep-all;
      white-space: nowrap;
    }

    table.dataTable td {
      word-break: keep-all;
      white-space: nowrap;
    }
    table.dataTable th:nth-child(2) {
      width: 90px!important;
      max-width: 90px;
    }
    table.dataTable td:nth-child(2) {
      width: 90px!important;
      max-width: 90px;
    }
    
</style>
<div class="float-right">
    <!-- <button class = "btn btn-google ml-3" data-toggle="modal" data-target="#add-io">New Internal Orders</button> -->
    <button class="btn btn-google btn-icon-split btn-md" id="addContact"  data-toggle="modal" data-target="#mCO">
        <span class="icon text-white-10">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">New Contact</span>
    </button>
</div>

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
                <th>History</th>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="mCO" data-backdrop="static" style="width: 50%;margin-left: 25%;">
    <div class="modal-dialog modal-base-dialog">
        <div class="modal-content main-modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Create Contact</b></h5>
                <button type="button" class="close" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">                                
                        <label>Name</label><label class="required">*</label> 
                        <input class="form-control" name="name" type="text" id="name"/>
                        <label>Phone</label><label class="required">*</label>            
                        <input class="form-control" type="text" id="phone" name="phone" /> 
                        <label>Email</label><label class="required">*</label>            
                        <input class="form-control" type="text" id="email" name="email" />                      
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal"><i class="fas fa-times"></i>  CLOSE</button>
                </div>
                <button type="button" class="btn btn-primary" id="next" onclick="actionSubmitContact()">Save <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mAss" data-backdrop="static" style="width: 50%;margin-left: 25%;">
    <div class="modal-dialog modal-base-dialog">
        <div class="modal-content main-modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Assign Contact</b></h5>
                <button type="button" class="close" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">                                
                        <label>Assign to agent :</label>
                        <select name="ass_agent" id="ass_agent" class="form-control">
                        <input type="hidden" name="ass_id" id="ass_id">
                        </select>                     
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal"><i class="fas fa-times"></i>  CLOSE</button>
                </div>
                <button type="button" class="btn btn-primary" id="next" onclick="ass_agent()">Save <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mUpdate" data-backdrop="static" style="width: 50%;margin-left: 25%;">
    <div class="modal-dialog modal-base-dialog">
        <div class="modal-content main-modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Update Contact</b></h5>
                <button type="button" class="close" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">                                
                        <label>Name</label><label class="required">*</label> 
                        <input class="form-control" name="e_name" type="text" id="e_name"/>
                        <label>Phone</label><label class="required">*</label>            
                        <input class="form-control" type="text" id="e_phone" name="e_phone" /> 
                        <label>Email</label><label class="required">*</label>            
                        <input class="form-control" type="text" id="e_email" name="e_email" /> 
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
@stop

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        datatables();
        

    });

    function datatables(){
        var table = $("#table_contact").DataTable({
            ajax: {"url": "{{ route('datatables_contact')}}", "type": "GET"},

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
                { "data": "id" },
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
                var html =  "<a data-toggle='tooltip' title=' data-original-title='Assign Agent' class='link' onclick=\"assign('"+aData['id']+"','"+aData['name']+"')\"><i class='fa fa-user-check'></i></i></a> - ";

                html += "<a data-toggle='tooltip' title=' data-original-title='Update Contact' class='link' onclick=\"update('"+aData['id']+"','"+aData['name']+"','"+aData['phone']+"','"+aData['email']+"')\"><i class='far fa-lg fa-edit'></i></a> - ";

                html += "<a data-toggle='tooltip' title=' data-original-title='Delete Contact' class='link' onclick=\"deleteContact('"+aData['id']+"')\"><i class='far fa-trash-alt'></i></a>";

                html2 = "<a data-toggle='tooltip' title=' data-original-title='History' class='link' onclick=\"history('"+aData['id']+"')\"><i class='fas fa-history'></i></a>";

                $('td:eq(1)', nRow).html( html );
                $('td:eq(10)', nRow).html( html2 );
            }
        });
    }

    function actionSubmitContact() {

        var contact = {};
            contact['name']     = $('#name').val();
            contact['phone']    = $('#phone').val();
            contact['email']    = $('#email').val();

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
                    submitContact(contact);
                }, 800)
            } 
        })
    }

    function submitContact(contact) {
        $.ajax({
            url:"{{ route('storecontact') }}",
            type:"POST",
            async: false,
            data: {
                    "_token": "{{ csrf_token() }}",
                    "contact": contact
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

    function assign(id,name) {
        $.ajax({
            url:"{{ route('get_list_user') }}",
            type:"GET",
            async: false,
            success:function(resp) {
                opt = '<option value=0>Choose</option>';
                $(resp).each(function(i, field) {
                    opt += '<option value="'+field.id+'">'+field.name+'</option>';
                });
                $('select[name="ass_agent"]').html(opt);
                $('#mAss').modal('show');
                $('#ass_id').val(id);
                $('#mAss .modal-title').html('Assign contract for '+name);
            },
            error:function(err) {
                console.log(err)
            }
        })
    }

    function ass_agent() {
        var data = {};
            data['id']     = $('#ass_id').val();
            data['agent']  = $('#ass_agent').val();
        $.ajax({
            url:"{{ route('assigncontact') }}",
            type:"POST",
            async: false,
            data: {
                    "_token": "{{ csrf_token() }}",
                    "data": data
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
        
    function update(id,name,phone,email) {
        $('#e_id').val(id);
        $('#e_name').val(name);
        $('#e_phone').val(phone);
        $('#e_email').val(email);
        $('#mUpdate').modal('show');
    }

    function actionUpdateContact() {

        var contact = {};
            contact['name']     = $('#e_name').val();
            contact['phone']    = $('#e_phone').val();
            contact['email']    = $('#e_email').val();
            contact['status']   = 'Uncontacted';

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
            url:"{{ route('updatecontact') }}",
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

    function deleteContact(id) {

        swal({
            title: "Confirm",
            text: "Are you sure delete this data ? ",
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
                    $.ajax({
                        url:"{{ route('deletecontact') }}",
                        type:"POST",
                        async: false,
                        data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id
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
                }, 800)
            } 
        })
    }
    
</script>