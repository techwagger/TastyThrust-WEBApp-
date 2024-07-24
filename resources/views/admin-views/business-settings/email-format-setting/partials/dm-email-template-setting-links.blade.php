<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/dm/registration') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['dm','registration']) }}">
                {{translate('New_Delivery_Partner_Registration')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/dm/approve') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['dm','approve']) }}">
                {{translate('New_Delivery_Partner_Approval')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/dm/deny') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['dm','deny']) }}">
                {{translate('New_Delivery_Partner_Rejection')}}
                </a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
</div>
