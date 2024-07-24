<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">

<table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 mt-3" id="datatable">
    <thead class="thead-light">
        <tr>
            <th>{{ translate('SL') }}</th>
            <th>{{ translate('order') }}</th>
            <th>{{ translate('date') }}</th>
            <th>{{ translate('customer') }}</th>
            <th>{{ translate('branch') }}</th>
            <th>{{ translate('total') }}</th>
            <th>{{ translate('order') }} {{ translate('status') }}</th>
            <th>{{ translate('actions') }}</th>
        </tr>
    </thead>
    <tbody id="set-rows">
        <!-- Add table rows here -->
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
        "bDestroy": true,
        "iDisplayLength": 25,
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('input').addClass('form-control');
    });

    // INITIALIZATION OF DATATABLES
    // =======================================================
    var datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
        dom: 'Bfrtip',
        "bDestroy": true,
        language: {
            zeroRecords: '<div class="text-center p-4">' +
                '<img class="mb-3" src="{{asset('public/assets/admin')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">' +
                '<p class="mb-0">{{translate('No data to show')}}</p>' +
                '</div>'
        }
    });
</script>