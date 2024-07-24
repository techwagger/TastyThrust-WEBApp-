@extends('layouts.admin.app')

@section('title', translate('Add new addon'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img " src="{{asset('public/assets/admin/img/icons/attribute.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('Addon List')}}
                </span>
                <span class="badge badge-soft-dark rounded-50 fz-12">{{ count($addons) }}</span>
                               
            </h2>
        </div>
        <!-- End Page Header -->


        <div class="row g-3">
            <div class="col-12">
                <div class="mt-3">
                    <div class="card">
                        <div class="card-top px-card">
                            <div class="d-flex flex-column flex-md-row flex-wrap gap-3  align-items-md-center">
                               

                                <div class="d-flex flex-wrap justify-content-md-end ">
                                    <form action="{{url()->current()}}" method="GET">
                                        {{-- <div class="input-group">
                                            <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{translate('Search by Addon name')}}" aria-label="Search" value="{{$search}}" required="" autocomplete="off">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"> {{translate('Search')}}</button>
                                            </div>
                                        </div> --}}
                                    </form>
                                    <button type="button" class="btn btn-primary btn-attribute" data-toggle="modal" data-target="#adAddondModal">
                                        <i class="tio-add"></i>
                                        {{translate('Add_Addon')}}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class=" set_table new-responsive  addon-list">
                            <div class="table-responsive datatable_wrapper_row"  style="padding-right: 10px;">
                                <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>{{translate('SL')}}</th>
                                            <th>{{translate('name')}}</th>
                                            <th>{{ translate('price') }} (in ₹)</th>

                                            <th>{{translate('tax')}} (%)</th>
                                            <th>{{translate('action')}}</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($addons as $key=>$addon)
                                        <tr>
                                            {{-- <td>{{$addons->firstitem()+$key}}</td> --}}
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <div>
                                                    {{$addon['name']}}
                                                </div>
                                            </td>
                                            <td>{{ Helpers::set_symbol($addon['price']) }}</td>
                                            <td>{{ $addon['tax'] }}</td>
                                            <td>
                                                <div class="d-flex r gap-2">
                                                    <a class="btn btn-outline-info btn-sm edit square-btn"
                                                        href="{{route('admin.addon.edit',[$addon['id']])}}"><i class="tio-edit"></i></a>
                                                    <button class="btn btn-outline-danger btn-sm delete square-btn" type="button"
                                                        onclick="form_alert('addon-{{$addon['id']}}','{{translate('Want to delete this addon')}}')"><i class="tio-delete"></i></button>
                                                </div>
                                                <form action="{{route('admin.addon.delete',[$addon['id']])}}"
                                                        method="post" id="addon-{{$addon['id']}}">
                                                    @csrf @method('delete')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive mt-4 px-3 pagination-style">
                                <div class="d-flex justify-content-lg-end justify-content-sm-end">
                                    <!-- Pagination -->
                                    {{-- {!! $addons->links() !!} --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="adAddondModal" tabindex="-1" role="dialog" aria-labelledby="adAddondModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <form action="{{route('admin.addon.store')}}" method="post">
                            @csrf
                            @php($data = Helpers::get_business_settings('language'))
                            @php($default_lang = Helpers::get_default_language())

                            @if ($data && array_key_exists('code', $data[0]))
                            <ul class="nav nav-tabs w-fit-content mb-4">
                                @foreach ($data as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link {{ $lang['default'] == true ? 'active' : '' }}" href="#"
                                        id="{{ $lang['code'] }}-link">{{ Helpers::get_language_name($lang['code']) . '(' . strtoupper($lang['code']) . ')' }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="row">
                                <div class="col-sm-12">
                                    @foreach ($data as $lang)
                                        <div class="form-group {{ $lang['default'] == false ? 'd-none' : '' }} lang_form" id="{{ $lang['code'] }}-form">
                                            <label class="input-label" for="exampleFormControlInput1">{{ translate('name') }}<span class="text-danger">*</span> ({{ strtoupper($lang['code']) }})</label>
                                            <input type="text" name="name[]" class="form-control" placeholder="{{translate('New addon')}}"
                                                {{$lang['status'] == true ? 'required':''}} maxlength="255"
                                                @if($lang['status'] == true) oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                        </div>
                                        <input type="hidden" name="lang[]" value="{{ $lang['code'] }}">
                                    @endforeach
                                    @else
                                    <div class="row">
                                        <div class="col-sm-12 mb-4">
                                            <div class="form-group lang_form" id="{{ $default_lang }}-form">
                                                <label class="input-label" for="exampleFormControlInput1">{{ translate('name') }} ({{ strtoupper($default_lang) }})</label>
                                                <input type="text" name="name[]" class="form-control" maxlength="255" placeholder="{{ translate('New addon') }}" required>
                                            </div>
                                            <input type="hidden" name="lang[]" value="{{ $default_lang }}">
                                            @endif
                                            <input name="position" value="0" style="display: none">
                                        </div>
                                        <div class="col-sm-6 from_part_2 mb-4">
                                            <label class="input-label" for="exampleFormControlInput1">{{translate('price')}} (in ₹)<span class="text-danger">*</span></label>
                                            <input type="number" min="0" name="price" step="any" class="form-control"
                                                placeholder="100" required
                                                oninvalid="document.getElementById('en-link').click()">
                                        </div>
                                        <div class="col-sm-6 from_part_2 mb-4">
                                            <label class="input-label" for="exampleFormControlInput1">{{translate('tax')}} (%)<span class="text-danger">*</span></label>
                                            <input type="number" min="0" name="tax" step="any" class="form-control"
                                                   placeholder="5" required
                                                   oninvalid="document.getElementById('en-link').click()">
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-3">
                                                <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                                                <button type="submit" class="btn btn-primary">{{translate('submit')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection

@push('script_2')
    <script>
        $(".lang_link").click(function(e){
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#"+lang+"-form").removeClass('d-none');
            if(lang == '{{$default_lang}}')
            {
                $(".from_part_2").removeClass('d-none');
            }
            else
            {
                $(".from_part_2").addClass('d-none');
            }
        });
    </script>
  @push('script_2')
  <script>
      $(document).on('ready', function () {
          // INITIALIZATION OF NAV SCROLLER
          // =======================================================
          $('.js-nav-scroller').each(function () {
              new HsNavScroller($(this)).init()
          });
  
          // INITIALIZATION OF SELECT2
          // =======================================================
          $('.js-select2-custom').each(function () {
              var select2 = $.HSCore.components.HSSelect2.init($(this));
          });
  
  
          // INITIALIZATION OF DATATABLES
          // =======================================================
          var datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
              dom: 'Bfrtip',
              buttons: [
                  {
                      extend: 'copy',
                      className: 'd-none'
                  },
                  {
                      extend: 'excel',
                      className: 'd-none'
                  },
                  {
                      extend: 'csv',
                      className: 'd-none'
                  },
                  {
                      extend: 'pdf',
                      className: 'd-none'
                  },
                  {
                      extend: 'print',
                      className: 'd-none'
                  },
                  
              ],
              info: false,
              paging: true,
              select: {
                  style: 'multi',
                  selector: 'td:first-child input[type="checkbox"]',
                  classMap: {
                      checkAll: '#datatableCheckAll',
                      counter: '#datatableCounter',
                      counterInfo: '#datatableCounterInfo'
                  }
              },
              language: {
                  zeroRecords: '<div class="text-center p-4">' +
                      '<img class="mb-3" src="{{asset('public/assets/admin')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">' +
                      '<p class="mb-0">{{translate('No data to show')}}</p>' +
                      '</div>'
              }
          });
  
          // INITIALIZATION OF TAGIFY
          // =======================================================
          $('.js-tagify').each(function () {
              var tagify = $.HSCore.components.HSTagify.init($(this));
          });
      });
  
      function filter_branch_orders(id) {
          location.href = '{{url('/')}}/admin/orders/branch-filter/' + id;
      }
     
  </script>
@endpush
