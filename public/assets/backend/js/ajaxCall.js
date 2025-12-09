function createTable(headerData, fullResponse) {

    const tableDiv = document.getElementById("report_table");
    tableDiv.innerHTML = "";

    /** Insert letter head only once **/
    if (fullResponse.letterHead && !document.querySelector("#letterHeadContainer")) {
        const letterHead = document.createElement("div");
        letterHead.id = "letterHeadContainer";
        letterHead.innerHTML = fullResponse.letterHead;
        tableDiv.parentNode.insertBefore(letterHead, tableDiv);
    }

    const table = document.createElement("table");
    table.className = "table table-bordered table-striped table-sm";

    const thead = document.createElement("thead");
    const tBody = document.createElement("tbody");

    /** Header Row **/
    const headerRow = document.createElement("tr");
    headerRow.appendChild(createCell("th", "क्र.सं."));

    headerData.forEach((title) => {
        const th = createCell("th", title);
        th.className = "text-nowrap";
        headerRow.appendChild(th);
    });

    thead.appendChild(headerRow);
    table.appendChild(thead);

    /** Table Body **/
    const fragment = new DocumentFragment();
    let bodyData = fullResponse.data ?? [];

    bodyData.forEach((rowData, key) => {
        const row = document.createElement("tr");

        row.appendChild(createCell("td", getNepaliNumber(key + 1)));

        Object.entries(rowData).forEach(([keyName, value]) => {
            if (Array.isArray(value)) {
                row.appendChild(renderChildTable(keyName, value));
            } else {
                row.appendChild(createCell("td", value));
            }
        });

        fragment.appendChild(row);
    });

    /** Footer/Total Rows **/
    (fullResponse.total ?? []).forEach((rowData) => {
        const row = document.createElement("tr");

        Object.values(rowData).forEach((col) => {
            const cell = createCell("td", col.data || "");

            if (col.colSpan) cell.colSpan = col.colSpan;
            if (col.rowSpan) cell.rowSpan = col.rowSpan;
            if (col.class) cell.className = col.class;

            row.appendChild(cell);
        });

        fragment.appendChild(row);
    });

    tBody.appendChild(fragment);
    table.appendChild(tBody);
    tableDiv.appendChild(table);
}


/****************** Helper Functions ******************/

function createCell(tag, text) {
    const cell = document.createElement(tag);
    cell.textContent = text ?? "";
    return cell;
}

function renderChildTable(label, children) {
    const container = document.createElement("td");

    if (!children.length) {
        container.textContent = "No Data Found";
        return container;
    }

    const table = document.createElement("table");
    table.className = "table table-bordered table-striped table-condensed";

    const thead = document.createElement("thead");
    const headRow = document.createElement("tr");

    headRow.appendChild(createCell("th", "क्र.सं"));
    Object.keys(children[0]).forEach((field) => {
        headRow.appendChild(createCell("th", field));
    });

    thead.appendChild(headRow);
    table.appendChild(thead);

    const tbody = document.createElement("tbody");

    children.forEach((child, idx) => {
        const row = document.createElement("tr");
        row.appendChild(createCell("td", idx + 1));

        Object.values(child).forEach((val) => {
            row.appendChild(createCell("td", val));
        });

        tbody.appendChild(row);
    });

    table.appendChild(tbody);
    container.appendChild(table);
    return container;
}

function getHeader(data) {
    let headerData = [];
    Object.keys(data[0] ?? {}).forEach((key) => {
        if (!Array.isArray(data[0][key])) {
            headerData.push(key);
        }
    });
    return headerData;
}

function getNepaliNumber(data) {
    const english = ['1','2','3','4','5','6','7','8','9','0'];
    const nepali  = ['१','२','३','४','५','६','७','८','९','०'];

    return data.toString().replace(/[0-9]/g, digit => nepali[english.indexOf(digit)]);
}


/****************** AJAX + UI Handling ******************/

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document.body).delegate('#report-filter-form', 'submit', function (e) {
        e.preventDefault();

        const url = $(this).attr('data-bs-url');
        const submitBtn = $("#submitFormBtn");
        const collapseFilterForm = $("#collapseFilterForm");

        $.ajax({
            type: "post",
            url: url,
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                submitBtn.prop('disabled', true).html("<i class='fa fa-spinner fa-spin'></i>");
            },
            success: function (resp) {
                submitBtn.prop('disabled', false).html("पेश गर्नुहोस्");
                collapseFilterForm.collapse('hide');

                const headerData = getHeader(resp.data);
                createTable(headerData, resp);
            },
            error: function (xhr) {
                submitBtn.prop('disabled', false).html("पेश गर्नुहोस्");
                toastMessage('error', xhr.responseJSON.message);
            }
        });
    });

    function toastMessage(type, title) {
        swal.fire({
            title: title,
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            width: 450,
            timer: 3000,
            timerProgressBar: true,
            icon: type,
        });
    }
});
