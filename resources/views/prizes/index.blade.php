@extends('default')

@section('content')
    @include('prob-notice')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('prizes.create') }}" class="btn btn-info">Create</a>
                </div>
                <h1>Prizes</h1>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Set Probability</th>
                            <th>Actual Probability</th>
                            <th>Awarded Count</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prizes as $prize)
                            <tr>
                                <td>{{ $prize->id }}</td>
                                <td>{{ $prize->title }}</td>
                                <td>{{ $prize->probability }}</td>
                                <td>{{ number_format($prize->actual_probability, 2) }}%</td>
                                <td>{{ $prize->awarded_count }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('prizes.edit', [$prize->id]) }}" class="btn btn-primary">Edit</a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['prizes.destroy', $prize->id]]) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Simulate</h3>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['method' => 'POST', 'route' => ['simulate']]) !!}
                        <div class="form-group">
                            {!! Form::label('number_of_prizes', 'Number of Prizes') !!}
                            {!! Form::number('number_of_prizes', 50, ['class' => 'form-control']) !!}
                        </div>
                        {!! Form::submit('Simulate', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>

                    <br>

                    <div class="card-body">
                        {!! Form::open(['method' => 'POST', 'route' => ['reset']]) !!}
                        {!! Form::submit('Reset', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Probability Settings</h2>
                        <div style="height: 400px;">
                            <canvas id="probabilityChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Actual Rewards</h2>
                        <div style="height: 400px;">
                            <canvas id="awardedChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Define a color palette for the charts
        const colors = [
            'rgba(255, 99, 132, 0.8)',   // Pink
            'rgba(54, 162, 235, 0.8)',   // Blue
            'rgba(255, 206, 86, 0.8)',   // Yellow
            'rgba(75, 192, 192, 0.8)',   // Teal
            'rgba(153, 102, 255, 0.8)',  // Purple
            'rgba(255, 159, 64, 0.8)',   // Orange
            'rgba(46, 204, 113, 0.8)',   // Green
            'rgba(142, 68, 173, 0.8)',   // Deep Purple
            'rgba(241, 196, 15, 0.8)',   // Golden
            'rgba(231, 76, 60, 0.8)'     // Red
        ];

        // Common chart options
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',  // This creates the donut hole
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed;
                            return `${context.label}: ${value.toFixed(2)}%`;
                        }
                    }
                },
                datalabels: {
                    color: '#fff',
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    formatter: (value) => {
                        if (value < 5) return '';  // Don't show labels for small segments
                        return value.toFixed(1) + '%';
                    }
                }
            }
        };

        // Probability Settings Chart
        const probabilityCtx = document.getElementById('probabilityChart');
        new Chart(probabilityCtx, {
            type: 'doughnut',  // Changed from 'pie' to 'doughnut'
            data: {
                labels: {!! json_encode($prizes->pluck('title')) !!},
                datasets: [{
                    data: {!! json_encode($prizes->pluck('probability')) !!},
                    backgroundColor: colors.slice(0, {!! json_encode($prizes->count()) !!}),
                    borderColor: colors.map(color => color.replace('0.8', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    title: {
                        display: true,
                        text: 'Configured Prize Probabilities',
                        font: {
                            size: 16,
                            weight: 'bold'
                        },
                        padding: {
                            bottom: 20
                        }
                    }
                }
            }
        });

        // Actual Rewards Chart
        const awardedCtx = document.getElementById('awardedChart');
        new Chart(awardedCtx, {
            type: 'doughnut',  // Changed from 'pie' to 'doughnut'
            data: {
                labels: {!! json_encode($prizes->pluck('title')) !!},
                datasets: [{
                    data: {!! json_encode($prizes->pluck('actual_probability')) !!},
                    backgroundColor: colors.slice(0, {!! json_encode($prizes->count()) !!}),
                    borderColor: colors.map(color => color.replace('0.8', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    title: {
                        display: true,
                        text: 'Actual Prize Distribution',
                        font: {
                            size: 16,
                            weight: 'bold'
                        },
                        padding: {
                            bottom: 20
                        }
                    }
                }
            }
        });
    </script>
@endpush