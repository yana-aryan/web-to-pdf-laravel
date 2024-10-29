<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice</title>
</head>
@php
$align_left = "left";
$align_right="right";
$red = "red";
$grey = "grey";
$bigger = "1em";
$biggest = "1.2em";
$smaller = ".8em";
$body_max_width="1000px";
$body_width="100vw";
$body_min_width="700px";
$body_margin_y="15px";
$body_margin_x="auto";
$bigger_black = "black";
$bolder = "bold";
@endphp

<body
    style="max-width:{{$body_max_width}};min-width:{{$body_min_width}};width:{{$body_width}};margin:{{$body_margin_y}} {{$body_margin_x}};">
    <main id="target">
    <table style="width:100%">
        <tr>
            <td style="width: 50%;text-align:{{$align_left}};">
                <p style="color:{{$red}};">Invoice To</p>
                
                <p style="font-size:{{$smaller}};color:{{$grey}};">Invoice Number INV-2024-1234</p>
                <p style="font-size:{{$smaller}};color:{{$grey}};">
                    Invoice date 22 OCT 2024
                </p>
                <p style="">ARYAN KHANDELWAL</p>
            </td>
            <td style="width: 50%;text-align:{{$align_right}};">
                <p style="color: {{$red}};">Invoice From</p>
                <p>YANA TECHNOLOGY PVT</p>
                <p style="font-size:{{$smaller}};color:{{$grey}};">Near ITI Circle Jodhpur Rajasthan 342003</p>
                <p style="font-size:{{$smaller}};color:{{$grey}};">www.yana.com</p>
                <p style="font-size:{{$smaller}};color:{{$grey}};">GSTIN - 1234</p>
            </td>
        </tr>
    </table>
    <br>
    <table id="second_table" style="width:100%;border:1px solid black;border-collapse: collapse;">
        <thead>
            <tr style="border:1px solid black;text-align:left;" id="bill_header">
                <th>No</th>
                <th>Item Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Discount</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Sample (1111)</td>
                <td>$10.00</td>
                <td>2</td>
                <td>5% ($25)</td>
                <td style="font-weight:{{$bolder}}">$19.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Sample (1111)</td>
                <td>$10.00</td>
                <td>2</td>
                <td>5% ($25)</td>
                <td style="font-weight:{{$bolder}}">$19.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Sample</td>
                <td>$10.00</td>
                <td>2</td>
                <td>5% ($25)</td>
                <td style="font-weight:{{$bolder}}">$19.00</td>
            </tr>

            <tr id="four-row">
                <td></td>
                <td></td>
                <td style="font-size:{{$bigger}};color:{{$bigger_black}}">Sub total</td>
                <td></td>
                <td></td>
                <td style="font-size:{{$bigger}};color:{{$bigger_black}}">$19.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style="font-size:{{$bigger}};color:{{$bigger_black}}">Product Discount</td>
                <td></td>
                <td></td>
                <td style="font-size:{{$bigger}};color:{{$bigger_black}}">$19.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style="font-size:{{$biggest}};color:{{$bigger_black}};font-weight:{{$bolder}};">Total</td>
                <td></td>
                <td></td>
                <td style="font-size:{{$biggest}};color:{{$bigger_black}};font-weight:{{$bolder}};">$19.00</td>
            </tr>
        </tbody>
    </table>
    <table id="third_table" style="width:100%;border:1px solid black;border-collapse: collapse;">
        <tr>
            <td>GST</td>
            <td>TAXABLE VALUE</td>
            <td>CGST</td>
            <td>SGST</td>
            <td>AMOUNT</td>
        </tr>
        <tr>
            <td>5%</td>
            <td>$202</td>
            <td>$50</td>
            <td>$50</td>
            <td>$2022</td>
        </tr>
    </table>
    <br>
    <table style="width:100%">
        <tr>
            <td style="width: 50%;text-align:{{$align_left}};">
            <p style="font-size:{{$smaller}};color:{{$grey}};">7073681121</p>
            <p style="font-size:{{$smaller}};color:{{$grey}};">yana@gmail.com</p>
            </td>
            <td style="width: 50%;text-align:{{$align_right}};">
                <p style="color:{{$red}};">Payment Method</p>
                <p>Cash</p>
            </td>
        </tr>
    </table>
</main>
  <button onclick="downloadPDF(this,event)">Download Full Page as PDF</button>

    <script>
    function downloadPDF(el,e) {
        const contentToSend = document.getElementById("target").outerHTML;
        // console.log(contentToSend);
        const formData = new FormData();
        formData.append("htmlContent", contentToSend);
        console.log(formData.get("htmlContent"));
        // console.log(typeof formData);
        // console.log(typeof JSON.stringify(formData));
        fetch("{{ route('generate_pdf') }}", { // Adjust the route name accordingly
                method: "POST",
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok, status code:' + response.status);
                }
                return response.blob();
            }).then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement("a");
                a.href = url
                a.download = "generated_pdf.pdf"
                document.body.appendChild(a);
                a.click();
                a.remove(); // Clean up
            })
            .catch(error => console.error("error:", error));
    }
    </script>
</body>

</html>