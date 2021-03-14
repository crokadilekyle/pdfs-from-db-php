<?php
include 'autoload.php';
require 'Pdf.php';
include 'db_connection.php';

// text to be printed to screen or written to log file
$screenText = "";
$logText = "";

//creates log file (good for debugging)
$log = fopen('exports.log', 'a');

//open DB connection
$conn = OpenCon();

//query
if ($result = $conn -> query("SELECT * FROM table")) {
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            
            //example - data from DB needed for PDF
            $id = $row['id'];
            $text = $row["text"];
            
            //example - create filename and folder structure
            $filename = "myfile-".$id;
            $dir = 'C:/myfolder/';

            //create PDF - see fpdf.org for more details
            $pdf = new PDF();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFont('Times','',12);
            $pdf->WriteHTML('<br><br><b>Text:</b><br>');
            $pdf->WriteHTML($text);
            
            //Creates folder specified above
            if (!is_dir($dir)){
                mkdir($dir, 0777, true);
            }

            //Saves PDF to specified folder
            $pdf->Output('F', $dir.$filename);

            //text to be printed to the screen
            $screenText = $screenText.$filename."<br>";

            //text to be logged
            $logText = $logText.$filename."\r\n";
        }
    } 

  $result -> free_result();
}

//close DB connection
CloseCon($conn);

//logs log text to log file
fwrite($log, $logText."\r\n");

//closes log file
fclose($log);

//prints text to the screen
echo $screenText;

?>
