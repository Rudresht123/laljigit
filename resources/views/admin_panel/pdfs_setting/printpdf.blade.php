<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <link rel="stylesheet" href="{{asset('assets/css/dashforge.css')}}">
</head>
<body id="printContent">
    {!!$contactTemplate!!}
    <script src="{{asset('assets/js/dashforge.js')}}"></script>
    <script>
        // Correcting the window.onload function
        window.onload = function() {
            printPart('printContent');
        };

        function printPart(divId) {
            // Get the element to print
            var printContents = document.getElementById(divId).innerHTML;
            
            // Create a new window for printing
            var printWindow = window.open('', '_blank', 'height=600,width=800');
            
            // Get all the styles from the current document
            var styles = document.head.innerHTML;
        
            // Write the content into the new window with styles
            printWindow.document.write('<html><head>' + styles + '</head><body>' + printContents + '</body></html>');
            
            // Close the document to apply the content
            printWindow.document.close();
            
            // Use setTimeout to delay the print until the content is fully loaded
            setTimeout(function() {
                printWindow.focus(); // Ensure the new window has focus
                printWindow.print();  // Trigger the print dialog
                printWindow.close();  // Optionally close the window after printing
            }, 500); // Adjust delay as needed
        }
    </script>
</body>
</html>
