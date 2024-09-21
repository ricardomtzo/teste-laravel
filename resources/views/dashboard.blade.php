<x-layout>
@section('content')
    <div class="py-12">
    <div id="modal1" class="is-hidden">1</div>
<div id="modal2" class="is-hidden">2</div>
<div id="modal3" class="is-hidden">3</div>


<button  onclick="showModal('modal1')"> open 1</button>
<button  onclick="showModal('modal2')"> open 2</button>
<button  onclick="showModal('modal3')"> open 3</button>

    </div>
<style>
    .is-hidden {
  display:none;
}
</style>

<script>
    function showModal(e) {
 let el = document.querySelector('#' + e);
 el.classList.remove('is-hidden');
}
</script>
    @endsection
</x-layout>