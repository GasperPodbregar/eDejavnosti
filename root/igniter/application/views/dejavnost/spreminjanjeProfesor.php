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

                <div class="container">
                    
                    <div class="col-12 cellContent">
                    
                        <div>
                        
                            <?php echo form_open("dejavnost/spreminjanjeDejavnosti_submit");?>


                                <div class="form-group">
                                  <label for="txt_naziv">Naziv Dejavnosti</label>
                                  <input type="text" class="form-control" id="txt_naziv" placeholder="Vnesite naziv" name="txt_naziv" value="<?php echo $select[0]["naziv"]; ?>">
                                  <?php echo form_error("txt_naziv", "<div class='error'>", "</div>"); ?>
                                </div>


                                <div class="form-group">
                                  <label for="txt_mesta">Možna mesta</label>
                                  <input type="text" class="form-control" id="txt_mesta" placeholder="Vnesite število možnih mest" name="txt_mesta" value="<?php echo $select[0]["moznaMesta"]; ?>">
                                  <?php echo form_error("txt_mesta", "<div class='error'>", "</div>"); ?>
                                </div>

                                <br>

                                <div class="form-group">
                                <textarea type="text" name="txt_opis" id="txt_opis" rows="10" cols="100"><?php echo $select[0]["opis"]; ?></textarea>
                                <?php echo form_error("txt_opis", "<div class='error'>", "</div>"); ?>
                                </div>


                                <div class="form-group" style="margin-left:25px">
                                  <label for="txt_malica">Malica:</label>
                                  <br>
                                  <input type="radio" class="form-check-input" id="txt_malica" name="txt_malica" value="1" <?php if($select[0]["malica"] == 1){
                                      echo "checked='checked'";
                                  } ?>>
                                  <label for="Da">DA</label><br>
                                  <input type="radio" class="form-check-input" id="txt_malica" name="txt_malica" value="0" <?php if($select[0]["malica"] == 0){
                                      echo "checked='checked'";
                                  } ?>>
                                  <label for="Ne">NE</label><br>
                                  <?php echo form_error("txt_malica", "<div class='error'>", "</div>"); ?>
                                </div>

                                <br>

                                <br>

                                <div class="form-group">
                                  <label for="txt_datumZacetek">Datum začetka dejavnosti:</label>
                                  <input type="date" class="form-control" id="txt_datumZacetek" placeholder="Kdaj se dejavnost prične?" name="txt_datumZacetek" value="<?php echo $select[0]["datumZacetek"]; ?>">
                                  <?php echo form_error("txt_datumZacetek", "<div class='error'>", "</div>"); ?>
                                </div>

                                <br>

                                <div class="form-group">
                                <label for="txt_datumKonec">Datum konca dejavnosti:</label>
                                <input type="date" class="form-control" id="txt_datumKonec" placeholder="Kdaj se dejavnost konča?" name="txt_datumKonec" value="<?php echo $select[0]["datumKonec"]; ?>">
                                <?php echo form_error("txt_datumKonec", "<div class='error'>", "</div>"); ?>
                                </div>

                                <br>

                                <div class="form-group">
                                  <input type="hidden" class="form-control" id="idDejavnost" placeholder="Vnesite število možnih mest" name="idDejavnost" value="<?php echo $select[0]["idDejavnost"]; ?>">
                                </div>

                                <?php $this->session->set_userdata("spreminjanje", array ( $select[0]));
                                echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark'>Spremeni</button>"; ?>

                              <?php echo form_close() ?>
                        
                        </div>
                        
                    </div>
                        
                </div>

            </div>
            
        </main>
        
        <?php $this->load->view("footer"); ?>