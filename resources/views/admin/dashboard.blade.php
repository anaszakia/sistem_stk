@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div x-data="dashboardData()" class="space-y-8">
    <!-- Welcome Section - Simple Style -->
    <div class="mb-6">
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1">
                    <h1 class="text-2xl font-semibold mb-2 text-gray-900">
                        Selamat Datang, {{ auth()->user()->name }}
                    </h1>
                    <p class="text-gray-600 mb-4">
                        Dashboard Sistem Manajemen Kendaraan
                    </p>
                    <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                        <span>📅 {{ now()->format('d M Y') }}</span>
                        <span>⏰ <span x-text="currentTime"></span></span>
                        <span>👤 {{ ucwords(str_replace('_', ' ', auth()->user()->roles->first()->name ?? 'User')) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards - Simple Style -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Kendaraan -->
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Kendaraan</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalKendaraan }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-car text-gray-600"></i>
                </div>
            </div>
        </div>

        <!-- Kendaraan Tersedia -->
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Kendaraan Tersedia</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $kendaraanKosong }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-gray-600"></i>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-xs text-gray-500">{{ $totalKendaraan > 0 ? number_format(($kendaraanKosong / $totalKendaraan) * 100, 0) : 0 }}% dari total</span>
            </div>
        </div>

        <!-- Driver Ready -->
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Driver Siap</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $driverReady }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-check text-gray-600"></i>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-xs text-gray-500">Standby</span>
            </div>
        </div>

        <!-- Pajak Expired -->
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pajak Expired</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $pajakExpired }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-gray-600"></i>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-xs text-gray-500">Perlu diperpanjang</span>
            </div>
        </div>
    </div>

    <!-- Charts Section - Simple Style -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        <!-- User Growth Chart -->
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Pertumbuhan User</h3>
                    <p class="text-sm text-gray-500">7 Bulan Terakhir</p>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>

        <!-- Login Statistics -->
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Statistik Login</h3>
                    <p class="text-sm text-gray-500">7 Hari Terakhir</p>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="loginStatsChart"></canvas>
            </div>
        </div>
    </div>
    <!-- Data Tables - Simple Style -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Recent Users -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-4 py-3 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">User Terbaru</h3>
                    <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        Lihat Semua →
                    </a>
                </div>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    @forelse($recentUsers as $user)
                    <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                            <span class="text-gray-600 font-medium text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                        </div>
                        <div class="text-right">
                            @php
                                $userRoles = $user->roles;
                                $roleName = $userRoles->first() ? ucwords(str_replace('_', ' ', $userRoles->first()->name)) : 'User';
                            @endphp
                            <p class="text-xs text-gray-400">{{ $roleName }}</p>
                            <p class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <p>Belum ada user baru</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-4 py-3 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
                    <a href="{{ route('audit.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        Lihat Semua →
                    </a>
                </div>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    @forelse($recentActivity as $activity)
                    <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg">
                        @php
                            $icon = match($activity->action) {
                                'Login' => 'fas fa-sign-in-alt',
                                'Logout' => 'fas fa-sign-out-alt',
                                default => 'fas fa-cog'
                            };
                        @endphp
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="{{ $icon }} text-gray-600 text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $activity->user ? $activity->user->name : 'Unknown' }}
                                </p>
                                <span class="text-xs text-gray-400">{{ $activity->action }}</span>
                            </div>
                            <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <p>Belum ada aktivitas</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fade-in-delay {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.8s ease-out;
}

.animate-fade-in-delay {
    animation: fade-in-delay 0.8s ease-out 0.3s both;
}

.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

.group:hover .group-hover\:text-blue-600 {
    color: #2563eb;
}

.group:hover .group-hover\:text-green-600 {
    color: #059669;
}

.group:hover .group-hover\:text-purple-600 {
    color: #7c3aed;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

<script>
function dashboardData() {
    return {
        currentTime: new Date().toLocaleTimeString('id-ID'),
        
        init() {
            // Update time every second
            setInterval(() => {
                this.currentTime = new Date().toLocaleTimeString('id-ID');
            }, 1000);
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // User Growth Chart
    const userGrowthCtx = document.getElementById('userGrowthChart');
    if (userGrowthCtx) {
        new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: @json($userGrowthData['months']),
                datasets: [{
                    label: 'User Baru',
                    data: @json($userGrowthData['userCounts']),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: 'rgb(59, 130, 246)',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.9)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        cornerRadius: 10,
                        displayColors: false,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    y: {
                        display: true,
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            precision: 0,
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                elements: {
                    point: {
                        hoverRadius: 8
                    }
                }
            }
        });
    }

    // Login Statistics Chart
    const loginStatsCtx = document.getElementById('loginStatsChart');
    if (loginStatsCtx) {
        new Chart(loginStatsCtx, {
            type: 'bar',
            data: {
                labels: @json($loginStats['days']),
                datasets: [{
                    label: 'Login',
                    data: @json($loginStats['loginCounts']),
                    backgroundColor: 'rgba(168, 85, 247, 0.8)',
                    borderColor: 'rgba(168, 85, 247, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                    hoverBackgroundColor: 'rgba(168, 85, 247, 0.9)',
                    hoverBorderColor: 'rgba(168, 85, 247, 1)',
                    hoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.9)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: 'rgba(168, 85, 247, 1)',
                        borderWidth: 2,
                        cornerRadius: 10,
                        displayColors: false,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    y: {
                        display: true,
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            precision: 0,
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }
});
</script>
@endsection
