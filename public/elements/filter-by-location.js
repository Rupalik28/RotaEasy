import { disableEditInFilterMode } from './disable-editing-mode.js';
import { countAllValuesForAll } from './count-all-values-for-all.js';

export function filterByLocation(locFilterSelect, originalData, hot) {
    console.log('Filtering by location');
    const selectedLocation = locFilterSelect.value;

    if (!selectedLocation) {
        alert('Please select a location.');
        return;
    }

    // Get the index of the columns that match the selected location
    const locationColumnIndexes = [];
    for (let colIndex = 0; colIndex < originalData[2].length; colIndex++) {
        if (originalData[2][colIndex] === selectedLocation) {
            locationColumnIndexes.push(colIndex);
        }
    }

    if (locationColumnIndexes.length === 0) {
        alert('No data available for the selected location.');
        location.reload(); // Refresh the page
        return;
    }

    // Always include the first two columns (index 0 and 1)
    const filteredData = originalData.map(row => {
        const newRow = [row[0], row[1]]; // Include first two columns
        locationColumnIndexes.forEach(colIndex => {
            newRow.push(row[colIndex]); // Add location columns
        });
        return newRow;
    });

    // Load the filtered data into Handsontable
    hot.loadData(filteredData);

    // Call the value counting function after filtering
    console.log('Data passed to counting function:', filteredData);
    var valueSummary = countAllValuesForAll(filteredData);
    console.log("Summary of all values for filtered team:", valueSummary);

    disableEditInFilterMode(hot);

    console.log('Filtered data by location:', filteredData);
}