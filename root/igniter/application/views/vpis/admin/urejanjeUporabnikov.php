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
                    

                    <div class="iskalnik container">
                        <br>
                        <?php echo form_open("prijava/iskanjeUporabnikov");?>
                            <div class="form-group">
                                <label for="txt_iskalniNiz">Iščite uporabnike:</label>
                                <input type="text" class="form-control" id="txt_iskalniNiz" placeholder="Vnesite ime, priimek ali vlogo" name="txt_iskalniNiz">
                                 <?php echo form_error("txt_iskalniNiz", "<div class='alert alert-danger error'>", "</div>"); ?>
                            </div>
                            <button type="submit" class="btn btn-dark">Išči</button>
                        <?php echo form_close() ?>
                        <br>
                    </div>

                    <div class="container-fluid">

                    <div class="row">
                        <?php
                        if($uporabniki == null){
                            echo "<br><h3>Ni zadetkov.</h3>";
                        }
                        foreach($uporabniki as $uporabnik){
                            if($uporabnik["vloga"] != "admin"){
                            echo "<div class='col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 vsebina'>";
                            echo "<div class='cellContent border'>";
                            if($uporabnik["vloga"] == "profesor"){
                            echo "prof." . " " . $uporabnik["priimek"] . " " . $uporabnik["ime"] . ", " ."<br>". $uporabnik["eNaslov"];
                            }
                            elseif($uporabnik["spol"] == "m"){
                                echo "dijak - " . " " . $uporabnik["priimek"] . " " . $uporabnik["ime"] . ", " ."<br>". $uporabnik["eNaslov"];
                            }
                            elseif($uporabnik["spol"] == "f"){
                                echo "dijakinja - " . " " . $uporabnik["priimek"] . " " . $uporabnik["ime"] . ", " ."<br>". $uporabnik["eNaslov"];
                            }
                            echo form_open("prijava/spremeniGeslo");?>
                            <br>
                            <div class="form-group">
                                <input type="password" class="form-control" id="txt_geslo" placeholder="Vnesite novo geslo" name="txt_geslo">
                                <?php echo form_error("txt_geslo", "<div class='alert alert-danger error'>", "</div>"); ?>
                            </div>
                            <?php
                            echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $uporabnik["idOseba"]  . ">Shrani</button>";
                            ?>                            
                            <?php echo form_close();

                            echo form_open("prijava/izbrisiUporabnika");?>
                            <br>
                                <?php echo form_error("txt_geslo", "<div class='alert alert-danger error'>", "</div>"); ?>
                            <?php
                            echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $uporabnik["idOseba"]  . ">Izbriši</button>";
                            ?>                            
                            <?php echo form_close();
                            echo "</div>";
                            echo "</div><br>";
                            }
                        }

                        ?>
                    </div>

                    <div>
                    
                    </div> 
                    
                </div>

            </div>
            
        </main>
