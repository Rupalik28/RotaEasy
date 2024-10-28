import { populateDropdown } from './elements/populate-dropdown.js';
import { getExport } from './elements/export-excel.js';
import { filterByDateRange } from './elements/filter-by-date-range.js';
import { filterByLocation } from './elements/filter-by-location.js';
import { filterByTeam } from './elements/filter-by-team.js';
import { filterByYear } from './elements/filter-by-year.js';
import { showEmployeeDataInCard } from './elements/emp-data-card.js';
import { countAllValuesForAll } from './elements/count-all-values-for-all.js';
import { filterByMonth } from './elements/filter-by-month.js';

// Initialize Handsontable variables
let hot;
let undoStack = [];
let redoStack = [];
let originalData = []; // Store the original data

// Select DOM elements
const container = document.querySelector('#example1');
const exampleConsole = document.querySelector('#output');
const autosave = document.querySelector('#autosave');
const autosaveLabel = document.querySelector('#autosaveLabel');
const load = document.querySelector('#load');
const save = document.querySelector('#save');
const addRow = document.querySelector('#add-row');
const addColumn = document.querySelector('#add-column');
const undo = document.querySelector('#undo');
const redo = document.querySelector('#redo');
const startDateInput = document.querySelector('#start-date');
const endDateInput = document.querySelector('#end-date');
const dateFilterButton = document.querySelector('#filter-date');
const monthFilterSelect = document.querySelector('#month-filter');
const monthFilterButton = document.querySelector('#filter-month');
const yearFilterSelect = document.querySelector('#yearFilter');
const TeamFilterSelect = document.querySelector('#teamFilter');
const locFilterSelect = document.querySelector('#locFilter');
const clearFilterButton = document.querySelector('#clear-filters'); // Add a clear filters button
const exportExcelButton = document.querySelector('#export-button'); // Add a clear filters button

const daysDropdown = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

// Initialize the variables
let teamDropdown = [];  // Default values
let locationDropdown = []; // Default values

// Fetch data from the PHP endpoint
fetch('../server/load_dropdown_data.php')
    .then(response => response.json())
    .then(data => {
        if (data.teams && data.locations) {
            // Assign fetched data to the dropdown variables
            teamDropdown = data.teams.length ? data.teams : teamDropdown;
            locationDropdown = data.locations.length ? data.locations : locationDropdown;

            // Log the data for verification
            console.log('Teams:', teamDropdown);
            console.log('Locations:', locationDropdown);

            // Populate the dropdowns
            populateDropdown('teamFilter', teamDropdown);
            populateDropdown('locFilter', locationDropdown);
        } else {
            console.error('Failed to fetch dropdown data.');
        }
    })
    .catch(error => console.error('Error fetching data:', error));

