<?php
    include("connect.php");
    include("req_search.php");
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rechercher un film</title>
        <link rel="stylesheet" href="./style.css">
        <!-- script js -->
        <script>
            window.onload = function(){
                let button = document.getElementById("button")
                button.onclick = function(){
                var filter = document.getElementById("filter");
                filter.style.display = "block";
                }
            }

            function moreFilter(){
                var checkbox_distri = document.getElementById("checkbox_distri")
                var option_distri = document.getElementById("input_distri")

                var checkbox_genre = document.getElementById("checkbox_genre")
                var option_genre = document.getElementById("select_genre")

                var checkbox_date = document.getElementById("checkbox_date")
                var option_date = document.getElementById("input_date")

                if (checkbox_distri.checked == true) {
                    option_distri.style.display = "inline-block";
                } else {
                    option_distri.style.display = "none";
                }

                if (checkbox_genre.checked == true) {
                    option_genre.style.display = "inline-block";
                } else {
                    option_genre.style.display = "none";
                }

                if (checkbox_date.checked == true) {
                    option_date.style.display = "inline-block";
                } else {
                    option_date.style.display = "none";
                }
            }
            
            function check_add(){
                    var checkbox_schedule= document.getElementById("checkbox_schedule")
                    var option1 = document.getElementById("option1");
                    var option2 = document.getElementById("option2");
                    var option3 = document.getElementById("option3");
                    var option4 = document.getElementById("option4");

                    if (checkbox_schedule.checked == true) {
                        option1.style.display = "inline-block";
                        option2.style.display = "inline-block";
                        option3.style.display = "inline-block";
                        option4.style.display = "inline-block";
                    } else {
                        option1.style.display = "none";
                        option2.style.display = "none";
                        option3.style.display = "none";
                        option4.style.display = "none";
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
            <form method="POST" id="movie_form">
                <fieldset>
                    <legend> Recherche:</legend>
                    <!-- title -->
                    <input type="search" name="search" value="<?php echo $_POST['search']; ?>" placeholder="Titre de film..."/>
                    
                    <!-- submit -->
                    <input type="submit" value="Rechercher"/>
                    
                    <!-- more filter -->
                    <button id="button" type="button" style="display:block">Plus de filtres</button>
                    
                    <div id="filter" style="display:none">
                        <!-- distributeur -->
                        <input type="checkbox" name="checkbox_distri" id="checkbox_distri" onclick="moreFilter()">
                        <label for="checkbox_distri">Par distributeur:</label>
                        <input type="search" name="search_distributor" id="input_distri" placeholder="Distributeur..." style="display:none"/>
                        
                        <!-- genre -->
                        <input type="checkbox" name="checkbox_genre" id="checkbox_genre" onclick="moreFilter()">
                        <label for="checkbox_genre">Par genre:</label>
                        <select name="search_genre" id="select_genre" style="display:none">
                            <option value="action">Action</option>
                            <option value="animation">Animation</option>
                            <option value="adventure">Aventure</option>
                            <option value="drama">Drame</option>
                            <option value="comedy">Comédie</option>
                            <option value="mystery">Mystère</option>
                            <option value="biography">Biographie</option>
                            <option value="crime">Crime</option>
                            <option value="fantasy">Fantaisie</option>
                            <option value="horror">Horreur</option>
                            <option value="sci-Fi">Sci-Fi</option>
                            <option value="romance">Romantique</option>
                            <option value="family">Famille</option>
                            <option value="thriller">Thriller</option>
                        </select>
                        
                        <!-- projection date -->
                        <input type="checkbox" name="checkbox_date" id="checkbox_date" onclick="moreFilter()">
                        <label for="checkbox_date">Par date de projection:</label>
                        <input type="search" name="search_date" id="input_date" placeholder="Quels films passent ce soir ?" style="display:none"/>
                    </div>
                </fieldset>
            </form>

            <!-- display results -->
            <section>
                <!-- select displayed pages -->
                <label for="display">Résultats par page:</label>
                <select name="display" id="display" form="movie_form">
                    <option value="20" <?php echo $_POST['display']==20?"selected":"";?>>20</option>
                    <option value="40" <?php echo $_POST['display']==40?"selected":"";?>>40</option>
                    <option value="60" <?php echo $_POST['display']==60?"selected":"";?>>60</option>
                    <option value="80" <?php echo $_POST['display']==80?"selected":"";?>>80</option>
                    <option value="100" <?php echo $_POST['display']==100?"selected":"";?>>100</option>
                </select>
                <br>
                <br>
                <?php

                //search by title + genre + distributor
                if (isset($_POST['search']) && !empty($_POST['search']) && isset($_POST['checkbox_distri']) && isset($_POST['checkbox_genre'])) {
                    require_once('connect.php');
                    $query = $database->prepare($search);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table>
                    <thead>
                        <th>Résultat</th>
                        <th>Titre</th>
                        <th>Distributeur</th>
                        <th>Genre</th>
                    </thead>
                    <tbody>
                <?php
                    $i=1;
                    foreach($results as $result){
                ?>
                        <tr>
                            <td><?php
                            echo $i;
                            $i++;
                            ?></td>
                            <td><?= $result['title']?></td>
                            <td><?= $result['distributor']?></td>
                            <td><?= $result['genre']?></td>
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

                //search by distri and title
                elseif(isset($_POST['search']) && !empty($_POST['search']) && isset($_POST['checkbox_distri']) && empty($_POST['checkbox_genre'])){ 
                    require_once('connect.php');
                    $query = $database->prepare($search_by_distri);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table>
                    <thead>
                        <th>Résultat</th>
                        <th>Titre</th>
                        <th>Distributeur</th>
                        <th>Genre</th>
                    </thead>
                    <tbody>
                <?php
                    $i=1;
                    foreach($results as $result){
                ?>
                        <tr>
                            <td><?php
                            echo $i;
                            $i++;
                            ?></td>
                            <td><?= $result['title']?></td>
                            <td><?= $result['distributor']?></td>
                            <td><?= $result['genre']?></td>
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

                //search by genre and title
                elseif (isset($_POST['search']) && !empty($_POST['search']) && isset($_POST['checkbox_genre']) && empty($_POST['checkbox_distri'])) {
                    require_once('connect.php');
                    $query = $database->prepare($search_by_genre);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table>
                    <thead>
                        <th>Résultat</th>
                        <th>Titre</th>
                        <th>Distributeur</th>
                        <th>Genre</th>
                    </thead>
                    <tbody>
                <?php
                    $i=1;
                    foreach($results as $result){
                ?>
                        <tr>
                            <td><?php
                            echo $i;
                            $i++;
                            ?></td>
                            <td><?= $result['title']?></td>
                            <td><?= $result['distributor']?></td>
                            <td><?= $result['genre']?></td>
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

                //search by title only
                elseif (isset($_POST['search']) && !empty($_POST['search']) && empty($_POST['checkbox_date']) && empty($_POST['checkbox_distri']) && empty($_POST['checkbox_genre'])) {
                    
                    if(isset($_POST['page']) && !empty($_POST['page'])){
                        $page = $_POST['page'];
                    }else{
                       $page = 1;
                    }
                    //query for counting results
                    require_once('connect.php');
                    $query = $database->prepare($count_title);
                    $query-> execute();
                    $total = $query->fetch();
                    $total_results = $total['count'];
                
                    //number of result per page
                    $display_per_page = $_POST['display'];
                    $totalpage = ceil($total_results/$display_per_page);
                    $first_result = ($page * $display_per_page) - $display_per_page;
                    
                    require_once('connect.php');
                    $query = $database->prepare($search_by_title);
                    $query->bindValue(':first', $first_result, PDO::PARAM_INT);
                    $query->bindValue(':limit', $display_per_page, PDO::PARAM_INT);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_ASSOC);
                        
                ?>
                <table>
                    <thead>
                        <th>Résultat</th>
                        <th>Titre</th>
                        <th>Distributeur</th>
                        <th>Genre</th>
                    </thead>
                    <tbody>
                <?php
                    $i=1;
                    foreach($results as $result){
                ?>
                        <tr>
                            <td><?php
                            echo $i;
                            $i++;
                            ?></td>
                            <td><?= $result['title']?></td>
                            <td><?= $result['distributor']?></td>
                            <td><?= $result['genre']?></td>
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
                //search by date and title
                elseif(isset($_POST['checkbox_date']) && !empty($_POST['search_date']) && !empty($_POST['search']) && empty($_POST['checkbox_genre']) && empty($_POST['checkbox_distri'])){ 
                   require_once('connect.php');
                    $query = $database->prepare($search_by_date_title);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table>
                    <thead>
                        <th>Résultat</th>
                        <th>Titre</th>
                        <th>Salle</th>
                        <th>Date de projection</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" id="checkbox_schedule" onclick="check_add()"></td>
                            <td><input type="text"  id="option1" placeholder="Titre du film..." form="movie_form" style="display:none"></td>
                            <td>
                            <select name="search_salle" id="option2" form="movie_form" style="display:none">
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
                            <td><input type=datetime-local id="option3" value="2023-01-01T00:00:00" step="1" form="movie_form" style="display:none"></td>
                            <td><input type="submit" id="option4" value="Ajouter" style="display:none"></td>
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
                //search by date only
                elseif(isset($_POST['checkbox_date']) && !empty($_POST['search_date']) && empty($_POST['search']) && empty($_POST['checkbox_genre']) && empty($_POST['checkbox_distri'])){ 
                    require_once('connect.php');
                    $query = $database->prepare($search_by_date_only);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table>
                    <thead>
                        <th>Résultat</th>
                        <th>Titre</th>
                        <th>Salle</th>
                        <th>Date de projection</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" id="checkbox_schedule" onclick="check_add()"></td>
                            <td><input type="text"  id="option1" placeholder="Titre du film..." form="movie_form" style="display:none"></td>
                            <td>
                            <select name="search_salle" id="option2" form="movie_form" style="display:none">
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
                            <td><input type=datetime-local id="option3" value="2023-01-01T00:00:00" step="1" form="movie_form" style="display:none"></td>
                            <td><input type="submit" id="option4" value="Ajouter" style="display:none"></td>
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
                //if field empty
                elseif (isset($_POST['search']) && empty($_POST['search']) && empty($_POST['search_date'])) {
                    ?>
                    <p>Aucun film trouvé</p>
                    <?php
                }
                ?>
            </section>
            <section>
                <button type="button" <?= ($_POST['page']==0?'style="display:none"':'') ?>>Précédent</button>
                <?php for($i = 1; $i <= $totalpage; $i++): ?>
                    <button type="button" onclick="test()" <?=($_POST['page']==$i?'style="display:none"':"")?>><?=$i?></button>
                <?php endfor ?>
                <button type="button" onclick="test()" <?= ($_POST['page']==$totalpage?'style="display:none"':"") ?>>Suivant</button>
            </section>
        </main>
    </body>
</html>