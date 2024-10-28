import { disableEditInFilterMode } from './disable-editing-mode.js';
import { countAllValuesForAll } from './count-all-values-for-all.js';

export function filterByTeam(TeamFilterSelect, originalData, hot) {
    console.log('Filtering by team');
    const selectedTeam = TeamFilterSelect.value;

    if (!selectedTeam) {
        alert('Please select a team.');
        return;
    }

    // Get the index of the columns that match the selected team
    const teamColumnIndexes = [];
    for (let colIndex = 0; colIndex < originalData[1].length; colIndex++) {
        if (originalData[1][colIndex] === selectedTeam) {
            teamColumnIndexes.push(colIndex);
        }
    }

    if (teamColumnIndexes.length === 0) {
        alert('No data available for the selected team.');
        location.reload(); // Refresh the page
        return;
    }

    // Always include the first two columns (index 0 and 1)
    const filteredData = originalData.map(row => {
        const newRow = [row[0], row[1]]; // Include first two columns
        teamColumnIndexes.forEach(colIndex => {
            newRow.push(row[colIndex]); // Add team columns
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

    console.log('Filtered data by team:', filteredData);
}