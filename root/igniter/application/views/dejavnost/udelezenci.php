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

                    <?php 
                    if($this->session->userdata("vloga") == "admin"){
                        $this->load->view("meniAdmin"); 
                    }
                    elseif($this->session->userdata("vloga") == "profesor"){
                        $this->load->view("meniProfesor"); 
                    }
                    ?>
                    
                    <div class="container-fluid">
                    <?php    if($udelezenci == null){
                                    echo "<h1>Nihče še ni prijavljen!</h1>";
                         }else{  
    ?>  
                        <div class="row">
                            <?php
                        echo form_close();
        
                                foreach($udelezenci as $opcija){

                                    echo "<div class='col-11 col-sm-5 col-md-3 col-lg-3 col-xl-2 cellContent border'>";

                                    echo "<h1>" . $opcija["naziv"] . "</h1>" . "<br>";

                                    echo "<p>"  . $opcija["ime"] . " " . $opcija["priimek"] . ", " . $opcija["stevilka"] . "." . $opcija["crka"] .  "</p>"; 

                                    echo "<p>" . $opcija["nazivPrograma"] . "</p>";

                                    echo "<p>"  . $opcija["nazivSole"] .  "</p>";   
                                    
                                    echo "</div>";
                                }
                              }  ?>
                                <br>
                        
                    </div>
                </div>
            </div>
            
        </main>
        
        <?php $this->load->view("footer"); ?>