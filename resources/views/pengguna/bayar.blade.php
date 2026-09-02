@extends('layout/sbpengguna')

@section('main')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Proses Pembayaran</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                                <i class="bi bi-wallet2 text-primary mb-3" style="font-size: 3rem;"></i>
                                <h4 class="card-title w-100 fw-bold">Detail Tagihan</h4>
                            </div>
                            <div class="card-body p-4">
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <table class="table table-borderless mb-4">
                                    <tr>
                                        <td class="text-muted ps-0">Bulan</td>
                                        <td class="text-end fw-semibold pe-0">{{ $tagihan->bulan }} {{ $tagihan->tahun }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-0">Pemakaian Air</td>
                                        <td class="text-end fw-semibold pe-0">{{ $tagihan->jumlah }} m&sup3;</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="text-muted ps-0 pt-3">Total Tagihan</td>
                                        <td class="text-end fw-bold text-primary fs-5 pt-3 pe-0">Rp {{ number_format($tagihan->tagihan, 0, ',', '.') }}</td>
                                    </tr>
                                </table>

                                <div class="d-grid gap-2">
                                    <button id="pay-button" class="btn btn-primary btn-lg rounded-pill fw-bold">
                                        Pilih Metode Pembayaran <i class="bi bi-arrow-right-circle ms-2"></i>
                                    </button>
                                    
                                    @if($tagihan->snap_token)
                                    <form action="{{ route('pembayaran.cancel', $tagihan->id) }}" method="POST" class="d-grid">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger rounded-pill mt-2">
                                            <i class="bi bi-arrow-counterclockwise"></i> Ganti Metode Pembayaran
                                        </button>
                                    </form>
                                    @endif

                                    <a href="{{ route('infobayar.index') }}" class="btn btn-light rounded-pill mt-2">
                                        Batal & Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <!-- Midtrans Snap JS -->
    @if(config('midtrans.is_production'))
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif

    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('{{ $tagihan->snap_token }}', {
          // Optional
          onSuccess: function(result){
            alert("Pembayaran Berhasil!");
            window.location.href = "{{ route('infobayar.index') }}";
          },
          // Optional
          onPending: function(result){
            alert("Menunggu pembayaran Anda diselesaikan!");
            window.location.href = "{{ route('infobayar.index') }}";
          },
          // Optional
          onError: function(result){
            alert("Pembayaran Gagal!");
          },
          // Optional
          onClose: function(){
            console.log('Customer closed the popup without finishing the payment');
          }
        });
      };
    </script>
@endsection
