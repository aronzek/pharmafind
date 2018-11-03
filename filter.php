<html>
    <header>
		<!-->Defining page title<-->
        <title>Medifind</title>
    </header>

    <body>
        
        <form method="post">
            <input name="search">
            <input type="submit" name="research">
        </form>
        <?php
		//Variables settings
		// IP adress
        $host = 'localhost';
		// Database name
        $dbname = 'medifind';
		// User ID
        $id = 'medifind';
		// Password
        $pass = 'password!';
        mb_internal_encoding('UTF-8');
        try
        {
			//Referencing the database
			$bdd = new PDO ('mysql:host='.$host.';dbname='.$dbname, "$id", "$pass", array (PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        }
        catch (Exception $ep)
        {
            var_dump($ep );
            echo "Error database";
        }
			// Request treatment
            if($_POST){
                if(!empty($_POST['search'])){
                    $request = $bdd->prepare('SELECT name FROM mf_medicaments WHERE name = ? UNION SELECT name FROM mf_medicaments WHERE name LIKE "%"?"%"');
                    $request->execute(array($_POST['search'], $_POST['search']));

                    while($req = $request->fetch(PDO::FETCH_ASSOC))
                    {
                        $result[] = $req;
                    }
                    

                    if(empty($result)){
                         echo 'Nothing';
                        }else{
                            foreach($result as $collection)
                            {
                                echo "<form method=\"POST\">

                                <input name=\"details\" type=\"submit\" value=\"".$collection['name']."\">
                                </form>
                                <br>";
                            }
                        }
                        
                }
                else{
                    if(isset($_POST['details'])){
                        $info = $bdd->prepare('SELECT name, price FROM mf_medicaments WHERE name = ?');
                        $info->execute(array($_POST['details']));
                        $res = $info->fetch(PDO::FETCH_ASSOC);
                        echo "<table style=\"width: 50%;\" cellspacing=\"0\">
                        <tbody>
                            <tr style=\"background-color: #dfdacf; border: none; height: 35px;\">
                                <th>Name</th>
                                <th>Price</th>
                            </tr>
                            <tr style=\" border: none; height: 35px;\">
                                <th>". $res['name'] ."</th>
                                <th>". $res['price'] ." $</th>
                            </tr>
                        </tbody>
                    </table>";
                    }
                }
            }
            
        ?>
    </body>
</html>