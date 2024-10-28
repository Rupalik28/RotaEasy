<!-- Bootstrap Modal -->
<div class="modal fade" id="valueMappingModal" tabindex="-1" aria-labelledby="valueMappingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="valueMappingModalLabel">Codes Meaning</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Table to display the data -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody id="valueMappingTableBody">
                        <!-- Rows will be inserted here by JavaScript -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Button to Open Modal -->
<button type="button" class="form-control" style="width: auto;" data-bs-toggle="modal" data-bs-target="#valueMappingModal">
<?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8 6.00067L21 6.00139M8 12.0007L21 12.0015M8 18.0007L21 18.0015M3.5 6H3.51M3.5 12H3.51M3.5 18H3.51M4 6C4 6.27614 3.77614 6.5 3.5 6.5C3.22386 6.5 3 6.27614 3 6C3 5.72386 3.22386 5.5 3.5 5.5C3.77614 5.5 4 5.72386 4 6ZM4 12C4 12.2761 3.77614 12.5 3.5 12.5C3.22386 12.5 3 12.2761 3 12C3 11.7239 3.22386 11.5 3.5 11.5C3.77614 11.5 4 11.7239 4 12ZM4 18C4 18.2761 3.77614 18.5 3.5 18.5C3.22386 18.5 3 18.2761 3 18C3 17.7239 3.22386 17.5 3.5 17.5C3.77614 17.5 4 17.7239 4 18Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</button>

<script>
    const valueMapping = {
    'WH': { name: 'Work from Home', class: 'light-blue-background value-counts' },
    'HO': { name: 'Holiday', class: 'grey-background value-counts' },
    'PL': { name: 'Privilege Leave', class: 'red-background value-counts' },
    'L': { name: 'Leave', class: 'red-background value-counts' },
    'SL': { name: 'Sick Leave', class: 'red-background value-counts' },
    'HD': { name: 'Half Day Leave', class: 'sky-blue-background value-counts' },
    'CO': { name: 'Compensatory Off', class: 'yellow-background value-counts' },
    'CR': { name: 'Change Role', class: 'blue-background value-counts' },
    'PR': { name: 'Problem Role', class: 'orange-background value-counts' },
    'OD': { name: 'Officer of Day', class: 'orange-background value-counts' },
    '0': { name: 'Sunday', class: 'grey-background value-counts' },
    '1': { name: 'First Shift', class: 'yellow-background value-counts' },
    '2': { name: 'Second Shift', class: 'orange-background value-counts' },
    '3': { name: 'Third Shift', class: 'blue-background value-counts' },
    'OD1': { name: 'Officer of Day 1', class: 'yellow-background value-counts' },
    'OD2': { name: 'Officer of Day 2', class: 'orange-background value-counts' },
};

// Function to populate the table
function populateValueMappingTable() {
    const tableBody = document.getElementById("valueMappingTableBody");
    tableBody.innerHTML = ""; // Clear previous rows

    for (const code in valueMapping) {
        const row = document.createElement("tr");

        // Apply the class for background color
        row.className = valueMapping[code].class;

        // Code column
        const codeCell = document.createElement("td");
        codeCell.textContent = code;
        row.appendChild(codeCell);

        // Name column
        const nameCell = document.createElement("td");
        nameCell.textContent = valueMapping[code].name;
        row.appendChild(nameCell);

        tableBody.appendChild(row);
    }
}

// Call populateValueMappingTable function when modal is shown
document.getElementById("valueMappingModal").addEventListener("shown.bs.modal", populateValueMappingTable);

</script>