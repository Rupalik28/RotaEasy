import { displayValueCounts } from './display-value-count.js';

export function countAllValuesForAll(data) {
    var allValueCounts = {};

    // Start from the 3rd column (index 2) since the first two are "Date" and "Day"
    for (var colIndex = 2; colIndex < data[0].length; colIndex++) {
        var employeeName = data[0][colIndex];  // Get the employee name from the header row

        if (!employeeName) continue; // Skip if the column header is empty (no employee)

        // Initialize an empty object for this employee
        var valueCounts = {};

        // Loop through rows of data for each employee, starting from row index 3 (leave data starts here)
        for (var rowIndex = 3; rowIndex < data.length; rowIndex++) {
            var value = data[rowIndex][colIndex].trim();

            // If the value is not empty, count it
            if (value) {
                if (valueCounts[value] === undefined) {
                    valueCounts[value] = 1;  // Initialize count for this value
                } else {
                    valueCounts[value]++;  // Increment the count if the value is already encountered
                }
            }
        }

        // Store the result for this employee
        allValueCounts[employeeName] = valueCounts;
    }

    console.log('All Value Counts:', allValueCounts); // Log the counts
    displayValueCounts(allValueCounts);
    return allValueCounts;
}