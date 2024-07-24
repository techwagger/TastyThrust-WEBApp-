<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">

<table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100" id="datatable" style="margin-top:10px!important;padding-left:0!important">
    <thead class="thead-light">
        <tr>
            <th>{{translate('SL')}} </th>
            <th>{{translate('order')}}</th>
            <th>{{translate('date')}}</th>
            <th>{{translate('qty')}}</th>
            <th>{{translate('amount')}}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $key=>$row)
        <tr>
            <td class="" style="padding-left: 18px;">
                {{$key+1}}
            </td>
            <td class="" style="padding-left: 18px;">
                <a href="{{route('admin.orders.details',['id'=>$row['order_id']])}}">{{$row['order_id']}}</a>
            </td>
            <td style="padding-left: 18px;">{{date('d M Y',strtotime($row['date']))}}</td>
            <td style="padding-left: 18px;">{{$row['quantity']}}</td>
            <td style="padding-left: 18px;">{{ \App\CentralLogics\Helpers::set_symbol($row['price']) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>


<script type="text/javascript">
    $(document).ready(function () {
        $('input').addClass('form-control');
    });

    // INITIALIZATION OF DATATABLES
    // =======================================================
    var datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
        dom: 'Bfrtip',
        buttons: [
        'excel', 'csv', 'pdf', 'print'
    ],
    info:false,
    paging:true,
        "bDestroy": true,
        language: {
            zeroRecords: '<div class="text-center p-4">' +
                '<img class="mb-3" src="{{asset('public/assets/admin')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">' +
                '<p class="mb-0">{{translate('No data to show')}}</p>' +
                '</div>'
        }
    });
</script>