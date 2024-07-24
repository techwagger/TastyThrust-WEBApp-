@extends('layouts.admin.app')

@section('title', translate('Ingredient'))

@push('css_or_js')
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/inventory/inventory.png')}}" alt="">
            <span class="page-header-title">{{ translate('ingredient')}}</span>
        </h2>
    </div>
    <!-- End Page Header -->

    <div class="row g-2">
        <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.ingredient.update', [$ingredient->id]) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="input-label">{{ translate('ingredient')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ $ingredient->name }}" placeholder="{{ translate('ingredient_name')}}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="input-label">{{ translate('quantity_type') }}<span class="text-danger">*</span></label>
                                    <select name="quantity_type" class="custom-select">
                                        <option selected disabled>{{ translate('select_quantity_type') }}</option>
                                        <option value="pc" {{ $ingredient->quantity_type == 'pc' ? 'selected' : '' }}>pc</option>
                                        <option value="kg" {{ $ingredient->quantity_type == 'kg' ? 'selected' : '' }}>kg</option>
                                        <option value="gm" {{ $ingredient->quantity_type == 'gm' ? 'selected' : '' }}>gm</option>
                                        <option value="ltr" {{ $ingredient->quantity_type == 'ltr' ? 'selected' : '' }}>ltr</option>
                                        <option value="ml" {{ $ingredient->quantity_type == 'ml' ? 'selected' : '' }}>ml</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <button type="reset" id="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                            <button type="submit" class="btn btn-primary">{{translate('update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
