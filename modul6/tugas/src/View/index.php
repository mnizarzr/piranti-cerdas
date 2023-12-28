<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data MPU</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    <table id="main_table">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Sumbu X</th>
                <th>Sumbu Y</th>
                <th>Sumbu Z</th>
                <th>Kemiringan</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <script>
        var table = document.getElementById("main_table");

        const source = new EventSource('//127.0.0.1:8071');

        source.onopen = function() {
            console.log("Connection to server opened.");
        };

        source.onmessage = function(e) {
            console.log(e.data);
        };

        source.onerror = function() {
            console.log("EventSource failed.");
        };

        source.addEventListener('mpus', function(event) {
            var data = JSON.parse(event.data)
            for (const val of data) {
                let newRow = table.insertRow();
                newRow.insertCell().appendChild(document.createTextNode(val.datetime));
                newRow.insertCell().appendChild(document.createTextNode(val.x));
                newRow.insertCell().appendChild(document.createTextNode(val.y));
                newRow.insertCell().appendChild(document.createTextNode(val.z));
                newRow.insertCell().appendChild(document.createTextNode(val.tilt));
            }

            if (source.readyState == source.CLOSED) {
                source.close();
            }
        }, false);
    </script>
</body>

</html>
