<!doctype html>
<html>
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Pembayaran Dikonfirmasi</title>
  <style>body{font-family:system-ui,Segoe UI,Roboto,Arial;text-align:center;padding:30px}</style>
</head>
<body>
  <h2>Terima kasih — Pembayaran dikonfirmasi</h2>
  <p>Anda dapat menutup jendela ini.</p>

  <script>
    // Tutup jendela otomatis (hanya bekerja bila jendela dibuka dari JS)
    setTimeout(() => {
      try { window.close(); } catch (e) {}
      // Jika tidak bisa close (karena manual scan), redirect ke halaman sukses agar user lihat konfirmasi
      window.location.href = "{{ route('konsultan.bayar.sukses') }}";
    }, 1500);
  </script>
</body>
</html>
