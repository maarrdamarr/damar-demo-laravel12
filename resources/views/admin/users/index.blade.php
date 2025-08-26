@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Manajemen User</h1>

<a href="{{ route('users.create') }}" class="inline-block mb-4 px-4 py-2 rounded bg-indigo-600 text-white">+ User Baru</a>

<div class="bg-white rounded shadow overflow-x-auto">
<table class="w-full text-sm">
  <thead>
    <tr class="text-left border-b">
      <th class="py-2 px-3">Nama</th>
      <th class="px-3">Email</th>
      <th class="px-3">Role</th>
      <th class="px-3 text-right">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $u)
    <tr class="border-b">
      <td class="py-2 px-3">{{ $u->name }}</td>
      <td class="px-3">{{ $u->email }}</td>
      <td class="px-3">
        @foreach($u->getRoleNames() as $r)
          <span class="px-2 py-0.5 rounded text-xs bg-gray-100">{{ $r }}</span>
        @endforeach
      </td>
      <td class="px-3 text-right">
        <a href="{{ route('users.edit',$u) }}" class="text-indigo-600 hover:underline">Edit</a>
        <form action="{{ route('users.destroy',$u) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Hapus user?')">
          @csrf @method('DELETE')
          <button class="text-red-600 hover:underline">Hapus</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
