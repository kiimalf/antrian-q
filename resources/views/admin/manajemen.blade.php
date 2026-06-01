@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>Manajemen Tiket</h2>
            <p>Kelola Daftar Antrian Disini.</p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nomor Antrian</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($antrian as $index => $antrian)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $antrian->name }}</td>
                                <td>A-{{ sprintf('%03d', $antrian->number) }}</td>
                                <td>{{ ucfirst($antrian->status) }}</td>
                                <td>
                                    @if($antrian->status == 'waiting')
                                        <form action="{{ route('admin.updateStatus', $antrian->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="called">
                                            <button type="submit" class="btn btn-primary btn-sm">Panggil</button>
                                        </form>
                                    @elseif($antrian->status == 'called')
                                        <form action="{{ route('admin.updateStatus', $antrian->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-success btn-sm">Selesai</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Tidak ada aksi</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-page')
@endsection
