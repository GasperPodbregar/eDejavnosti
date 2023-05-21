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

                    <?php $this->load->view("meniProfesor"); ?>

                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            if($prosnje == null){
                                echo "<h1>Nimate dijakov prijavljenih na dejavnosti</h1>";
                            }    
                                foreach($prosnje as $opcija){

                                    echo "<div class='col-12 col-sm-5 col-md-3 col-lg-3 col-xl-2 cellContent border'>";

                                    echo "<h1>" . $opcija["naziv"] . "</h1>" . "<br>";

                                    echo "<p>"  ."Mozna mesta: ". $opcija["moznaMesta"] . "</p>";

                                    echo "<p>" . "Ime in priimek učenca: " . $opcija["ime"] . " " . $opcija["priimek"] .  "</p>"; 

                                    $seznam = $opcija["idDejavnost"] . ";" . $opcija["idOseba"];

                            ?>
                                <br>
                            
                            <?php 
                                echo form_open("dejavnost/izbrisiRelacijo");
                                echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $seznam  . ">Odstrani prijavo</button> ";
                                echo form_close();
                                echo "</div><br>";

                                }

                            ?>
                        
                    </div>
                </div>
            </div>
            
        </main>
        
        <?php $this->load->view("footer"); ?>