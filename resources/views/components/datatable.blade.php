@props(['id', 'ajaxUrl', 'columns', 'thead'])

<div class="overflow-x-auto">
    <table id="{{ $id }}" class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            {{ $thead }}
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200"></tbody>
    </table>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#{{ $id }}').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ $ajaxUrl }}",
                columns: {!! $columns !!},
                responsive: true
            });
        });
    </script>
@endpush
