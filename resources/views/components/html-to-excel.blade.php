@props([
    'targetTable' => '',  // ID of the table to export
    'fileName' => 'export', // Default file name
    'fileType' => 'xlsx'   // Default file type
])

<div>
    <button type="button" onclick="exportExcel_{{ $targetTable }}()" style="height: 30px;" class="btn btn-sm btn-light">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
             class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
            <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z" />
            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
        </svg>
        Export
    </button>
</div>

@once
    @push('scripts')
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.6/xlsx.full.min.js"></script>
    @endpush
@endonce

@push('scripts')
    <script type="text/javascript">
        function exportExcel_{{ $targetTable }}() {
            let export_table = document.getElementById('{{ $targetTable }}');
            if (export_table) {
                let file = XLSX.utils.table_to_book(export_table, { sheet: "Sheet1" });

                XLSX.write(file, {
                    bookType: '{{ $fileType }}',
                    bookSST: true,
                    type: 'base64'
                });

                XLSX.writeFile(file, '{{ $fileName }}.{{ $fileType }}');
            } else {
                alert('Table Not Found');
            }
        }
    </script>
@endpush

