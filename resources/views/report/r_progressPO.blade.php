<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border: 1pt solid black !important;
            border-collapse: collapse;
            width: 100% !important;
            white-space: nowrap !important
        }

        tr,
        td,
        th {
            border: 1pt solid black !important;
            height: 15pt;
            padding-left: 3px;

        }

        .align-right {
            text-align: right;
        }

        .align-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <table id="reportProgress">
        <tr>
            <th>NO</th>
            <th>Customer</th>
            <th>No PO</th>
            <th>Part Name</th>
            <th>Part No</th>
            <th>Qty PO</th>
            <th>Qty Delivery</th>
            <th>Outstanding PO</th>
        </tr>
        <tbody>

        </tbody>
    </table>
</body>
<script src="assets/css/jquery/jquery.min.js"></script>
<script src="assets/js/formatNumber.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: 'edit_order',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': '{{$id}}',
            },
            success: function(data) {
                //console.log((data[0]['detail_order']).length);
                for (let i = 0; i < (data[0]['detail_order']).length; i++) {
                    $.ajax({
                        type: 'POST',
                        url: 'search_progress_po',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'po_id': data[0].detail_order[i].order_id,
                            'part_id': data[0].detail_order[i].part_id

                        },
                        success: function(dataa) {
                            var table = document.getElementById("reportProgress");
                            // Membuat elemen <tr> baru
                            var newRow = table.insertRow();

                            // Menambahkan sel pertama
                            var cell1 = newRow.insertCell();
                            var text1 = document.createTextNode('');
                            cell1.appendChild(text1);
                            cell1.classList.add("align-center");
                            //cell2
                            var cell2 = newRow.insertCell();
                            var text2 = document.createTextNode('{{$cust->code}}');
                            cell2.appendChild(text2);
                            //cell3
                            var cell3 = newRow.insertCell();
                            var text3 = document.createTextNode(data[0]['no_po']);
                            cell3.appendChild(text3);
                            //cell4
                            var cell4 = newRow.insertCell();
                            var text4 = document.createTextNode(data[0]['detail_order'][i]['parts']['part_name']);
                            cell4.appendChild(text4);
                            //cell5
                            var cell5 = newRow.insertCell();
                            var text5 = document.createTextNode(data[0]['detail_order'][i]['parts']['part_no']);
                            cell5.appendChild(text5);
                            //cell6
                            var cell6 = newRow.insertCell();
                            var text6 = document.createTextNode(formatNumberr(data[0]['detail_order'][i]['qty']));
                            cell6.appendChild(text6);
                            cell6.classList.add("align-right");
                            //cell7
                            var cell7 = newRow.insertCell();
                            var text7 = document.createTextNode(formatNumberr(dataa.qty));
                            cell7.appendChild(text7);
                            cell7.classList.add("align-right");
                            //cell8
                            var cell8 = newRow.insertCell();
                            var text8 = document.createTextNode(formatNumberr(data[0]['detail_order'][i]['qty'] - dataa.qty));
                            cell8.appendChild(text8);
                            cell8.classList.add("align-right");
                        },
                    });

                }
            },
        });
        setTimeout(function() {
            var tdElements = document.querySelectorAll("td.align-center");
            // Menghitung jumlah elemen <td> dengan kelas "center"
            var tdCount = tdElements.length;

            // Menampilkan hasil
            console.log("Jumlah elemen <td> dengan kelas 'center': " + tdCount);
            // Mengganti isi dari setiap elemen <td> dengan nomor urut
            tdElements.forEach(function(td, index) {
                td.innerHTML = (index + 1).toString();
            });
        }, 4000)

    })
</script>

</html>