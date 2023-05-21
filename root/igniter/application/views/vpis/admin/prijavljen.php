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
                <div class="btn btn-warning">
                    <?php echo $this->session->flashdata("error") ?>        
                </div>
                <?php        
                    }
            ?>
        
        <main role="main" class="flex-shrink-0">
            
                <div class="wrapper">

                    <?php $this->load->view("meniAdmin"); ?>

                
                    <br>
                    <div class="container">
                        <?php echo form_open("dejavnost/iskanjeDogodkov");?>
                            <div class="form-group">
                                <label for="txt_iskalniNiz">Iščite dogodke:</label>
                                <div class="container-fluid">
                                    
                                <input type="text" class="form-control" id="txt_iskalniNiz" placeholder="Vnesite naziv, ime ali priimek" name="txt_iskalniNiz">
                                    <br><button type="submit" class="btn btn-dark">Išči</button>
                                <?php echo form_error("txt_iskalniNiz", "<div class='alert alert-danger error'>", "</div>"); ?>
                                <input type="radio" id="odobreno" name="vrsta_dogodka" value="odobreno" class="radioIskanje">
                                <label for="odobreno">Odobreno</label>
                                <input type="radio" id="zavrnjeno" name="vrsta_dogodka" value="zavrnjeno" class="radioIskanje">
                                <label for="zavrnjeno">Zavrnjeno</label>
                                <input type="radio" id="prosnja" name="vrsta_dogodka" value="prošnja" class="radioIskanje">
                                <label for="prosnja">Prošnja</label>
                                <input type="radio" id="ustvarjeno" name="vrsta_dogodka" value="ustvarjeno" class="radioIskanje">
                                <label for="ustvarjeno">Ustvarjeno</label>
                                </div>
                            </div>
                        <?php echo form_close() ?>
                    </div>
                    <br>
                    <div class='container-fluid'>
                    <div class="row">
                        
                        <?php
                        
                        if($obvestila == null){
                            echo "<div class='container'><h1 >Ni dogodkov</h1></div>";
                        }
                        else{
                           
                        foreach($obvestila as $obvestilo){
                            echo "<div class='col-12 col-md-6 col-lg-4 col-xl-3 vsebina'>";
                                if($obvestilo["odobreno"] == 1){
                                    echo "<div class='prijavaOdobrena'>";
                                    ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                              <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z"/>
                                              <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                                            </svg>
                                            <?php
                                    echo $obvestilo["naziv"] .  "<br><br>" ;
                                    ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-calendar-event" viewBox="0 0 16 16">
                                          <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                        </svg>&nbsp;
                                    <?php
                                    echo $obvestilo["casVnosa"] . "<br><br>";
                                    ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                      <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                    </svg>
                                    
                                    <?php
                                    echo $obvestilo["ime"] . " " .  $obvestilo["priimek"];
                                    echo "</div>";
                                }
                                elseif($obvestilo["odobreno"] == 2){
                                    echo "<div class='prijavaZavrnjena'>";
                                     ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-file-earmark-minus" viewBox="0 0 16 16">
                                              <path d="M5.5 9a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                                              <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                                            </svg>
                                            <?php
                                    echo $obvestilo["naziv"] . "<br><br>"; 
                        ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-calendar-event" viewBox="0 0 16 16">
                                          <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                        </svg>&nbsp;
                            <?php echo $obvestilo["casVnosa"] . "<br><br>";
                                    ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                      <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                    </svg>
                                    
                                    <?php
                                    echo $obvestilo["ime"] . " " .  $obvestilo["priimek"];
                                    echo "</div>";
                                }
                                elseif($obvestilo["odobreno"] == 3 and isset($obvestilo["odobreno"]) == true){
                                    echo "<div class='prijavaPoslana'>";
                                     ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-file-earmark-diff" viewBox="0 0 16 16">
                                              <path d="M8 5a.5.5 0 0 1 .5.5V7H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V8H6a.5.5 0 0 1 0-1h1.5V5.5A.5.5 0 0 1 8 5zm-2.5 6.5A.5.5 0 0 1 6 11h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                                              <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                            </svg>
                                            
                                            <?php
                                    echo $obvestilo["naziv"] .   "<br><br>";
                                     ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-calendar-event" viewBox="0 0 16 16">
                                          <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                        </svg>&nbsp;
                            <?php   echo $obvestilo["casVnosa"] . "<br><br>";
                                    ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                      <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                    </svg>
                                    
                                    <?php
                                    echo $obvestilo["ime"] . " " .  $obvestilo["priimek"];
                                    echo "</div>";
                                }
                                else{
                                echo "<div class='dejavnostUstvarjena'>";
                                    ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16">
                                              <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                                            </svg>
                                            <?php
                                    echo $obvestilo["naziv"] .  "<br><br>";  ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-calendar-event" viewBox="0 0 16 16">
                                          <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                        </svg>&nbsp;
                            <?php echo $obvestilo["casVnosa"] . "<br><br>";
                                    ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                      <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    </svg>
                                <?php    
                                echo $obvestilo["ime"] . " " .  $obvestilo["priimek"];
                                echo "</div>";
                            }
                            echo "</div>";
                        }
                    }
                        ?>
                    </div>

                </div>

            </div>
            
        </main>
        
        <?php $this->load->view("footer"); ?>