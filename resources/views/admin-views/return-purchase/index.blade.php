@extends('layouts.admin.app')

@section('title', translate('Return_Purchase')) 

<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        box-sizing: border-box !important;
        display: inline-block !important;
        min-width: 20px !important;
        padding: 5px 10px !important;
        margin-left: 2px !important;
        text-align: center !important;
        text-decoration: none !important;
        cursor: pointer !important;
        color: #8c98a4 !important;
        border: 1px solid transparent !important;
        border-radius: .3125rem !important;
    }
    .page-item.active .page-link {
        z-index: 3;
        color: #fff!important;
        background-color: #ff611d;
        border-color: #ff611d;
    }
</style>

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" class="avatar-img " src="{{asset('public/assets/admin/img/inventory/return.png')}}" alt="">
            <span class="page-header-title">
                {{translate('Return Purchase list')}}
            </span>     
            <span class="badge badge-soft-dark rounded-50 fz-12">{{ count($returnPurchases) }}</span>
        </h2>
    </div>
    <!-- End Page Header -->


    <div class="row g-3">
        <div class="col-12">
            <div class="card">
                <div class="card-top px-card">
                    <div class="d-flex flex-column flex-md-row flex-wrap  align-items-md-center">
                        <div class="d-flex flex-wrap align-items-center">
                            <a href="{{ route('admin.return-purchase.add') }}" type="button" class="btn btn-primary btn-attribute" >
                                <i class="tio-add"></i>
                                {{translate('Add_Return_Purchase')}}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body">
                 <div class="set_table new-responsive attribute-list" style="margin-top:30px">
                    <div class="table-responsive datatable_wrapper_row"  >
                        <table id="datatable" class="mt-2 table table-borderless table-thead-bordered table-nowrap table-align-middle card-table bottom-line">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{translate('SL')}}</th>
                                    <th>{{translate('Invoice')}}</th>
                                    <th>{{translate('vendor')}}</th>
                                    <th>{{translate('return_date')}}</th>
                                    <th>{{translate('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($returnPurchases as $returnPurchase)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            @if ($returnPurchase->status == 0)
                                                <a href="{{ route('admin.return-purchase.view', [$returnPurchase->id]) }}">{{ $returnPurchase->invoice }}</a>
                                            @else
                                                <a href="javascript:void(0)">{{ $returnPurchase->invoice }}</a>
                                            @endif
                                        </td>
                                        <td>{{ $returnPurchase->name }} <br/> {{ $returnPurchase->mobile }}</td>
                                        <td>{{ date('d-m-Y', strtotime($returnPurchase->created_at)) }}</td>
                                        <td>
                                            <div class="d-flex  gap-2">
                                                @if ($returnPurchase->status == 0)
                                                    <a class="btn btn-outline-primary btn-sm edit square-btn" href="{{ route('admin.return-purchase.view', [$returnPurchase->id]) }}">
                                                        <i class="tio-invisible"></i>
                                                    </a>
                                                    <a class="btn btn-outline-info btn-sm edit square-btn" href="{{ route('admin.return-purchase.return-edit', [$returnPurchase->id]) }}"><i class="tio-edit"></i></a>
                                                @else
                                                    <button type="button" class="btn btn-danger btn-sm " style="padding:5px">Cancelled</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                 </div>
                </div>
            </div>
        </div>
        <!-- End Table -->
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