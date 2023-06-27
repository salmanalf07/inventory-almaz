document.getElementById("exportButton").addEventListener("click", function () {
    var wb = XLSX.utils.table_to_book(document.getElementById("tableId"), {
        sheet: "Sheet JS",
    });
    var wbout = XLSX.write(wb, {
        bookType: "xlsx",
        bookSST: true,
        type: "binary",
        cellStyles: true, // Menambahkan opsi cellStyles
        cellNF: false, // Menonaktifkan opsi cellNF
        cellDates: false, // Menonaktifkan opsi cellDates
        sheet: "Sheet JS",
        strip: false, // Menonaktifkan opsi strip
    });

    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xff;
        return buf;
    }

    var blob = new Blob([s2ab(wbout)], {
        type: "application/octet-stream",
    });
    var url = URL.createObjectURL(blob);
    var a = document.createElement("a");
    a.href = url;
    a.download = "filename.xlsx";
    a.click();
    setTimeout(function () {
        URL.revokeObjectURL(url);
    }, 0);
});
