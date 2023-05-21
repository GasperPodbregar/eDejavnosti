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
                    
                    <div class="col-10 cellContent">
                    
                        <div>
                        
                            <?php    
    
                                foreach($dijaki as $opcija){
                                        echo "<div class='dejavnost'>";

                                        echo "<h1>" . $opcija["naziv"] . "</h1>" . "<br>";

                                        echo "<p>" . "Opis: " . $opcija["opis"] . "</p>";

                                        echo "<p>" . "Mozna Mesta: " . $opcija["moznaMesta"] . "</p>";

                                        if($opcija["malica"] == 1){
                                            echo "<p>" . "Malica: " . "Malica je" . "</p>";
                                        }
                                        else{
                                            echo "<p>" . "Malica: " . "Malice ni" . "</p>";
                                        }

                                        echo "<p>" . "Datum začetka: " . $opcija["datumZacetek"] . "</p>";
                                        echo "<p>" . "Datum konca: " . $opcija["datumKonec"] . "</p>";

                                        }


                                ?>
                                <?php echo form_open("dejavnost/rocnaPrijavaDijaki-submit");?>


                                <div class="form-group">
                                  <select id="txt_dijaki" name="txt_dijaki[]" multiple="multiple" class="form-control">
                                  <?php
                                   foreach($sezDijakov as $opcija){
                                        echo "<option value=" . $opcija["idOseba"] . ">" . $opcija["ime"] . " " . $opcija["priimek"] . "</option>";
                                  }
                                  ?>
                                  </select>
                                  <?php echo form_error("txt_dijaki", "<div class='error'>", "</div>"); ?>
                                </div>

                                <button type="submit" class='btn btn-dark' value="<?php echo $dijaki[0]['idDejavnost'];?>" name="gumb">Prijavi</button>
                              <?php echo form_close() ?>
                                    <br>
                        
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

                $('#txt_dijaki').multiselect({
                nonSelectedText: "Izberite dijake, ki jih želite prijaviti na dejavnost",
                buttonWidth:"400px"

              });
              });

            var st = "<?php echo $dijaki[0]["moznaMesta"]; ?>";
            var verified = [];
            document.querySelector('select').onchange = function(e) {
              if (this.querySelectorAll('option:checked').length <= st) {
                  verified = Array.apply(null, this.querySelectorAll('option:checked'));
              } else {
                Array.apply(null, this.querySelectorAll('option')).forEach(function(e) {
                    e.selected = verified.indexOf(e) > -1;
                });
              }
            }

        </script>

    </body>
    
</html>
