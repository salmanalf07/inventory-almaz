function formatNumber(input) {
    // Mendapatkan nilai angka yang dimasukkan
    var value = input.value;

    // Menghapus semua karakter non-angka dari nilai input
    var number = value.replace(/[^0-9]/g, "");

    // Memastikan nilai input tidak kosong
    if (number !== "") {
        // Mengkonversi nilai input menjadi pecahan ribuan
        var formattedNumber = parseInt(number, 10).toLocaleString("id-ID");

        // Mengatur nilai input yang telah diformat
        input.value = formattedNumber;
    }
}

// Mendapatkan semua elemen input dengan kelas "number-input"
var inputs = document.getElementsByClassName("number-input");

// Melakukan iterasi pada setiap elemen input
for (var i = 0; i < inputs.length; i++) {
    // Menambahkan event listener untuk setiap elemen input saat input berubah
    inputs[i].addEventListener("input", function () {
        formatNumber(this);
    });
}

// Mengatur nilai input menggunakan setValue()
function setValue(inputId, value) {
    var input = document.getElementById(inputId);
    input.value = value;
    formatNumber(input);
}

// Event handler untuk memformat nilai saat input menggunakan jQuery
$(".number-input").on("input", function () {
    formatNumber(this);
});
