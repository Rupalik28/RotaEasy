import { disableEditInFilterMode } from './disable-editing-mode.js';
import { countAllValuesForAll } from './count-all-values-for-all.js';

export function filterByYear(yearFilterSelect, originalData, hot) {
    console.log('Filtering by year');
    const year = yearFilterSelect.value;
    if (!year) {
        //alert('Please select a year.');
        return;
    }

    const yearInt = parseInt(year, 10);
    const filteredData = originalData.slice(1).filter(row => {
        const cellDate = new Date(row[0]);
        return cellDate.getFullYear() === yearInt;
    });

    // Insert headers back into the filtered data
    const finalData = [originalData[0], originalData[1], originalData[2], ...filteredData];
    hot.loadData(finalData);

    // Call the value counting function after filtering
    console.log('Data passed to counting function:', finalData);
    var valueSummary = countAllValuesForAll(finalData);
    console.log("Summary of all values for filtered team:", valueSummary);

    disableEditInFilterMode(hot);

    console.log('Filtered data by year:', finalData);
}