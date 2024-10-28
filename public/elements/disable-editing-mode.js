export function disableEditInFilterMode(hot) {
    // Use the `beforeChange` hook to prevent editing

    // // Optionally hide the buttons
    // save.style.display = 'none';
    // addRow.style.display = 'none';
    // addColumn.style.display = 'none';
    // autosaveLabel.style.display = 'none';
    // autosave.checked = false;


    hot.updateSettings({
        beforeChange: function (changes, source) {
            // Prevent any changes from being made to the cells
            if (source === 'edit' || source === 'copy' || source === 'paste' || source === 'drag') {
                changes.length = 0; // Clear the changes array, preventing edits
                const userConfirmed = confirm('You are in filter mode. Would you like to refresh the page to clean filters?');
                if (userConfirmed) {
                    location.reload(); // Refresh the page
                }
                return false; // Prevent the action
            }
        }
    });

}