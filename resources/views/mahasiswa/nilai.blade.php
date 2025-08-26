@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Input Nilai</h1>

<div class="grid md:grid-cols-2 gap-4 mb-6">
  <div class="p-4 bg-white rounded shadow">
    <div class="font-semibold mb-2">Kelas yang Anda ampu</div>
    <ul class="text-sm list-disc ml-5">
      @forelse($classes as $c)
        <li>{{ $c->course->code }} - {{ $c->course->name }} ({{ $c->class_code }})</li>
      @empty
        <li class="text-gray-500">Belum ada kelas.</li>
      @endforelse
    </ul>
  </div>
</div>

<div class="p-4 bg-white rounded shadow">
  <div class="font-semibold mb-3">Daftar KRS</div>
  <table class="w-full text-sm">
    <thead>
      <tr class="text-left border-b">
        <th class="py-2">Mahasiswa</th>
        <th>Matkul</th>
        <th>Kelas</th>
        <th>Nilai</th>
        <th>Skor</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($plans as $p)
      <tr class="border-b">
        <td class="py-2">{{ $p->student->name }}</td>
        <td>{{ $p->courseClass->course->name }}</td>
        <td>{{ $p->courseClass->class_code }}</td>
        <td>{{ $p->result->grade ?? '-' }}</td>
        <td>{{ $p->result->score ?? '-' }}</td>
        <td>
          <form method="POST" action="{{ route('dsn.nilai.update', $p) }}" class="flex items-center gap-2">
            @csrf
            <select name="grade" class="border rounded px-2 py-1">
              @foreach(['A','A-','B+','B','B-','C+','C','D','E'] as $g)
                <option value="{{ $g }}">{{ $g }}</option>
              @endforeach
            </select>
            <input type="number" step="0.01" name="score" placeholder="Skor" class="border rounded px-2 py-1 w-24">
            <input type="text" name="notes" placeholder="Catatan" class="border rounded px-2 py-1">
            <button class="px-3 py-1 rounded bg-indigo-600 text-white">Simpan</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="py-3 text-center text-gray-500">Belum ada data KRS.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-3">{{ $plans->links() }}</div>
</div>
@endsection
