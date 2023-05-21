<?php $this->load->view("assets"); ?>

    </head>

    <body class="d-flex flex-column min-vh-100">
        
        <?php
        if($this->session->flashdata("succes")){
            ?>
        <div class="btn btn-success">
            <?php echo $this->session->flashdata("succes") ?>        
        </div>
        <?php        
            }
        elseif($this->session->flashdata("error")){
                ?>
        <div class="btn btn-danger">
            <?php echo $this->session->flashdata("error") ?>        
        </div>
        <?php        
            }
            ?>

        
        <main role="main" class="flex-shrink-0">
            
                <div class="wrapper">
                    
                    <?php $this->load->view("meniDijak"); ?>
                    
               <div class="container-fluid">
                        <?php
                            if($izbire == null and isset($vloga)){
                                echo "<h1>Ni dejavnosti</h1>";
                            }
                            elseif($izbire == null){
                                echo "<h1>Ni dejavnosti</h1>";
                            } 
                            echo "<div class='row''>";
                            $st=1;
                            foreach($izbire as $opcija){
                                if($vloga == "dijakPotrjene"){
                                    if($opcija["odobreno"] == 1){
                                        echo "<div class='col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3 vsebina'>";
                                        echo "<div class='cellContent border'>";
                                        echo "<h1>" . $opcija["naziv"] . "</h1>" . "<br>";

                                        echo "<p>" . "Opis: " . $opcija["opis"] . "</p>";

                                        echo "<p>" . "Mentor : " . $opcija["mentor"][0]["imePriimek"] . "</p>";

                                        echo "<p>" . "Mozna Mesta: " . $opcija["moznaMesta"] . "</p>";

                                        if($opcija["malica"] == 1){
                                            echo "<p>" . "Malica: " . "DA" . "</p>";
                                        }
                                        else{
                                            echo "<p>" . "Malica: " . "NE" . "</p>";
                                        }


                                        echo "<p>" . "Datum začetka: " . $opcija["datumZacetek"] . "</p>";
                                        echo "<p>" . "Datum konca: " . $opcija["datumKonec"] . "</p>";

                                            foreach($opcija["povezava"] as $opcija2){
                                                $z=0;
                                                $vrednost="";
                                                $vrednost2="";

                                                foreach($opcija2 as $opcija3){

                                                    if($z!=0){
                                                        if($opcija3["nazivSole"] == $vrednost){

                                                            if($opcija3["nazivPrograma"] == $vrednost2){

                                                                echo $opcija3["stevilka"] . "." . $opcija3["crka"] . ", ";

                                                            }
                                                            else{
                                                                echo "<br>".$opcija3["nazivPrograma"] . ", ";

                                                                echo $opcija3["stevilka"] . "." . $opcija3["crka"] . ", ";
                                                            }

                                                        }
                                                        else{
                                                            echo $opcija3["nazivSole"] . "<br>";

                                                            echo "<br>".$opcija3["nazivPrograma"] . ", ";

                                                            echo $opcija3["stevilka"] . "." . $opcija3["crka"] . ", ";
                                                        }
                                                    }
                                                    else{
                                                        echo "<br><br>" . $opcija3["nazivSole"] . "<br>";

                                                        echo "<br>".$opcija3["nazivPrograma"] . ", ";

                                                        echo $opcija3["stevilka"] . "." . $opcija3["crka"] . ", ";
                                                    }
                                                    $vrednost2 = $opcija3["nazivPrograma"];
                                                    $vrednost = $opcija3["nazivSole"];
                                                    $z++;

                                            }
                                                

                                        }
                                ?>
                                    <br>
                                    <?php 
                                    if($vloga == "dijak"){
                                        echo "<br>";
                                        echo form_open("dejavnost/prijavaNaDejavnost-submit");
                                        echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $opcija["idDejavnost"]  . ">Prijavi se na dejavnost</button>";
                                        echo form_close(); 
                                    }
                                ?> 

                                <?php

                                    
                                    }

                                }
                                else{        
                                    echo "<div class='col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3 vsebina'>";
                                    echo "<div class='cellContent border'>";

                                    echo "<h1>" . $opcija["naziv"] . "</h1>" . "<br>";

                                    echo "<p>" . "Opis: " . $opcija["opis"] . "</p>";

                                    echo "<p>" . "Mentor : " . $opcija["ime"] . " " . $opcija["priimek"] . "</p>";

                                    echo "<p>" . "Mozna Mesta: " . $opcija["moznaMesta"] . "</p>";

                                    if($opcija["malica"] == 1){
                                        echo "<p>" . "Malica: " . "DA" . "</p>";
                                    }
                                    else{
                                        echo "<p>" . "Malica: " . "NE" . "</p>";
                                    }

                                        foreach($opcija["povezava"] as $opcija2){
                                            $z=0;
                                            $vrednost="";
                                            $vrednost2="";

                                            foreach($opcija2 as $opcija3){


                                        if($z!=0){
                                            if($opcija3["nazivSole"] == $vrednost){

                                                if($opcija3["nazivPrograma"] == $vrednost2){

                                                    echo $opcija3["stevilka"] . "." . $opcija3["crka"] . ", ";

                                                }
                                                else{
                                                    echo "<br>" . $opcija3["nazivPrograma"] . "<br>";

                                                    echo $opcija3["stevilka"] . "." . $opcija3["crka"] . ", ";
                                                }

                                            }
                                            else{
                                                echo "<br>" .$opcija3["nazivSole"] . "<br>";

                                                echo $opcija3["nazivPrograma"] . "<br>";

                                                echo $opcija3["stevilka"] . "." . $opcija3["crka"] . ", ";
                                            }
                                        }
                                        else{
                                            echo "<br>" . $opcija3["nazivSole"] . "<br>";

                                            echo $opcija3["nazivPrograma"] . "<br>";

                                            echo $opcija3["stevilka"] . "." . $opcija3["crka"] . ", ";
                                        }
                                        $vrednost2 = $opcija3["nazivPrograma"];
                                        $vrednost = $opcija3["nazivSole"];
                                        $z++;

                                    }


                                    }
                            ?>
                                <br>
                                <?php 
                                if($vloga == "dijak"){

                                    echo "<br>";
                                    echo form_open("dejavnost/prijavaNaDejavnost-submit");
                                    echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $opcija["idDejavnost"]  . ">Prijavi se na dejavnost</button>";
                                    echo form_close(); 
                                }
                            ?> 

                            <?php

                                }echo "</div></div><br>";


                                

                            }




                        ?>
                   </div>
                </div>

            </div>
            
        </main>
        
        <?php $this->load->view("footer"); ?>