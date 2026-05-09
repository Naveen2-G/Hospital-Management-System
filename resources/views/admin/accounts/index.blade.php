@extends('admin.layouts.app')

@section('title', 'Accounts')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-blue-600">Registered patients</p>
                <h1 class="mt-1 text-2xl font-extrabold text-slate-900">Accounts</h1>
                <p class="mt-2 text-sm text-slate-600">All registered patient accounts with email address and account creation date.</p>
            </div>

            <form method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search email / name / phone"
                       class="w-full sm:w-72 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-300">
                <button class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">Search</button>
            </form>
        </div>

        <div class="mt-6 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left">
                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">Name</th>
                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">Email</th>
                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">Phone</th>
                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">Created</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                    @forelse($accounts as $acc)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-5 py-4 font-semibold text-slate-900">{{ $acc->name }}</td>
                            <td class="px-5 py-4 text-slate-700">{{ $acc->email }}</td>
                            <td class="px-5 py-4 text-slate-700">{{ $acc->phone ?? '—' }}</td>
                            <td class="px-5 py-4 text-slate-700">{{ $acc->created_at?->format('d M Y, h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-slate-500 font-semibold">
                                No accounts found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($accounts->hasPages())
                <div class="px-5 py-4 border-t border-slate-200 bg-white">
                    {{ $accounts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