// Initialize Handsontable
function initializeHandsontable() {
    hot = new Handsontable(container, {
        startRows: 8,
        startCols: 6,
        rowHeaders: true,
        colHeaders: true,
        stretchH: 'all',
        //colWidths: [200, 100, 100],
        //height: 'auto',
        height: 400,
        licenseKey: 'non-commercial-and-evaluation',
        contextMenu: {
            items: {
                "row_above": { name: 'Insert row above' },
                "row_below": { name: 'Insert row below' },
                "col_left": { name: 'Insert column on the left' },
                "col_right": { name: 'Insert column on the right' },
                "remove_row": { name: 'Delete row', callback() { hot.alter('remove_row', hot.getSelected()[0][0]); } },
                "remove_col": { name: 'Delete column', callback() { hot.alter('remove_col', hot.getSelected()[0][1]); } },
                "undo": { name: 'Undo' },
                "redo": { name: 'Redo' }
            }
        },
        afterChange(change, source) {
            if (source === 'loadData') return;
            if (!change) return;
            if (!autosave.checked) return;
            fetch('../server/save.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ data: hot.getData() }),
            }).then(() => {
                exampleConsole.innerText = `Autosaved (${change.length} cell${change.length > 1 ? 's' : ''})`;
                console.log('Data autosaved');
            });
        },
        afterOnCellMouseDown(event, coords) {
            // Ensure we are clicking on the header row and after the second column
            if (coords.row === 0 && coords.col > 1) {
                const employeeName = hot.getDataAtCell(0, coords.col); // Get employee name from the header row
                if (employeeName) {
                    showEmployeeDataInCard(employeeName, coords.col, hot); // Pass both the name and column index
                }
            }
        },
        cells(row, col) {

            const cellProperties = {};
            if (row > 2 && col === 0) {
                cellProperties.type = 'date';
                cellProperties.dateFormat = 'YYYY-MM-DD';
            }
            if (row > 2 && col === 1) {
                cellProperties.type = 'dropdown';
                cellProperties.source = daysDropdown;
            }
            if (row === 1 && col > 1) {
                cellProperties.type = 'dropdown';
                cellProperties.source = teamDropdown;
            }
            if (row === 2 && col > 1) {
                cellProperties.type = 'dropdown';
                cellProperties.source = locationDropdown;
            }
            if (hot) {
                const cellValue = hot.getDataAtCell(row, col);
                switch (cellValue) {
                    case 'Sunday': case '0': cellProperties.className = 'grey-background'; break;
                    case '2': cellProperties.className = 'orange-background'; break;
                    case 'g': cellProperties.className = 'light-blue-background'; break;
                    case 'SL': case 'PL': case 'L': cellProperties.className = 'red-background'; break;
                    case '1': case 'OD1': cellProperties.className = 'yellow-background'; break;
                    case '3': cellProperties.className = 'blue-background'; break;
                    case 'OD2': cellProperties.className = 'orange-background'; break;
                    case 'HDL': case 'G': cellProperties.className = 'sky-blue-background'; break;
                    default: cellProperties.className = 'default-background'; break;
                }
            }
            // Make the first row bold
            if (row === 0) {
                cellProperties.className = 'bold'; // Add a class for bold
            }

            //make cells read only
            if ((row > 0 && col < 2) && row < 3) {
                cellProperties.readOnly = true;
                cellProperties.className = 'default-background';
            }

            return cellProperties;
        },
        autoWrapRow: true,
        autoWrapCol: true,
        dateFormat: 'YYYY-MM-DD',
        filters: true,
        fixedRowsTop: 3, // Fix the top 3 rows
    });

}

// Function to scroll to a specific date
// Function to scroll to a specific date
// Function to scroll to a specific date
// Function to scroll to a specific date
function scrollToDate(targetDate) {
    const formattedDate = targetDate.toISOString().split('T')[0]; // Format as 'YYYY-MM-DD'
    console.log('Target Date:', formattedDate);

    // Check if originalData is defined and not empty
    if (!originalData || originalData.length === 0) {
        console.log('Original data is empty or not defined.');
        return;
    }

    // Find the index of the row with the target date
    const rowIndex = originalData.findIndex(row => row[0] === formattedDate);
    console.log('Row Index:', rowIndex);

    if (rowIndex !== -1) {
        // Select the cell in the first column of the found row
        hot.selectCell(rowIndex, 0); // rowIndex, colIndex
        console.log(`Selected Cell: [${rowIndex}, 0]`);

        // Scroll to the selected row index
        hot.scrollViewportTo(rowIndex, 0); // This scrolls to the row

        // Ensure that the selected row is at the top
        // This will scroll up the viewport
        setTimeout(() => {
            hot.rootElement.scrollTop = hot.getRowHeight() * rowIndex; // Manually set scrollTop
        }, 50); // Delay to allow the render to complete
    } else {
        console.log('Target date not found in the data.');
    }
}


// Initialize Handsontable on page load
initializeHandsontable();


// Export to Excel functionality
exportExcelButton.addEventListener('click', () => getExport(hot));

