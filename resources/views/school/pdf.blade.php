<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>School List</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style>
            td{ font-size: 15px; }
        </style>
    </head>
    <body>
        <table class="table">
            <tr>
                <td></td><td></td>
                <td  class="text-center text-info"><h2>School List</h2></td>
                <td></td><td></td>
            </tr>
            <tr class="bg-dark text-white">
                <th>Sl.</th>
                <th>School</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
            </tr>
            <tbody>
                @php
                    $count = 0;
                @endphp
                @foreach($schoolData as $school)
                    <tr>
                        <td>{{ ++$count }}.</td>
                        <td>
                            @php
                                echo wordwrap($school->name, 20, "<br>\n", TRUE)
                            @endphp
                        </td>
                        <td>
                            @php
                                echo wordwrap($school->email, 20, "<br>\n", TRUE)
                            @endphp
                        </td>
                        <td>
                            @php
                                echo wordwrap($school->phone, 20, "<br>\n", TRUE)
                            @endphp
                        </td>
                        <td>
                            @php
                                echo wordwrap($school->address, 20, "<br>\n", TRUE)
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>