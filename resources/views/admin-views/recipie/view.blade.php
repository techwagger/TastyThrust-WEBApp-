@extends('layouts.admin.app')

@section('title', translate('Recipe Details'))

@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" class="avatar-img " src="{{asset('public/assets/admin/img/icons/attribute.png')}}" alt="">
            <span class="page-header-title">
                {{translate('Recipe Details')}}
            </span> 
        </h2>
    </div>

    <!-- End Page Header -->
    <div class="card mb-3 mb-lg-5">
        <div class="card-body bottom-new-line">
            <div class="row">
                <div class="col-lg-6">
                    <div class="vendor-data">
                        <span class="vendor-title">{{ translate('recipe_name') }} : </span>
                        <span>{{ json_decode($recipie[0]->product_details)->name }}</span>
                    </div>
                </div>       
                <div class="col-lg-6">
                    <div class="vendor-data">
                        <span class="vendor-title">{{ translate('variation') }} : </span>
                        <span>{{ $recipie[0]->variation }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-card">
            <div class="py-4 table-responsive buttons-fixes">
                <table id="datatable" class="bottom-line table-style table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ translate('SL') }}</th>
                            <th>{{ translate('ingredient') }}</th>
                            <th>{{ translate('quanity') }}</th>
                        </tr>
                    </thead>  
                    <tbody>
                        @foreach ($recipie[0]->recipieIngredients as $ingredients)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ json_decode($ingredients->ingredient_details)->name }}</td>
                                <td>{{ $ingredients->quantity }} {{ $ingredients->quantity_type }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>
@endsection

@push('script_2')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.print.min.js"></script>
    <script type="text/javascript">
        $(document).on('ready', function () { 

            // INITIALIZATION OF DATATABLES
            var datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'd-none'
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'csv',
                        className: 'd-none'
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'print',
                        className: 'd-none'
                    },
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    classMap: {
                        checkAll: '#datatableCheckAll',
                        counter: '#datatableCounter',
                        counterInfo: '#datatableCounterInfo'
                    }
                },
                info: false,
                paging: true,
                language: {
                    zeroRecords: '<div class="text-center p-4">' +
                        '<img class="mb-3" src="{{asset('public/assets/admin')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">' +
                        '<p class="mb-0">{{translate('No data to show')}}</p>' +
                        '</div>'
                },
                order: [], // Add this line to enable sorting on all columns
                columnDefs: [
                    { orderable: true, targets: '_all' } // Ensure all columns are orderable
                ]
            });

        });
    </script>
@endpush