@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Master Data</h1>

<div class="grid lg:grid-cols-3 gap-6">
  {{-- Program Studi --}}
  <section class="bg-white rounded shadow p-4">
    <div class="font-semibold mb-3">Program Studi</div>
    <form method="POST" action="{{ route('opr.program.store') }}" class="flex gap-2 mb-3">
      @csrf
      <input name="code" class="border rounded px-2 py-1 w-24" placeholder="Kode">
      <input name="name" class="border rounded px-2 py-1 flex-1" placeholder="Nama Program">
      <button class="px-3 py-1 bg-indigo-600 text-white rounded">Tambah</button>
    </form>
    <ul class="text-sm divide-y">
      @foreach($programs as $p)
      <li class="py-2 flex items-center justify-between">
        <span><b>{{ $p->code }}</b> — {{ $p->name }}</span>
        <form method="POST" action="{{ route('opr.program.destroy',$p) }}" onsubmit="return confirm('Hapus prodi?')">
          @csrf @method('DELETE')
          <button class="text-red-600 hover:underline">Hapus</button>
        </form>
      </li>
      @endforeach
    </ul>
  </section>

  {{-- Mata Kuliah --}}
  <section class="bg-white rounded shadow p-4">
    <div class="font-semibold mb-3">Mata Kuliah</div>
    <form method="POST" action="{{ route('opr.course.store') }}" class="grid grid-cols-6 gap-2 mb-3">
      @csrf
      <select name="program_id" class="border rounded px-2 py-1 col-span-3">
        <option value="">Pilih Prodi</option>
        @foreach($programs as $p) <option value="{{ $p->id }}">{{ $p->name }}</option> @endforeach
      </select>
      <input name="code" class="border rounded px-2 py-1 col-span-1" placeholder="Kode">
      <input name="name" class="border rounded px-2 py-1 col-span-4" placeholder="Nama MK">
      <input name="credits" type="number" min="1" max="6" class="border rounded px-2 py-1 col-span-1" placeholder="SKS">
      <div class="col-span-6 flex justify-end">
        <button class="px-3 py-1 bg-indigo-600 text-white rounded">Tambah</button>
      </div>
    </form>
    <div class="text-sm">{{ $courses->links() }}</div>
    <ul class="text-sm divide-y mt-2">
      @foreach($courses as $c)
      <li class="py-2 flex items-center justify-between">
        <span><b>{{ $c->code }}</b> — {{ $c->name }} ({{ $c->credits }} SKS) • {{ $c->program->name }}</span>
        <form method="POST" action="{{ route('opr.course.destroy',$c) }}" onsubmit="return confirm('Hapus MK?')">
          @csrf @method('DELETE')
          <button class="text-red-600 hover:underline">Hapus</button>
        </form>
      </li>
      @endforeach
    </ul>
  </section>

  {{-- Kelas --}}
  <section class="bg-white rounded shadow p-4">
    <div class="font-semibold mb-3">Kelas Mata Kuliah</div>
    <form method="POST" action="{{ route('opr.class.store') }}" class="grid grid-cols-6 gap-2 mb-3">
      @csrf
      <select name="course_id" class="border rounded px-2 py-1 col-span-3">
        <option value="">Pilih MK</option>
        @foreach($courses as $c) <option value="{{ $c->id }}">{{ $c->code }} - {{ $c->name }}</option> @endforeach
      </select>
      <input name="class_code" class="border rounded px-2 py-1 col-span-1" placeholder="Kelas">
      <select name="lecturer_id" class="border rounded px-2 py-1 col-span-3">
        <option value="">Pilih Dosen (opsional)</option>
        @foreach($lecturers as $d) <option value="{{ $d->id }}">{{ $d->name }}</option> @endforeach
      </select>
      <input name="quota" type="number" min="1" class="border rounded px-2 py-1 col-span-1" placeholder="Kuota">
      <input name="room" class="border rounded px-2 py-1 col-span-2" placeholder="Ruang">
      <input name="day" class="border rounded px-2 py-1 col-span-1" placeholder="Hari">
      <input name="time" class="border rounded px-2 py-1 col-span-2" placeholder="Jam">
      <div class="col-span-6 flex justify-end">
        <button class="px-3 py-1 bg-indigo-600 text-white rounded">Buat</button>
      </div>
    </form>

    <div class="text-sm">{{ $classes->links() }}</div>
    <ul class="text-sm divide-y mt-2">
      @foreach($classes as $k)
      <li class="py-2 flex items-center justify-between">
        <span>
          {{ $k->course->code }} - {{ $k->course->name }} ({{ $k->class_code }})
          • Dosen: {{ $k->lecturer->name ?? '-' }} • {{ $k->day }} {{ $k->time }} • Kuota {{ $k->quota }}
        </span>
        <form method="POST" action="{{ route('opr.class.destroy',$k) }}" onsubmit="return confirm('Hapus kelas?')">
          @csrf @method('DELETE')
          <button class="text-red-600 hover:underline">Hapus</button>
        </form>
      </li>
      @endforeach
    </ul>
  </section>
</div>
@endsection
