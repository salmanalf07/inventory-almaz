function formatNumberr(number) {
    var reversed = number.toString().split("").reverse().join("");
    var formatted = reversed.match(/\d{1,3}/g).join(".");
    return formatted.split("").reverse().join("");
}
