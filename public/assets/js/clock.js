function countdowntimes() {
    var livedt = new Date();
    var h = livedt.getHours();
    var m = livedt.getMinutes();
    var s = livedt.getSeconds();
    m = latestTime(m);
    s = latestTime(s);

    arrbulan = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];
    date = new Date();
    hari = date.getDay();
    tanggal = date.getDate();
    bulan = date.getMonth();
    tahun = date.getFullYear();

    document.getElementById("preview").innerHTML =
        tanggal +
        " " +
        arrbulan[bulan] +
        " " +
        tahun +
        " - " +
        h +
        ":" +
        m +
        ":" +
        s;
    var t = setTimeout(countdowntimes, 500);
}
function latestTime(i) {
    if (i < 10) {
        i = "0" + i;
    } // include a zero in front of real clock numbers < 10
    return i;
}
