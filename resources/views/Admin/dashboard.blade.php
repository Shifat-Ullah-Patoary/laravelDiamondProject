@extends('layouts.admin')

@section('title', 'Dashboard | Diamond Group')

@section('content')
    <div
        class="relative mb-8 overflow-hidden rounded-3xl bg-slate-950 px-6 py-8 text-white shadow-xl shadow-slate-900/10 sm:px-8">
        <div class="relative z-10 flex flex-wrap items-end justify-between gap-6">
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-[0.24em] text-cyan-300">Diamond Group control centre
                </p>
                <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">Good morning, {{ auth()->user()->name ?? 'Admin' }}
                </h1>
                <p class="mt-3 max-w-xl text-sm leading-6 text-slate-300">A live view of your website activity, customer
                    inquiries, and content operations.</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-slate-200 backdrop-blur">
                <p class="text-xs text-slate-400">Today</p>
                <p class="mt-1 font-semibold">{{ now()->format('l, d M Y') }}</p>
            </div>
        </div>
        <div class="absolute -right-10 -top-20 h-56 w-56 rounded-full bg-cyan-500/20 blur-3xl"></div>
        <div class="absolute -bottom-28 left-1/3 h-48 w-48 rounded-full bg-blue-500/20 blur-3xl"></div>
    </div>

    <div class="mb-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([['Registered users', $totalUsers, $newUsersThisMonth . ' new this month', 'bg-blue-50 text-blue-700'], ['Contract inquiries', $totalInquiries, $newInquiriesThisMonth . ' this month', 'bg-cyan-50 text-cyan-700'], ['Content sections', '7', 'Ready to manage', 'bg-violet-50 text-violet-700'], ['Admin status', 'Active', 'All systems available', 'bg-emerald-50 text-emerald-700']] as [$label, $value, $detail, $tone])
            <article class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
                    <span class="rounded-lg px-2 py-1 text-xs font-bold {{ $tone }}">●</span>
                </div>
                <p class="mt-4 text-3xl font-bold tracking-tight text-slate-950">{{ $value }}</p>
                <p class="mt-2 text-xs font-medium text-slate-500">{{ $detail }}</p>
            </article>
        @endforeach
    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 xl:col-span-2">
            <div class="mb-6 flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h2 class="font-bold text-slate-950">Sales overview</h2>
                    <p class="mt-1 text-sm text-slate-500">Contract inquiries received throughout {{ now()->format('Y') }}.
                    </p>
                </div>
                <span class="rounded-full bg-cyan-100 px-3 py-1 text-xs font-semibold text-cyan-900">This year</span>
            </div>
            <div class="h-72"><canvas id="inquiryChart" aria-label="Contract inquiries by month" role="img"></canvas>
            </div>
        </section>

        <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center justify-between gap-3">
                <h2 class="font-bold text-slate-950">Recent inquiries</h2>
                <a href="{{ route('contractsTable') }}" class="text-xs font-semibold text-cyan-700 hover:text-cyan-900">View
                    all</a>
            </div>
            <ul class="mt-4 divide-y divide-slate-100">
                @forelse ($recentContracts as $contract)
                    <li class="flex gap-3 py-4">
                        <span
                            class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-cyan-100 text-xs font-bold text-cyan-800">{{ strtoupper(substr($contract->name, 0, 1)) }}</span>
                        <div class="min-w-0">
                            <p class="truncate font-semibold text-slate-800">{{ $contract->name }}</p>
                            <p class="mt-1 truncate text-sm text-slate-500">{{ $contract->subject }}</p>
                            <p class="mt-1 text-xs text-slate-400">{{ $contract->created_at->diffForHumans() }}</p>
                        </div>
                    </li>
                @empty
                    <li class="py-8 text-center text-sm text-slate-500">No inquiries received yet.</li>
                @endforelse
            </ul>
        </section>

        <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 xl:col-span-2">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <h2 class="font-bold text-slate-950">Newest registered users</h2>
                    <p class="mt-1 text-sm text-slate-500">People who recently joined your platform.</p>
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $totalUsers }}
                    total</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-3 py-3 pr-4">Name</th>
                            <th class="px-3 py-3 pr-4">Email</th>
                            <th class="px-3 py-3">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentUsers as $user)
                            <tr class="hover:bg-slate-50">
                                <td class="px-3 py-3 pr-4 font-semibold text-slate-800">{{ $user->name }}</td>
                                <td class="px-3 py-3 pr-4 text-slate-600">{{ $user->email }}</td>
                                <td class="whitespace-nowrap px-3 py-3 text-slate-500">
                                    {{ $user->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3 py-8 text-center text-sm text-slate-500">No users registered
                                    yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section
            class="rounded-2xl bg-gradient-to-br from-cyan-600 to-blue-700 p-6 text-white shadow-lg shadow-cyan-700/20">
            <p class="text-xs font-semibold uppercase tracking-widest text-cyan-100">Quick action</p>
            <h2 class="mt-3 text-xl font-bold">Keep your content fresh</h2>
            <p class="mt-2 text-sm leading-6 text-cyan-50">Update the pages that customers see first and keep your business
                information current.</p>
            <a href="{{ route('admin.home-settings.index') }}"
                class="mt-6 inline-flex items-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-cyan-800 transition hover:bg-cyan-50">Edit
                homepage <span class="ml-2">→</span></a>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartCanvas = document.getElementById('inquiryChart');
        if (chartCanvas && window.Chart) {
            new Chart(chartCanvas, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Inquiries',
                        data: @json($monthlyInquiryTotals),
                        borderColor: '#0891b2',
                        backgroundColor: 'rgba(8, 145, 178, 0.12)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    </script>
@endpush
