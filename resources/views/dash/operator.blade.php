@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Dashboard Operator Prodi</h1>
<p class="text-sm text-gray-600 mb-4">Kelola kurikulum, mata kuliah, dan kelas di menu <b>Master Data</b>.</p>
<div class="grid md:grid-cols-3 gap-4">
  <x-stat title="Program Studi" :value="\App\Models\Program::count()" />
  <x-stat title="Mata Kuliah" :value="\App\Models\Course::count()" />
  <x-stat title="Kelas Aktif" :value="\App\Models\CourseClass::count()" />
</div>
@endsection
