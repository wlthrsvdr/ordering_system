<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Password details</title>
    <style>
        body {
            font-family: 'Calibri', sans-serif;
        }

    </style>
</head>

<body>

    <table style="width: 500px; border: 1px dotted #323232; padding: 15px;">
        <tr>
            <td>
                <table style="width: 100%">
                    <tr style="font-size: 24px;">
                        <td><strong>Request Approval DETAILS</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                Your request has been approved by the admin. Please see below for your reference number.<br><br><br>
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                ---Reference Number---
            </td>
        </tr>
        <tr>
            <td style="letter-spacing: 2px; text-align: center;"><a
                    href=""><strong>{{ $reference_number }}</strong></a>
            </td>
        </tr>
        <tr style="margin-top-top: 40px;">
            <td><br><br><br>Please ignore this message if you didn't request and send a report to our contact us
                form.<br><br><br></td>
        </tr>
        <tr style="margin-top-top: 50px">
            <td>Regards,<br>Support Team</td>
        </tr>
    </table>
</body>

</html>
