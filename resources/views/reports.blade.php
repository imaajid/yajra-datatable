<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>reporting</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css" rel="stylesheet">
{{-- for datetime picker --}}
<link rel ="stylesheet" href ="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel ="stylesheet" href ="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


   {{-- <script src=https://code.jquery.com/jquery-3.5.1.js></script> --}}
   <script src=https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js></script>
   <script src=https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js></script>
   <script src=https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js></script>
   <script src=https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js></script>
   <script src=https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js></script>
   <script src=https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js></script>
{{-- for datetime picker --}}
    {{-- <script src ="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> --}}
    <script src ="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src ="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src ="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>


</head>

<body>
    <div class="container">
        <h2>Reports</h2>
        <br>

            <input type="hidden" class="form-control" name="business_name" value="{{ $business_name }}" id="business_name" required>

        <div class="row">
            {{-- <div class="form-group col-md-6">
                <h5>Start Date <span class="text-danger"></span></h5>
                <div class="controls">
                    <input type="date" name="start_date" id="start_date" class="form-control datepicker-autoclose"
                        placeholder="Please select start date" required>
                    <div class="help-block"></div>
                </div>
            </div> --}}
            {{-- <div class="well form-group col-md-6">
                <div id="datetimepicker1" class="input-append date">
                  <input data-format="dd/MM/yyyy hh:mm:ss" type="text"></input>
                  <span class="add-on">
                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                    </i>
                  </span>
                </div>
              </div> --}}
              {{-- <input size="16" type="text" class="form-control" id="datetime"> --}}
              <div class="form-group col-md-6">
                <h5>Start Date</h5>
               <div class ='input-group date' id='datetimepicker1'>
                <input type ='text' name="datetimepicker1" class="form-control" />
                <span class ="input-group-addon">
                  <span class ="glyphicon glyphicon-calendar"></span>
                </span>
               </div>
              </div>


            <div class="form-group col-md-6">
                <h5>End Date</h5>
                <div class ='input-group date' id='datetimepicker2'>
                    <input type ='text'  name="datetimepicker2"  class="form-control" />
                    <span class ="input-group-addon">
                      <span class ="glyphicon glyphicon-calendar"></span>
                    </span>
                   </div>
                {{-- <h5>End Date <span class="text-danger"></span></h5>
                <div class="controls">
                    <input type="date" name="end_date" id="end_date" class="form-control datepicker-autoclose"
                        placeholder="Please select end date" required>
                    <div class="help-block"></div>
                </div> --}}
            </div>
            <div class="text-left" style="margin-left: 15px">
                <button type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>

            </div>
        </div>

        <br>
        <table class="table table-bordered" id="laravel_datatable" style="width:100%">
            <thead>
                <tr>
                    <th>Business Name</th>
                    <th>Business Zone</th>
                    <th>Transaction Date</th>
                    <th>Invoice No</th>
                    <th>Total Before Tax</th>
                    <th>Tax Amount</th>
                    <th>Final Amount</th>
                    <th>Cash</th>
                    <th>Card</th>
                    <th>Coupon</th>
                    <th>Tips</th>
                </tr>
            </thead>
        </table>
    </div>
    <script>
         $(function() {
         $('#datetimepicker1').datetimepicker();

           $('#datetimepicker2').datetimepicker();

        });

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#laravel_datatable').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel','print', 'pdf',
                    ],
                ajax: {
                    url: "{{ url('report-list') }}",
                    type: 'GET',
                    data: function(d) {
                        d.start_date = $('#datetimepicker1').find("input").val();
                        d.end_date = $('#datetimepicker2').find("input").val();
                        d.business_name = $('#business_name').val();
                    }
                },
                columns: [
                    {
                        data: 'business_name',
                        name: 'business_name'
                    },
                    {
                        data: 'business_zone',
                        name: 'business_zone'
                    },
                    {
                        data: 'transaction_date',
                        name: 'transaction_date'
                    },
                    {
                        data: 'invoice_no',
                        name: 'invoice_no'
                    },
                    {
                        data: 'total_before_tax',
                        name: 'total_before_tax'
                    },
                    {
                        data: 'tax_amount',
                        name: 'tax_amount'
                    },
                    {
                        data: 'final_amount',
                        name: 'final_amount'
                    },
                    {
                        data: 'cash',
                        name: 'cash'
                    },
                    {
                        data: 'card',
                        name: 'card'
                    },
                    {
                        data: 'coupon',
                        name: 'coupon'
                    },
                    {
                        data: 'tips',
                        name: 'tips'
                    },

                ]
            });
        });
        $('#btnFiterSubmitSearch').click(function() {
            $('#laravel_datatable').DataTable().draw(true);
        });

    </script>

</body>

</html>
