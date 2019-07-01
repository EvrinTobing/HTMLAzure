<html>
 <head>
 <Title>Web Dating Registration Form</Title>
 <style type="text/css">
 	body { background-color: #fff; border-top: solid 10px #000;
 	    color: #333; font-size: .85em; margin: 20; padding: 20;
 	    font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
 	}
 	h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
 	h1 { font-size: 2em; }
 	h2 { font-size: 1.75em; }
 	h3 { font-size: 1.2em; }
 	table { margin-top: 0.75em; }
 	th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
 	td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
 </style>
 </head>
 <body>
 <h1>Register here!</h1>
 <p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
 <form method="post" action="index.php" enctype="multipart/form-data" >
       Nama  <input type="text" name="nama" id="nama"/></br></br>
       Umur <input type="int" name="umur" id="umur"/></br></br>
       Email <input type="text" name="email" id="email"/></br></br>
       Jenis Kelamin <input type="text" name="j_kelamin" id="j_kelamin"/></br></br>
       
       <input type="submit" name="submit" value="Submit" />
       <input type="submit" name="load_data" value="Load Data" />
 </form>
 <?php
    $host = "dicodingservers";
    $user = "evrin";
    $pass = "asdewq123";
    try {
        $conn = new PDO("sqlsrv:server = $host; Database = dcodedb", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        echo "connected succesfully";
    } catch(PDOException $e) {

        echo "Failed: " . $e->getMessage();
    }
    if (isset($_POST['submit'])) {
        try {
            $nama = $_POST['nama'];
            $umur = $_POST['umur'];
            $email = $_POST['email'];
            $jk = $_POST['j_kelamin'];
            // Insert data
            $sql_insert = "INSERT INTO Dating (nama, umur, email, j_kelamin) 
                        VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $nama);
            $stmt->bindValue(2, $umur);
            $stmt->bindValue(3, $email);
            $stmt->bindValue(4, $jk);
            $stmt->execute();
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
        echo "<h3>Your're registered!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM Dating";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
            if(count($registrants) > 0) {
                echo "<h2>People who are registered:</h2>";
                echo "<table>";
                echo "<tr><th>Nama</th>";
                echo "<th>Umur</th>";
                echo "<th>E-mail</th></tr>";
                echo "<th>Jenis Kelamin</th>";
               
                foreach($registrants as $registrant) {
                    echo "<tr><td>".$registrant['nama']."</td>";
                    echo "<td>".$registrant['umur']."</td>";
                    echo "<td>".$registrant['email']."</td>";
                    echo "<td>".$registrant['jk']."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>No one is currently registered.</h3>";
            }
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
    }
 ?>
 </body>
</html>