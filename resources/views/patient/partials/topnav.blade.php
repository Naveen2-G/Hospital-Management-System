@php
    $nav = [
        ['label' => 'Dashboard', 'route' => 'patient.dashboard'],
        ['label' => 'Appointments', 'route' => 'patient.appointments'],
        ['label' => 'Reports', 'route' => 'patient.reports'],
        ['label' => 'Prescriptions', 'route' => 'patient.prescriptions'],
        ['label' => 'Invoices', 'route' => 'patient.invoices'],
        ['label' => 'Profile', 'route' => 'patient.profile'],
    ];
@endphp

<nav class="patient-topnav" aria-label="Patient navigation">
    <div class="patient-topnav-scroll">
        @foreach($nav as $item)
            @php($active = request()->routeIs($item['route']))
            <a
                href="{{ route($item['route']) }}"
                class="patient-topnav-link {{ $active ? 'is-active' : '' }}"
                aria-current="{{ $active ? 'page' : 'false' }}"
            >
                {{ $item['label'] }}
            </a>
        @endforeach
    </div>
</nav>

