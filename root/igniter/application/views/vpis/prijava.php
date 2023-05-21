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

                <nav class="navbar navigacija sticky-top">
                    
                    <div class="container">
                        <h1 class="welcome" >Prijava</h1>
                    </div>   
                    
                </nav>
                    
                <div class="container">
                    
                    <br>
                    <?php echo form_open("prijava/prijava-submit");?>
                    <div class="form-group">
                      <label for="txt_email">E-poštni naslov:</label>
                      <input type="email" class="form-control" id="txt_email" placeholder="Vnesite E-poštni naslov" name="txt_email">
                      <?php echo form_error("txt_email", "<div class='error'>", "</div>"); ?>
                    </div>
                    <div class="form-group">
                      <label for="txt_geslo">Geslo:</label>
                      <input type="password" class="form-control" id="txt_geslo" placeholder="Vnesite geslo" name="txt_geslo">
                      <?php echo form_error("txt_geslo", "<div class='error'>", "</div>"); ?>
                    </div>
                    <button type="submit" class="btn btn-dark">Prijava</button>
                  <?php echo form_close() ?> 
                    
                   
                    
                </div>
                    
                
            </div>
            
        </main>
        
<?php $this->load->view("footer"); ?>
        