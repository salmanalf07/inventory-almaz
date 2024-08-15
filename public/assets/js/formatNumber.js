function formatNumberr(number) {
    // Pisahkan bagian desimal dari angka
    var parts = number.toString().split(",");
    var integerPart = parts[0];
    var decimalPart = parts.length > 1 ? "," + parts[1] : "";

    // Format bagian integer
    var formattedInteger = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    // Gabungkan integer dan decimal part
    var finalNumber = formattedInteger + decimalPart;

    return finalNumber;
}
