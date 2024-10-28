import { disableEditInFilterMode } from './disable-editing-mode.js';
import { countAllValuesForAll } from './count-all-values-for-all.js';

export function filterByDateRange(startDateInput, endDateInput, originalData, hot) {
    console.log('Filtering by date range');
    const startDate = new Date(startDateInput.value);
    const endDate = new Date(endDateInput.value);

    if (!startDate || !endDate || isNaN(startDate) || isNaN(endDate)) {
        alert('Please select valid start and end dates.');
        return;
    }

    const filteredData = originalData.slice(1).filter(row => {
        const cellDate = new Date(row[0]);
        return cellDate >= startDate && cellDate <= endDate;
    });

    // Insert headers back into the filtered data
    const finalData = [originalData[0], originalData[1], originalData[2], ...filteredData];
    hot.loadData(finalData);

    // Call the value counting function after filtering
    console.log('Data passed to counting function:', finalData);
    var valueSummary = countAllValuesForAll(finalData);
    console.log("Summary of all values for filtered team:", valueSummary);

    disableEditInFilterMode(hot);

    console.log('Filtered data by date range:', finalData);
}