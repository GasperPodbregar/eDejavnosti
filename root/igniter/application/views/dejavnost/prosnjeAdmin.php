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

                    <?php $this->load->view("meniAdmin"); ?>

                <div class="container-fluid">
                    
                    
                    
                            
                            <?php    

                                if($prosnje == null){
                                    echo "<h1>Ni prošenj za odobriti.</h1>";
                                }
                                echo "<div class='row'>";   
                                foreach($prosnje as $opcija){
                                    echo "<div class='col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 '>";
                                    echo "<div class='cellContent border'>";

                                    echo "<h1>" . $opcija["naziv"] . "</h1>" . "<br>";

                                    echo "<p>Opis: "  . $opcija["opis"] . "</p>";

                                    echo "<p>" . "Ime in priimek učenca: " . $opcija["ime"] . " " . $opcija["priimek"] .  "</p>"; 

                                    $seznam = $opcija["idDejavnost"] . ";" . $opcija["idOseba"];

                            ?>
                                <br>
                                <?php 
                                    echo form_open("dejavnost/potrditevPrijaveAdmin");
                                    echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $seznam  . ">Odobri prošnjo</button>";
                                    echo form_close();

                                    echo "<br><br>";

                                    echo form_open("dejavnost/zavrnitevPrijaveAdmin");
                                    echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $seznam  . ">Zavrni prošnjo</button>";
                                    echo form_close(); 
                            ?> 

                            <?php

                                echo "</div></div><br>";

                                }




                            ?>
                                                    
                    </div>
                        
                </div>

            </div>
            
        </main>
        
        <?php $this->load->view("footer"); ?>