// Load data
load.addEventListener('click', () => {
    if (!hot) return;

    fetch('../server/load.php')
        .then(response => response.json())
        .then(data => {
            if (!Array.isArray(data.data)) {
                exampleConsole.innerText = 'Data format is incorrect';
                return;
            }

            originalData = data.data; // Store the original data
            hot.updateSettings({ colHeaders: data.headers || [] });
            hot.loadData(originalData);  // Load the data

            
            // Get the current date
            // const specificDate = new Date(); // This will give you the current date and time

            // // Format the current date to 'YYYY-MM-DD'
            // const formattedCurrentDate = specificDate.toISOString().split('T')[0]; // 'YYYY-MM-DD'

            // // Scroll to the current date
            // scrollToDate(new Date(formattedCurrentDate));
                        // Get the current date
                        const specificDate = new Date(); // This will give you the current date and time

                        // Get the first date of the current month
                        const firstDateOfCurrentMonth = new Date(specificDate.getFullYear(), specificDate.getMonth(), 2);
            
                        // Scroll to the first date of the current month
                        scrollToDate(firstDateOfCurrentMonth);


            // Now call the value counting function after data is loaded
            var valueSummary = countAllValuesForAll(originalData);
            console.log("Summary of all values for all employees: ", valueSummary);

            exampleConsole.innerText = 'Data loaded';
        })
        .catch(error => {
            exampleConsole.innerText = 'Error loading data';
            console.error('Error loading data:', error);
        });
});

// Save data
save.addEventListener('click', () => {
    if (!hot) return;

    fetch('../server/save.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ data: hot.getData() }),
    }).then(() => {
        exampleConsole.innerText = 'Data saved';
        console.log('Data saved');
    }).catch(error => {
        exampleConsole.innerText = 'Error saving data';
        console.error('Error saving data:', error);
    });
});

// Autosave toggle
autosave.addEventListener('click', () => {
    exampleConsole.innerText = autosave.checked ? 'Changes will be autosaved' : 'Changes will not be autosaved';
});

// Add new row
addRow.addEventListener('click', () => {
    if (!hot) return;

    const rowCount = hot.countRows();
    const newRow = new Array(hot.countCols()).fill('');

    // Check if there are any existing rows
    if (rowCount > 0) {
        // Get the current date from the last row
        const lastDateValue = hot.getDataAtCell(rowCount - 1, 0); // Assuming the date is in the first column
        console.log('Last date value:', lastDateValue); // Log the last date value
        const lastDate = new Date(lastDateValue);

        // Validate lastDate
        if (isNaN(lastDate.getTime())) {
            console.error('Invalid date in the last row:', lastDateValue);
            // Set to today's date if the last date is invalid
            const today = new Date();
            newRow[0] = today.toISOString().split('T')[0]; // Format to YYYY-MM-DD
            newRow[1] = daysDropdown[today.getDay()]; // Get the corresponding day name
        } else {
            const nextDate = new Date(lastDate);
            nextDate.setDate(lastDate.getDate() + 1); // Increment the date by 1

            // Set the next day's date and day
            newRow[0] = nextDate.toISOString().split('T')[0]; // Format to YYYY-MM-DD
            newRow[1] = daysDropdown[nextDate.getDay()]; // Get the corresponding day name
        }
    } else {
        // No previous rows, set to today's date and day
        const today = new Date();
        newRow[0] = today.toISOString().split('T')[0]; // Format to YYYY-MM-DD
        newRow[1] = daysDropdown[today.getDay()]; // Get the corresponding day name
    }

    // Add the new row to Handsontable
    hot.updateSettings({
        data: [...hot.getData(), newRow]
    });
});

// Add new column
addColumn.addEventListener('click', () => {
    if (!hot) return;

    const colCount = hot.countCols();
    hot.updateSettings({
        colHeaders: [...hot.getSettings().colHeaders, `Column ${colCount + 1}`]
    });
    hot.updateSettings({
        data: hot.getData().map(row => [...row, ''])
    });
});



monthFilterSelect.addEventListener('change', ()=> filterByMonth(monthFilterSelect, originalData, hot));

// const yearFilterSelect = document.querySelector('#yearFilter');
yearFilterSelect.addEventListener('change', () => filterByYear(yearFilterSelect, originalData, hot));

// Add event listener for team filter
TeamFilterSelect.addEventListener('change', () => filterByTeam(TeamFilterSelect, originalData, hot));

// Add event listener for location filter
locFilterSelect.addEventListener('change', () => filterByLocation(locFilterSelect, originalData, hot));

// Event listeners for filter buttons
dateFilterButton.addEventListener('click', () => filterByDateRange(startDateInput, endDateInput, originalData, hot));
// dateFilterButton.addEventListener('click', filterByDateRange);
monthFilterButton.addEventListener('click', filterByMonth);

// hot.loadData(originalData);
document.getElementById('refreshButton').addEventListener('click', function () {
    location.reload();
});