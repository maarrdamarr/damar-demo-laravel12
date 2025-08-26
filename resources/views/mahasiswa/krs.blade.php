@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Kartu Rencana Studi (KRS)</h1>

<form method="POST" action="{{ route('mhs.krs.submit') }}" class="mb-6">
  @csrf
  <input type="hidden" name="semester" value="{{ $semester }}">
  <div class="p-4 bg-white rounded shadow">
    <div class="mb-3 font-semibold">Pilih Kelas (Semester {{ $semester }})</div>
    <div class="grid md:grid-cols-2 gap-3">
      @foreach($classes as $c)
      <label class="flex items-start gap-3 p-3 border rounded hover:bg-gray-50">
        <input type="checkbox" name="class_ids[]" value="{{ $c->id }}" class="mt-1">
        <div>
          <div class="font-medium">{{ $c->course->code }} - {{ $c->course->name }} ({{ $c->class_code }})</div>
          <div class="text-xs text-gray-500">
            SKS {{ $c->course->credits }} •
            {{ $c->day ?? '-' }} {{ $c->time ?? '' }} •
            Dosen: {{ $c->lecturer->name ?? '-' }} •
            Kuota: {{ $c->quota }}
          </div>
        </div>
      </label>
      @endforeach
    </div>
    <div class="mt-4 flex items-center justify-between">
      <div>{{ $classes->links() }}</div>
      <button class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Ajukan KRS</button>
    </div>
  </div>
</form>

<div class="p-4 bg-white rounded shadow">
  <div class="mb-3 font-semibold">KRS Saya ({{ $semester }})</div>
  <table class="w-full text-sm">
    <thead>
      <tr class="text-left border-b">
        <th class="py-2">Matkul</th>
        <th>SKS</th>
        <th>Kelas</th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($myPlans as $p)
      <tr class="border-b">
        <td class="py-2">{{ $p->courseClass->course->code }} - {{ $p->courseClass->course->name }}</td>
        <td>{{ $p->courseClass->course->credits }}</td>
        <td>{{ $p->courseClass->class_code }}</td>
        <td>
          <span class="px-2 py-0.5 rounded text-xs bg-gray-100">{{ $p->status }}</span>
        </td>
        <td class="text-right">
          <form method="POST" action="{{ route('mhs.krs.drop', $p) }}" onsubmit="return confirm('Hapus dari KRS?')">
            @csrf @method('DELETE')
            <button class="text-red-600 hover:underline">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="5" class="py-3 text-center text-gray-500">Belum ada KRS</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
