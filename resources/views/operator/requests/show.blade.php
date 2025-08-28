@if($req->status==='approved')
  <a href="{{ route('opr.reqs.pdf',$req) }}"
     class="inline-block mb-4 px-4 py-2 rounded bg-gray-900 text-white"
     target="_blank" rel="noopener">
     ⬇️ Cetak / Unduh SK (PDF)
  </a>
@endif
