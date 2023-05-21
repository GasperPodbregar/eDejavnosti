<?php $this->load->view("assets"); ?>

    </head>

    <body class="d-flex flex-column min-vh-100">
    <?php
        if($this->session->flashdata("succes")){
            ?>
        <div class="btn btn-success" id="plsgoaway">
            <?php echo $this->session->flashdata("succes") ?>        
        </div>
        <?php        
            }
        elseif($this->session->flashdata("error")){
                ?>
        <div class="btn btn-danger" id="plsgoaway">
            <?php echo $this->session->flashdata("error") ?>        
        </div>
        <?php        
            }
            ?>
        <main role="main" class="flex-shrink-0">
                
                <div class="wrapper">

                    <?php $this->load->view("meniAdmin"); ?>
                <div class="container">
                <div class="iskalnik">
                        <br>
                        <?php echo form_open("dejavnost/iskanjeZakljucenihDejavnostiAdmin");?>
                            <div class="form-group">
                                <label for="txt_iskalniNiz">Iščite zaključene dejavnosti:</label>
                                <input type="text" class="form-control" id="txt_iskalniNiz" placeholder="Vnesite naziv ali mentorja" name="txt_iskalniNiz">
                                 <?php echo form_error("txt_iskalniNiz", "<div class='alert alert-danger error'>", "</div>"); ?>
                            </div>
                            <button type="submit" class="btn btn-dark">Išči</button>
                        <?php echo form_close() ?>
                        <br>
                    </div>
                    </div>
                    <div class="container-fluid">
                            <?php
                            if($izbire == null){
                                echo "<h1>Ni dejavnosti!</h1><br>";
                            }
                            echo "<div class='row'>";
                            foreach($izbire as $opcija){
                                echo "<div class='col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3 vsebina'>";
                                    echo "<div class='cellContent border'>";

                                    echo "<h1>" . $opcija["naziv"] . "</h1>" . "<br><hr><br>";

                                    echo "<p>Mentor: " . $opcija["ime"] . " " . $opcija["priimek"] . "</p>" . "<br>";

                                    echo "<p>Opis: " . $opcija["opis"] . "</p>";

                                    echo "<p>" . "Možna Mesta: " . $opcija["moznaMesta"] . "</p>";

                                    if($opcija["malica"] == 1){
                                        echo "<p>" . "Malica: " . "DA" . "</p>";
                                    }
                                    else{
                                        echo "<p>" . "Malica: " . "NE" . "</p>";
                                    }


                                    echo "<p>" . "Datum začetka: " . $opcija["datumZacetek"] . "</p>";
                                    echo "<p>" . "Datum konca: " . $opcija["datumKonec"] . "</p>";

                                        if(array_key_exists("povezava", $opcija)){
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
                                                            echo "<hr><br><br>".$opcija3["nazivSole"] . "<hr>";
    
                                                            echo $opcija3["nazivPrograma"] . "<br>";
    
                                                            echo $opcija3["stevilka"] . "." . $opcija3["crka"] . ", ";
                                                        }
                                                    }
                                                    else{
                                                        echo "<br><hr>" .   $opcija3["nazivSole"] ."<br>";
    
                                                        echo $opcija3["nazivPrograma"] . "<br>";
    
                                                        echo $opcija3["stevilka"] . "." . $opcija3["crka"] . ", ";
                                                    }
                                                    $vrednost2 = $opcija3["nazivPrograma"];
                                                    $vrednost = $opcija3["nazivSole"];
                                                    $z++;
    
                                                }
    
    
    
                                        }
                                        }

                                    $this->session->set_flashdata("brisanjeZakljucenih", 1);
                                    echo "<br><hr><br>";
                                    echo form_open("dejavnost/prikaziPrijavljene");
                                    echo "<br><button type='submit'  name='gumb' id='gumb' class=' btn btn-dark' value=" . $opcija["idDejavnost"]  . ">Udeleženci</button>";
                                    echo form_close(); 

                                    echo form_open("dejavnost/brisanjeDejavnosti");
                                    echo "<br><button type='submit'  name='gumb' id='gumb' class=' btn btn-dark' value=" . $opcija["idDejavnost"]  . ">Izbriši dejavnost</button>";
                                    echo form_close(); 


                                    echo "</div>"; 

                            ?>
                                <br>

                            <?php

                                echo "</div><br>";

                            }


                        ?>


                    </div> 
                    
                </div>

            </div>
            
        </main>
       <?php $this->load->view("footer"); ?>