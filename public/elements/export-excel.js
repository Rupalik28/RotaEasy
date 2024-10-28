export function getExport(hot) {
    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.aoa_to_sheet(hot.getData());
    XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");

    // Export the workbook to an Excel file
    XLSX.writeFile(workbook, 'handsontable-data.xlsx');
}