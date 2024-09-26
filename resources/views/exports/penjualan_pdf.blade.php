<h1>Daftar Penjualan</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Pelanggan</th>
            <th>Tanggal Penjualan</th>
            <th>Total Harga</th>
            <th>Dibuat Oleh</th>
        </tr>
    </thead>
    <tbody>
        @foreach($penjualans as $penjualan)
            <tr>
                <td>{{ $penjualan->id }}</td>
                <td>{{ $penjualan->pelanggan->nama }}</td>
                <td>{{ $penjualan->tanggal_penjualan }}</td>
                <td>{{ $penjualan->total_harga }}</td>
                <td>{{ $penjualan->dibuat_oleh }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
