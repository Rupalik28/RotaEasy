import { disableEditInFilterMode } from './disable-editing-mode.js';
import { countAllValuesForAll } from './count-all-values-for-all.js';

// Filter by month
export function filterByMonth(monthFilterSelect, originalData, hot) {
    console.log('Filtering by month');
    const month = monthFilterSelect.value;
    if (!month) {
        alert('Please select a month.');
        return;
    }

    const monthIndex = parseInt(month, 10) - 1;
    const filteredData = originalData.slice(1).filter(row => {
        const cellDate = new Date(row[0]);
        return cellDate.getMonth() === monthIndex;
    });

    // Insert headers back into the filtered data
    const finalData = [originalData[0], originalData[1], originalData[2], ...filteredData];
    hot.loadData(finalData);

    // Call the value counting function after filtering
    console.log('Data passed to counting function:', finalData);
    var valueSummary = countAllValuesForAll(finalData);
    console.log("Summary of all values for filtered team:", valueSummary);

    disableEditInFilterMode(hot);

    console.log('Filtered data by month:', finalData);
}