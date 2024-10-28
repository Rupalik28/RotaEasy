export function populateDropdown(elementId, data) {
    const dropdown = document.getElementById(elementId);

    // Clear existing options, except for the default placeholder option
    dropdown.innerHTML = `<option value="" disabled selected>Filter By ${elementId === 'teamFilter' ? 'Team' : 'Location'}</option>`;

    // Add new options dynamically
    data.forEach(item => {
        const option = document.createElement('option');
        option.value = item;
        option.textContent = item;
        dropdown.appendChild(option);
    });
}