<?php
    include("connect.php");
    include("req_search.php");
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Membres</title>
        <link rel="stylesheet" href="./style.css">
        <!-- script js -->
        <script>
            window.onload = function(){
                let button = document.getElementById("button")
                button.onclick = click;
            }
            
            click = function(){
                var option1 = document.getElementById("option1");
                var option2 = document.getElementById("option2");
                var option3 = document.getElementById("option3");
                var option4 = document.getElementById("option4");
                var option5 = document.getElementById("option5");
                option1.style.display = "block";
                option2.style.display = "block";
                option3.style.display = "block";
                option4.style.display = "block";
                option5.style.display = "block";
            }


            function myFunction(){
                var checkbox_add_history = document.getElementById("checkbox_add_history")
                var option_title = document.getElementsById("input_title")
                var option_room = document.getElementsById("input_room")
                var option_date = document.getElementsById("input_date")

                if (checkbox_add_history.checked == true) {

                    option_title.style.display = "inline-block";
                    option_room.style.display = "inline-block";
                    option_date.style.display = "inline-block";

                } else {
                    
                    option_title.style.display = "none";
                    option_room.style.display = "none";
                    option_date.style.display = "none";
                }
            }
        </script>
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="">Acceuil</a></li>
                    <li><a href="./films.php">Espace film</a></li>
                    <li><a href="./membres.php">Espace membres</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <form method="POST" id="user_form">
                <fieldset>
                    <!-- user -->
                    <legend>Recherche:</legend>
                    <input type="search" name="search_user" value="<?php echo $_POST['search_user']; ?>" placeholder="Nom/prénom..."/>

                    <!-- submit -->
                    <input type="submit" name="action" value="Abonnement"/>

                    <!-- submit -->
                    <input type="submit" name="action" value="Historique"/>
                </fieldset>
            </form>

            <!-- display results -->
            <section>
                <!-- select displayed pages -->
                <label for="display">Résultats par page:</label>
                <select name="display" id="display" form="user_form">
                    <option value="20" <?php echo $_POST['display']==20?"selected":"";?>>20</option>
                    <option value="40" <?php echo $_POST['display']==40?"selected":"";?>>40</option>
                    <option value="60" <?php echo $_POST['display']==60?"selected":"";?>>60</option>
                    <option value="80" <?php echo $_POST['display']==80?"selected":"";?>>80</option>
                    <option value="100" <?php echo $_POST['display']==100?"selected":"";?>>100</option>
                </select>
                <br>
                <br>

                <?php
                //one word search
                if(isset($_POST['search_user']) && !empty($_POST['search_user']) && ($_POST['action'] == 'Abonnement') && ($count == 1)){ 
                    require_once('connect.php');
                    $query = $database->prepare($search_user_name);
                    $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table>
                    <thead>
                        <th>Résultat</th>
                        <th>Nom complet</th>
                        <th>Abonnement</th>
                        <th>Description</th>
                        <th>Action<th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><button type="button" id="button">+</button></td>
                            <td><input type="text"  name="update_name" id="option1" placeholder="Nom complet..." form="user_form" style="display:none"></td>
                            <td>
                            <select name="update_sub" id="option2" form="user_form" style="display:none">
                                <option value="GOLD">GOLD</option>
                                <option value="VIP">VIP</option>
                                <option value="Classic">Classic</option>
                                <option value="Pass Day">Pass Day</option>
                            </select>
                            </td>
                            <td></td>
                            <td><input type="submit" id="option3" value="Modifier" style="display:none"></td>
                        </tr>
                <?php
                    $i=1;
                    foreach($results as $result){
                ?>
                        <tr>
                            <td><?php
                            echo $i;
                            $i++;
                            ?></td>
                            <td><?= $result['name']?></td>
                            <td><?= $result['subscription']?></td>
                            <td><?= $result['description']?></td>
                            <td><button type="button">-</button><button type="button">+</button></td>
                        </tr>
                <?php
                    }
                    if (isset($_POST['update_name']) && !empty($_POST['update_name']) && isset($_POST['update_sub']) && !empty($_POST['update_sub']) ) {
                        if ($_POST['update_sub'] == "GOLD") {
                            $id=2;
                            //get the id of a specific user in the table membership
                            require_once('connect.php');
                            $query = $database->prepare($search_id_name);
                            $query->execute();
                            $name = $query->fetch();
                            $id_name = $name["id_name"];

                            require_once('connect.php');
                            $query = $database->prepare($update_sub);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_ASSOC);
                        }
                        elseif ($_POST['update_sub'] == "VIP") {
                            $id=1;
                            //get the id of a specific user in the table membership
                            require_once('connect.php');
                            $query = $database->prepare($search_id_name);
                            $query->execute();
                            $name = $query->fetch();
                            $id_name = $name["id_name"];

                            require_once('connect.php');
                            $query = $database->prepare($update_sub);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_ASSOC);
                        }
                        elseif ($_POST['update_sub'] == "Classic") {
                            $id=3;
                            //get the id of a specific user in the table membership
                            require_once('connect.php');
                            $query = $database->prepare($search_id_name);
                            $query->execute();
                            $name = $query->fetch();
                            $id_name = $name["id_name"];

                            require_once('connect.php');
                            $query = $database->prepare($update_sub);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_ASSOC);
                        }
                        elseif ($_POST['update_sub'] == "Pass Day") {
                            $id=4;
                            //get the id of a specific user in the table membership
                            require_once('connect.php');
                            $query = $database->prepare($search_id_name);
                            $query->execute();
                            $name = $query->fetch();
                            $id_name = $name["id_name"];

                            require_once('connect.php');
                            $query = $database->prepare($update_sub);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_ASSOC);
                        }
                        
                    }
                ?>
                    </tbody>
                </table>
                <br>
                <?= count($results)." ".(count($results)>1?"résultats trouvés":"résultat trouvé")?>
                <?php
                }
                //two words search
                elseif(isset($_POST['search_user']) && !empty($_POST['search_user']) && ($_POST['action'] == 'Abonnement') && ($count == 2)){
                    require_once('connect.php');
                    $query = $database->prepare($search_user_fullname);
                    $query->bindParam(':firstword', $first_word, PDO::PARAM_STR);
                    $query->bindParam(':secondword', $second_word, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table>
                    <thead>
                        <th>Résultat</th>
                        <th>Nom complet</th>
                        <th>Abonnement</th>
                        <th>Description</th>
                        <th>Action<th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><button type="button" id="button">+</button></td>
                            <td><input type="text"  name="update_name" id="option1" placeholder="Nom complet..." form="user_form" style="display:none"></td>
                            <td>
                            <select name="update_sub" id="option2" form="user_form" style="display:none">
                                <option value="GOLD">GOLD</option>
                                <option value="VIP">VIP</option>
                                <option value="Classic">Classic</option>
                                <option value="Pass Day">Pass Day</option>
                            </select>
                            </td>
                            <td></td>
                            <td><input type="submit" id="option3" value="Modifier" style="display:none"></td>
                        </tr>
                <?php
                    $i=1;
                    foreach($results as $result){
                ?>
                        <tr>
                            <td><?php
                            echo $i;
                            $i++;
                            ?></td>
                            <td><?= $result['name']?></td>
                            <td><?= $result['subscription']?></td>
                            <td><?= $result['description']?></td>
                            <td><button type="button">-</button><button type="button">+</button></td>
                        </tr>
                <?php
                    }if (isset($_POST['update_name']) && !empty($_POST['update_name']) && isset($_POST['update_sub']) && !empty($_POST['update_sub']) ) {
                        if ($_POST['update_sub'] == "GOLD") {
                            $id=2;
                            //get the id of a specific user in the table membership
                            require_once('connect.php');
                            $query = $database->prepare($search_id_name);
                            $query->execute();
                            $name = $query->fetch();
                            $id_name = $name["id_name"];

                            require_once('connect.php');
                            $query = $database->prepare($update_sub);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_ASSOC);
                        }
                        elseif ($_POST['update_sub'] == "VIP") {
                            $id=1;
                            //get the id of a specific user in the table membership
                            require_once('connect.php');
                            $query = $database->prepare($search_id_name);
                            $query->execute();
                            $name = $query->fetch();
                            $id_name = $name["id_name"];

                            require_once('connect.php');
                            $query = $database->prepare($update_sub);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_ASSOC);
                        }
                        elseif ($_POST['update_sub'] == "Classic") {
                            $id=3;
                            //get the id of a specific user in the table membership
                            require_once('connect.php');
                            $query = $database->prepare($search_id_name);
                            $query->execute();
                            $name = $query->fetch();
                            $id_name = $name["id_name"];

                            require_once('connect.php');
                            $query = $database->prepare($update_sub);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_ASSOC);
                        }
                        elseif ($_POST['update_sub'] == "Pass Day") {
                            $id=4;
                            //get the id of a specific user in the table membership
                            require_once('connect.php');
                            $query = $database->prepare($search_id_name);
                            $query->execute();
                            $name = $query->fetch();
                            $id_name = $name["id_name"];
                            
                            require_once('connect.php');
                            $query = $database->prepare($update_sub);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_ASSOC);
                        }
                        
                    }
                ?>
                    </tbody>
                </table>
                <br>
                <?= count($results)." ".(count($results)>1?"résultats trouvés":"résultat trouvé")?>
                <?php
                }
                //display and add an history; one word
                elseif(isset($_POST['search_user']) && !empty($_POST['search_user']) && ($_POST['action'] == 'Historique') && ($count == 1)){ 
                    require_once('connect.php');
                    $query = $database->prepare($search_history_name);
                    $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table>
                    <thead>
                        <th>Résultat</th>
                        <th>Nom complet</th>
                        <th>Titre du film</th>
                        <th>Salle</th>
                        <th>Date de projection<th>
                        <th></th>
                        
                    </thead>
                    <tbody>
                        <tr>
                            <td><button type="button" id="button">+</button></td>
                            <td><input type="text"  id="option1" placeholder="Nom complet..." form="user_form" style="display:none"></td>
                            <td><input type="text" id="option2" placeholder="Titre du film..." form="user_form" style="display:none"></td>
                            <td>
                            <select name="search_salle" id="option3" form="user_form" style="display:none">
                                <option value="default">Choisir une salle</option>
                                <option value="montana">Montana</option>
                                <option value="highscore">Highscore</option>
                                <option value="salle 3">Salle 3</option>
                                <option value="astek">Astek</option>
                                <option value="gecko">Gecko</option>
                                <option value="azure">Azure</option>
                                <option value="toshiba">Toshiba</option>
                                <option value="salle 14">Salle 14</option>
                                <option value="asus">Asus</option>
                                <option value="salle 16">Salle 16</option>
                                <option value="microsoft">Microsoft</option>
                                <option value="vip">VIP</option>
                                <option value="golden">Golden</option>
                                <option value="salle 23">Salle 23</option>
                                <option value="lenovo">Lenovo</option>
                                <option value="salle 31">Salle 31</option>
                                <option value="huawei">Huawei</option>
                            </select>
                            </td>
                            <td><input type=datetime-local id="option4" value="2023-01-01T00:00:00" step="1" form="user_form" style="display:none"></td>
                            <td><input type="submit" id="option5" value="Ajouter" style="display:none"></td>
                        </tr>
                <?php
                    $i=1;
                    foreach($results as $result){
                ?>
                        <tr>
                            <td><?php
                            echo $i;
                            $i++;
                            ?></td>
                            <td><?= $result['name']?></td>
                            <td><?= $result['title']?></td>
                            <td><?= $result['room']?></td>
                            <td><?= $result['projection']?></td>
                        </tr>
                <?php
                    }
                ?>
                    </tbody>
                </table>
                <br>
                <?= count($results)." ".(count($results)>1?"résultats trouvés":"résultat trouvé")?>
                <?php
                }
                //display and add an history; two words
                elseif(isset($_POST['search_user']) && !empty($_POST['search_user']) && ($_POST['action'] == 'Historique') && ($count == 2)){ 
                    require_once('connect.php');
                    $query = $database->prepare($search_history_fullname);
                    $query->bindParam(':firstword', $first_word, PDO::PARAM_STR);
                    $query->bindParam(':secondword', $second_word, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table>
                    <thead>
                        <th>Résultat</th>
                        <th>Nom complet</th>
                        <th>Titre du film</th>
                        <th>Salle</th>
                        <th>Date de projection<th>
                        <th></th>
                        
                    </thead>
                    <tbody>
                        <tr>
                            <td><button type="button" id="button">+</button></td>
                            <td><input type="text"  id="option1" placeholder="Nom complet..." form="user_form" style="display:none"></td>
                            <td><input type="text" id="option2" placeholder="Titre du film..." form="user_form" style="display:none"></td>
                            <td>
                            <select name="search_salle" id="option3" form="user_form" style="display:none">
                                <option value="default">Choisir une salle</option>
                                <option value="montana">Montana</option>
                                <option value="highscore">Highscore</option>
                                <option value="salle 3">Salle 3</option>
                                <option value="astek">Astek</option>
                                <option value="gecko">Gecko</option>
                                <option value="azure">Azure</option>
                                <option value="toshiba">Toshiba</option>
                                <option value="salle 14">Salle 14</option>
                                <option value="asus">Asus</option>
                                <option value="salle 16">Salle 16</option>
                                <option value="microsoft">Microsoft</option>
                                <option value="vip">VIP</option>
                                <option value="golden">Golden</option>
                                <option value="salle 23">Salle 23</option>
                                <option value="lenovo">Lenovo</option>
                                <option value="salle 31">Salle 31</option>
                                <option value="huawei">Huawei</option>
                            </select>
                            </td>
                            <td><input type=datetime-local id="option4" value="2023-01-01T00:00:00" step="1" form="user_form" style="display:none"></td>
                            <td><input type="submit" id="option5" value="Ajouter" style="display:none"></td>
                        </tr>
                <?php
                    $i=1;
                    foreach($results as $result){
                ?>
                        <tr>
                            <td><?php
                            echo $i;
                            $i++;
                            ?></td>
                            <td><?= $result['name']?></td>
                            <td><?= $result['title']?></td>
                            <td><?= $result['room']?></td>
                            <td><?= $result['projection']?></td>
                        </tr>
                <?php
                    }
                ?>
                    </tbody>
                </table>
                <br>
                <?= count($results)." ".(count($results)>1?"résultats trouvés":"résultat trouvé")?>
                <?php
                }
                elseif (isset($_POST['search_user']) && empty($_POST['search_user'])) {
                    ?>
                    <p>Aucun utilisateur trouvé</p>
                    <?php
                }
                
                ?>
            </section>
        </main>
    </body>
</html>