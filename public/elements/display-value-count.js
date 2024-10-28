
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

export function displayValueCounts(valueCounts) {
    const valueCountsContent = document.getElementById('valueCountsContent');
    valueCountsContent.innerHTML = ''; // Clear existing content

    // Create a wrapper for horizontal layout
    const wrapper = document.createElement('div');
    wrapper.classList.add('value-row');

    for (const [employee, counts] of Object.entries(valueCounts)) {
        const employeeDiv = document.createElement('div');
        employeeDiv.classList.add('value-counts');
        employeeDiv.innerHTML = `<strong>${employee}: </strong>`;

        // Create HTML for counts using value mapping
        const countsHTML = Object.entries(counts)
            .map(([value, count]) => {
                const mapping = valueMapping[value] || { name: value, class: 'default-background' };
                return `<span class="${mapping.class}">${mapping.name}: <strong>${count}</strong></span>`;
            })
            .join(' '); // Space for separation in horizontal layout

        employeeDiv.innerHTML += countsHTML;
        wrapper.appendChild(employeeDiv);
    }

    valueCountsContent.appendChild(wrapper);
}