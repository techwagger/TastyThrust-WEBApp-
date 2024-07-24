@if (session()->has('address'))

@php
    $address = session()->get('address')
@endphp
<ul class="listStyle">
    <li>
        <span>{{ translate('Name') }} :</span>
        <strong>{{ $address['contact_person_name'] }}</strong>
    </li>
    <li>
        <span>{{ translate('contact') }} :</span>
        <strong>{{ $address['contact_person_number'] }}</strong>
    </li>
    <li>
        <div class="location">
            <span>{{ translate('Address') }} :</span>
            <strong>
                {{ $address['address'] }}
            </strong>
        </div>
    </li>
</ul>

@endif
