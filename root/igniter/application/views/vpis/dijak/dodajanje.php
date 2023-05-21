<?php $this->load->view("assets"); ?>

    </head>

    <body class="d-flex flex-column min-vh-100">
        <?php
        if($this->session->flashdata("succes")){
            ?>
        <div class="btn btn-success" id="goaway">
            <?php echo $this->session->flashdata("succes") ?>        
        </div>
        <?php        
            }
        elseif($this->session->flashdata("error")){
                ?>
        <div class="btn btn-danger" id="goaway">
            <?php echo $this->session->flashdata("error") ?>        
        </div>
        <?php        
            }
            ?>
        
        <main role="main" class="flex-shrink-0">
            
                <div class="wrapper">

                    <?php $this->load->view("meniAdmin"); ?>

                <div class="container">
                    
                    <div class="col-12 cellContent border">
                    
                        <?php echo form_open("prijava/dodajanje-submit-dijak");?>

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

                            <br>

                            <div class="form-group" style="margin-left:25px;">
                              <label for="txt_spol">Spol:</label><br>
                              <input type="radio" class="form-check-input" id="txt_spol" name="txt_spol" value="m">
                              <label for="male">M</label><br>
                              <input type="radio" class="form-check-input" id="txt_spol" name="txt_spol" value="f">
                              <label for="male">Ž</label><br>
                              <?php echo form_error("txt_spol", "<div class='error'>", "</div>"); ?>
                            </div>

                            <br>

                            <div class="form-group">
                              <select  class="form-control" id="txt_sola"  name="txt_sola">
                              <option value="">Izberite šolo</option>
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

                            <br>

                              <div class="form-group">
                              <select class="form-control" id="txt_program" name="txt_program">
                                <option value="">Izberite program</option>
                              </select>
                              <?php echo form_error("txt_program", "<div class='error'>", "</div>"); ?>
                            </div>

                            <br>

                            <div class="form-group">
                              <select class="form-control" id="txt_letnik" name="txt_letnik">
                                <option value="">Izberite letnik</option>
                              </select>
                              <?php echo form_error("txt_letnik", "<div class='error'>", "</div>"); ?>
                            </div>

                            <br>

                            <div class="form-group">
                              <select class="form-control" id="txt_oddelek" name="txt_oddelek">
                                <option value="">Izberite oddelek</option>
                              </select>
                              <?php echo form_error("txt_oddelek", "<div class='error'>", "</div>"); ?>
                            </div>

                            <br>

                            <button type="submit" class="btn btn-dark">Submit</button>
                          <?php echo form_close() ?>

                        
                    </div>
                        
                </div>

            </div><br>
            
        </main>
        
        <footer class="footer mt-auto py-3">
            <div class="container">
                <p class="footerText">Avtorja: Nik Jukič, Gašper Podbregar</p>
            </div>
        </footer>
        
        <script>
            /* Set the width of the side navigation to 250px */
            function openNav() {
              document.getElementById("mySidenav").style.width = "250px";
            }

            /* Set the width of the side navigation to 0 */
            function closeNav() {
              document.getElementById("mySidenav").style.width = "0";
            }
            $(document).ready(function(){
              $('#txt_sola').change(function(){
                var sola_id = $('#txt_sola').val();
                if(sola_id != ''){
                  $.ajax({
                    url:"<?php echo site_url() . "/prijava/fetch_programe";?>",
                    method:"POST",
                    data:{sola_id:sola_id},
                    success:function(data){
                      $('#txt_program').html(data);
                    } 
                  })
                }
              });

              $('#txt_program').change(function(){
                var program_id = $('#txt_program').val();
                if(program_id != ''){
                  $.ajax({
                    url:"<?php echo site_url() . "/prijava/fetch_letnike";?>",
                    method:"POST",
                    data:{program_id:program_id},
                    success:function(data){
                      $('#txt_letnik').html(data);
                    } 
                  })
                }
              });

              $('#txt_letnik').change(function(){
                var letnik_id = $('#txt_letnik').val();
                if(letnik_id != ''){
                  $.ajax({
                    url:"<?php echo site_url() . "/prijava/fetch_oddelke";?>",
                    method:"POST",
                    data:{letnik_id:letnik_id},
                    success:function(data){
                      $('#txt_oddelek').html(data);
                    } 
                  })
                }
              });

            });
            function hideMessage() {
                document.getElementById("goaway").style.display = "none";
            };
            setTimeout(hideMessage, 3000);
        </script>

    </body>
    
</html>