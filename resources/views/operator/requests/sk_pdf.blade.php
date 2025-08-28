<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SK - {{ $req->decision_number }}</title>
<style>
  @page { margin: 2.5cm 2.2cm; }
  body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; color:#111; }
  .title { text-align:center; margin-bottom: 6px; }
  .title h1 { font-size: 16px; margin:0; text-transform: uppercase; }
  .title h2 { font-size: 13px; margin:0; font-weight: normal; }
  .hr { border-top:2px solid #000; margin:8px 0 16px; }
  .meta { margin: 12px 0 18px; }
  .meta table { width:100%; border-collapse: collapse; }
  .meta td { vertical-align: top; padding: 2px 0; }
  .section-title { font-weight:bold; text-transform: uppercase; margin: 14px 0 6px; }
  .content { text-align: justify; line-height: 1.5; }
  .ttd { margin-top: 36px; width:100%; }
  .ttd td { vertical-align: top; }
  .small { font-size: 11px; color:#444; }
</style>
</head>
<body>

<div class="title">
  <h1>{{ $org['name'] }}</h1>
  <h2>{{ $org['unit'] }}</h2>
  <div class="small">{{ $org['address'] }}</div>
</div>
<div class="hr"></div>

<div class="title" style="margin-top:10px">
  <h1>Surat Keputusan</h1>
  <div class="small">Nomor: {{ $req->decision_number }}</div>
</div>

<div class="meta">
  <table>
    <tr><td style="width:140px">Jenis Pengajuan</td><td>: {{ ucfirst($req->type) }}</td></tr>
    <tr><td>Nama Mahasiswa</td><td>: {{ $req->student->name }}</td></tr>
    <tr><td>Email</td><td>: {{ $req->student->email }}</td></tr>
    @php
      $profile = $req->student->studentProfile ?? null;
    @endphp
    @if($profile)
      <tr><td>NIM</td><td>: {{ $profile->nim }}</td></tr>
      <tr><td>Program Studi</td><td>: {{ $profile->program->name ?? '-' }}</td></tr>
      <tr><td>Semester Saat Ini</td><td>: {{ $profile->semester }}</td></tr>
    @endif
    <tr><td>Tanggal Keputusan</td><td>: {{ \Carbon\Carbon::parse($req->decision_date)->translatedFormat('d F Y') }}</td></tr>
    @if($req->effective_semester)
      <tr><td>Berlaku Semester</td><td>: {{ $req->effective_semester }}</td></tr>
    @endif
    @if($req->effective_date)
      <tr><td>Tanggal Efektif</td><td>: {{ \Carbon\Carbon::parse($req->effective_date)->translatedFormat('d F Y') }}</td></tr>
    @endif
  </table>
</div>

<div class="section-title">Menimbang</div>
<div class="content">
  Bahwa berdasarkan permohonan mahasiswa di atas dan hasil verifikasi berkas, dipandang perlu
  untuk memberikan keputusan terkait <b>{{ strtolower($req->type) }}</b>.
</div>

<div class="section-title">Mengingat</div>
<div class="content">
  Ketentuan akademik yang berlaku pada {{ $org['name'] }} dan peraturan rektor terkait
  layanan akademik mahasiswa.
</div>

<div class="section-title">Memutuskan</div>
<div class="content">
  <ol>
    @if($req->type === 'cuti')
      <li>Memberikan <b>izin cuti akademik</b> kepada mahasiswa tersebut untuk semester {{ $req->effective_semester ?? '-' }}.</li>
      <li>Selama masa cuti, mahasiswa tidak memiliki kewajiban akademik perkuliahan.</li>
    @elseif($req->type === 'pengunduran')
      <li>Menyetujui <b>pengunduran diri</b> mahasiswa tersebut terhitung sejak {{ \Carbon\Carbon::parse($req->effective_date)->translatedFormat('d F Y') }}.</li>
      <li>Segala hak dan kewajiban akademik berakhir pada tanggal efektif tersebut.</li>
    @else
      <li>Menyetujui permohonan <b>{{ $req->type }}</b> sesuai catatan pada surat ini.</li>
    @endif
    <li>Keputusan ini berlaku sejak tanggal ditetapkan.</li>
  </ol>
</div>

@if($req->reason)
<div class="section-title">Catatan Pemohon</div>
<div class="content">
  “{{ $req->reason }}”
</div>
@endif

@if($req->note)
<div class="section-title">Catatan/Koentasi</div>
<div class="content">
  {{ $req->note }}
</div>
@endif

<table class="ttd">
  <tr>
    <td style="width:60%"></td>
    <td>
      Ditetapkan di: Surabaya<br>
      Pada tanggal: {{ \Carbon\Carbon::parse($req->decision_date)->translatedFormat('d F Y') }}<br><br><br><br>
      <u>{{ $req->processor->name ?? 'Pejabat Berwenang' }}</u><br>
      <span class="small">Operator Prodi</span>
    </td>
  </tr>
</table>

</body>
</html>
