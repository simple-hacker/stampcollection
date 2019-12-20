<div class="flex flex-wrap bg-white shadow rounded py-2 px-4 mt-3 mb-3">
    <browse-catalogue-dropdown
        v-bind:years="{{ $years }}"
        v-bind:year="{{ $year ?? date('Y') }}"
    />
</div>