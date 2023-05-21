                <nav class="navbar navigacija sticky-top">
                    
                    <a href="#" class="link" onclick="openNav()">
                      <svg class="settings-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                       <g class="settings-icon__group settings-icon__group--1">
                         <line class="settings-icon__line" x1="80" y1="15" x2="80" y2="85"/>
                         <rect class="settings-icon__rect" x="75" y="25" width="15" height="15"/>
                        </g>
                       <g class="settings-icon__group settings-icon__group--2">
                         <line class="settings-icon__line" x1="50" y1="15" x2="50" y2="85"/>
                         <rect class="settings-icon__rect" x="42" y="60" width="15" height="15"/>
                       </g>
                       <g class="settings-icon__group settings-icon__group--3">
                         <line class="settings-icon__line" x1="20" y1="15" x2="20" y2="85"/>
                         <rect class="settings-icon__rect" x="13" y="35" width="15" height="15"/>
                       </g>
                      </svg>
                     </a>
     
                     <a>eDejavnosti</a>
                    
                    <div class="dropdown">
                        <svg id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="white" class="bi bi-person-fill" viewBox="0 0 16 16">
                          <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                        </svg> 
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <p class="dropdown-header">Prijavljeni ste kot <?php  echo $this->session->userdata("ime")?></p>
                        <?php echo "<a class='dropdown-item logout' href=". site_url() . "/prijava/profil" . ">Profil</a>" ?>
                        <div class="dropdown-divider"></div>
                        <?php echo "<a class='dropdown-item logout' href=". site_url() . "/prijava/izpis" . ">Odjava</a>" ?>  
                      </div> 
                    </div>
                    
                </nav>
    
                <div id="mySidenav" class="sidenav">
                    <br><br>
                    <a style="font-weight:bold">Tvoj meni</a>
                    <?php echo "<a href=". site_url() . ">"?><i class="fas fa-angle-right"></i> <?php echo "Domov</a>" ?>
                    <?php echo "<a href=". site_url() . "/dejavnost/mojeDejavnostiDijak" . ">"?><i class="fas fa-angle-right"></i> <?php echo "Aktualne dejavnosti</a>" ?>
                    <?php echo "<a href=". site_url() . "/dejavnost/zakljuceneDejavnostiDijak" . ">"?><i class="fas fa-angle-right"></i> <?php echo "Zaključene dejavnosti</a>" ?>
                    <?php echo "<a href=". site_url() . "/dejavnost/prijavaNaDejavnost" . ">"?><i class="fas fa-angle-right"></i> <?php echo "Prijava na dejavnost</a>" ?>
                <br>
                    <a href="javascript:void(0)" class="closebtn" aria-label="Close" onclick="closeNav()"><img src="/igniter/assets/img/x.svg"></a>
                </div>