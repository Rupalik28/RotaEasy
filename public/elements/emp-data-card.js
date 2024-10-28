
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

import { countAllValuesForAll } from './count-all-values-for-all.js';

export function showEmployeeDataInCard(employeeName, employeeColIndex, hot) {
    // Get the table data
    const data = hot.getData();

    // Count all unique values for each employee (including the selected employee)
    const allValueCounts = countAllValuesForAll(data);

    // Get the specific value counts for the selected employee
    const employeeValueCounts = allValueCounts[employeeName] || {};

    // Create a wrapper for horizontal layout
    const wrapper = document.createElement('div');
    wrapper.classList.add('value-counts');
    //wrapper.classList.add('value-row');

    // Create HTML for the employee's name
    const employeeHTML = `<strong>${employeeName}:&nbsp;</strong> `;
    wrapper.innerHTML += employeeHTML;

    // Display the value counts for this employee
    for (let value in employeeValueCounts) {
        const count = employeeValueCounts[value];
        const mapping = valueMapping[value];

        if (mapping) {
            // If the value exists in the mapping, display its full name with color
            wrapper.innerHTML += `<span class="${mapping.class}">${mapping.name}: <strong>${count}</strong></span> `;
        } else {
            // Handle values that are not in the mapping
            wrapper.innerHTML += `<span class="default-background">${value}: <strong>${count}</strong></span>&nbsp; `;
        }
    }

    // Insert the HTML into the card's content div
    const valueCountsContent = document.getElementById('valueCountsContent');
    valueCountsContent.innerHTML = ''; // Clear previous content
    valueCountsContent.appendChild(wrapper);
}