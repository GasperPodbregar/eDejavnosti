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

                <div class="container">
                    
                    <div class="col-12">
                    
                        <div class="cellContent border">
                            <?php echo form_open("prijava/dodajanje-submit-profesor");?>
                                <div class="form-group">
                                  <label for="txt_ime">Ime:</label>
                                  <input type="text" class="form-control" id="txt_ime" placeholder="Vnesite ime" name="txt_ime">
                                  <?php echo form_error("txt_ime", "<div class='error'>", "</div>"); ?>
                                </div>
                                <div class="form-group">
                                  <label for="txt_priimek">Priimek:</label>
                                  <input type="text" class="form-control" id="txt_priimek" placeholder="Vnesite priimek" name="txt_priimek">
                                  <?php echo form_error("txt_priimek", "<div class='error'>", "</div>"); ?>
                                </div>
                                <div class="form-group">
                                  <label for="txt_geslo">Geslo:</label>
                                  <input type="password" class="form-control" id="txt_geslo" placeholder="Vnesite geslo" name="txt_geslo">
                                  <?php echo form_error("txt_geslo", "<div class='error'>", "</div>"); ?>
                                </div>
                                <div class="form-group">
                                  <label for="txt_datum">Datum Rojstva:</label>
                                  <input type="date" class="form-control" id="txt_datum" placeholder="Vnesite datum rojstva" name="txt_datum">
                                  <?php echo form_error("txt_datum", "<div class='error'>", "</div>"); ?>
                                </div>
                                <div class="form-group" style="margin-left:25px;">
                                  <label for="txt_spol">Spol:</label><br>
                                  <input type="radio" class="form-check-input" id="txt_spol" name="txt_spol" value="m">
                                  <label for="male">M</label><br>
                                  <input type="radio" class="form-check-input" id="txt_spol" name="txt_spol" value="f">
                                  <label for="male">Ž</label><br>
                                  <?php echo form_error("txt_spol", "<div class='error'>", "</div>"); ?>
                                </div>
                                <div class="form-group">
                                  <select  class="form-control" id="txt_sola"  name="txt_sola[]" multiple="multiple">
                                  <?php
                                   foreach($sole as $opcija){
                                      if($opcija["nazivSole"] != "0"){
                                        echo "<option value=" . $opcija["idSola"] . ">" . $opcija["nazivSole"] . "</option>";
                                     }

                                  }
                                  ?>
                                  </select>
                                  <?php echo form_error("txt_sola", "<div class='error'>", "</div>"); ?>
                                </div>
                                <button type="submit" class='btn btn-dark'>Ustvari</button>
                              <?php echo form_close() ?>
                        </div>
                    </div>
                        
                </div>

            </div>
            
        </main>

        <script>
        $(document).ready(function() {
          $('#txt_sola').multiselect({
          nonSelectedText: "Izberite šole",
            });
        });
        </script>
        
        <?php $this->load->view("footer"); ?>