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
                        <?php echo form_open("dejavnost/ustvari-submit");?>


                            <div class="form-group">
                              <label for="txt_naziv">Naziv Dejavnosti</label>
                              <input type="text" class="form-control" id="txt_naziv" placeholder="Vnesite naziv" name="txt_naziv">
                              <?php echo form_error("txt_naziv", "<div class='error'>", "</div>"); ?>
                            </div>


                            <div class="form-group">
                              <label for="txt_mesta">Možna mesta</label>
                              <input type="text" class="form-control" id="txt_mesta" placeholder="Vnesite število možnih mest" name="txt_mesta">
                              <?php echo form_error("txt_mesta", "<div class='error'>", "</div>"); ?>
                            </div>

                            <br>

                            <div class="form-group">
                                Opis dejavnosti:<br>
                            <textarea type="text" name="txt_opis" id="txt_opis" rows="10" cols="40"></textarea>
                            <?php echo form_error("txt_opis", "<div class='error'>", "</div>"); ?>
                            </div>


                            <div class="form-group" style="margin-left:25px;">
                              <label for="txt_malica">Malica:</label>
                              <br>
                              <input type="radio" class="form-check-input" id="txt_malica" name="txt_malica" value="1">
                              <label for="Da">Da</label><br>
                              <input type="radio" class="form-check-input" id="txt_malica" name="txt_malica" value="0">
                              <label for="Ne">Ne</label><br>
                              <?php echo form_error("txt_malica", "<div class='error'>", "</div>"); ?>
                            </div>

                            <br>

                            <div class="form-group">
                              <label for="txt_datumZacetek">Datum začetka dejavnosti:</label>
                              <input type="date" class="form-control" id="txt_datumZacetek" placeholder="Kdaj se dejavnost prične?" name="txt_datumZacetek">
                              <?php echo form_error("txt_datumZacetek", "<div class='error'>", "</div>"); ?>
                            </div>

                            <br>

                            <div class="form-group">
                            <label for="txt_datumKonec">Datum konca dejavnosti:</label>
                            <input type="date" class="form-control" id="txt_datumKonec" placeholder="Kdaj se dejavnost konča?" name="txt_datumKonec">
                            <?php echo form_error("txt_datumKonec", "<div class='error'>", "</div>"); ?>
                            </div>

                            <br>


                            <div class="form-group">
                              <select id="txt_sola" name="txt_sola[]" multiple="multiple" class="form-control">
                              <?php
                               foreach($sole as $opcija){
                                    echo "<option value=" . $opcija["idSola"] . ">" . $opcija["nazivSole"] . "</option>";
                              }
                              ?>
                              </select>
                              <?php echo form_error("txt_sola", "<div class='error'>", "</div>"); ?>
                            </div>

                            <br>

                            <div class="form-group">
                              <select class="form-control" id="txt_program" name="txt_program[]" multiple="multiple">
                              </select>
                              <?php echo form_error("txt_program", "<div class='error'>", "</div>"); ?>
                            </div>

                            <br>

                            <div class="form-group">
                              <select class="form-control" id="txt_letnik" name="txt_letnik[]" multiple="multiple"> 
                              </select>
                              <?php echo form_error("txt_letnik", "<div class='error'>", "</div>"); ?>
                            </div>

                            <br>

                            <div class="form-group">
                              <select class="form-control" id="txt_oddelek" name="txt_oddelek[]" multiple="multiple">
                              </select>
                              <?php echo form_error("txt_oddelek", "<div class='error'>", "</div>"); ?>
                            </div>
                            

                            <br>

                            <button type="submit" class="btn btn-dark">Ustvari</button><br><br>
                          <?php echo form_close() ?>


                        </div>
                        
                    </div>
                        
                </div>

            </div>
            
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
              $('#txt_sola').multiselect({
                includeSelectAllOption: true,
                nonSelectedText: "Izberite šolo",
                buttonWidth:"400px",
                onSelectAll:function () {
                  var sola_id = this.$select.val();
                  if(sola_id.length > 0)
                  {
                    $.ajax({
                      url:"<?php echo site_url() . "/dejavnost/fetch_programe";?>",
                      method:"POST",
                      data:{sola_id:sola_id},
                      success:function(data)
                      {
                        $('#txt_program').html(data);
                        $('#txt_program').multiselect('rebuild');
                      }
                    });
                  }                  
                },
                onChange:function(option, checked){
                  var sola_id = this.$select.val();
                  if(sola_id.length > 0)
                  {
                    $.ajax({
                      url:"<?php echo site_url() . "/dejavnost/fetch_programe";?>",
                      method:"POST",
                      data:{sola_id:sola_id},
                      success:function(data)
                      {
                        $('#txt_program').html(data);
                        $('#txt_program').multiselect('rebuild');
                      }
                    });
                  }
                }
              });

              $('#txt_program').multiselect({
                includeSelectAllOption: true,
                nonSelectedText: "Izberite program",
                buttonWidth:"400px",
                onSelectAll:function () {
                  var program_id = this.$select.val();
                  if(program_id.length > 0)
                  {
                    $.ajax({
                      url:"<?php echo site_url() . "/dejavnost/fetch_letnike";?>",
                      method:"POST",
                      data:{program_id:program_id},
                      success:function(data)
                      {
                        $('#txt_letnik').html(data);
                        $('#txt_letnik').multiselect('rebuild');
                      }
                    });
                  }                  
                },
                onChange:function(option, checked){
                  var program_id = this.$select.val();
                  if(program_id.length > 0)
                  {
                    $.ajax({
                      url:"<?php echo site_url() . "/dejavnost/fetch_letnike";?>",
                      method:"POST",
                      data:{program_id:program_id},
                      success:function(data)
                      {
                        $('#txt_letnik').html(data);
                        $('#txt_letnik').multiselect('rebuild');
                      }
                    });
                  }
                }
              });

              $('#txt_letnik').multiselect({
                includeSelectAllOption: true,
                nonSelectedText: "Izberite letnik",
                buttonWidth:"400px",
                onSelectAll:function () {
                  var letnik_id = this.$select.val();
                  if(letnik_id.length > 0)
                  {
                    $.ajax({
                      url:"<?php echo site_url() . "/dejavnost/fetch_oddelke";?>",
                      method:"POST",
                      data:{letnik_id:letnik_id},
                      success:function(data)
                      {
                        $('#txt_oddelek').html(data);
                        $('#txt_oddelek').multiselect('rebuild');
                      }
                    });
                  }                  
                },                
                onChange:function(option, checked){
                  var letnik_id = this.$select.val();
                  if(letnik_id.length > 0)
                  {
                    $.ajax({
                      url:"<?php echo site_url() . "/dejavnost/fetch_oddelke";?>",
                      method:"POST",
                      data:{letnik_id:letnik_id},
                      success:function(data)
                      {
                        $('#txt_oddelek').html(data);
                        $('#txt_oddelek').multiselect('rebuild');
                      }
                    });
                  }
                }
              });

              $('#txt_oddelek').multiselect({
                includeSelectAllOption: true,
                nonSelectedText: "Izberite oddelek",
                buttonWidth:"400px"

              });
              


              });
        </script>

    </body>
    
</html>

