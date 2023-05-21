<?php

class Prijava extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model("prijavni_model");
        $this->load->model("dejavnost_model");
    }

    public function login(){

        $this->load->view("vpis/prijava");

    }

    public function logout(){

        session_destroy();
        $this->load->view("vpis/prijava");
 

    }

    public function fetch_programe(){

        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        if($this->input->post('sola_id')){
            echo $this->prijavni_model->fetch_programe($this->input->post("sola_id"));
        }
    }

    public function fetch_letnike(){

        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        if($this->input->post('program_id')){
            echo $this->prijavni_model->fetch_letnike($this->input->post("program_id"));
        }
    }

    public function fetch_oddelke(){

        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        if($this->input->post('letnik_id')){
            echo $this->prijavni_model->fetch_oddelke($this->input->post("letnik_id"));
        }
    }


    public function prijava_submit(){


        $config_pravila = array(
            array(
                "field"=>"txt_email",
                "label"=>"E-poštni naslov",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_geslo",
                "label"=>"Geslo",
                "rules"=>"required"
            )
        );
        

        $this->form_validation->set_rules($config_pravila);


        if($this->form_validation->run()==FALSE){


            $this->login();
        }
        else{


            $podatki = $this->input->post();
            $podatki_array = array(
                "email"=>$podatki["txt_email"],
                "geslo"=>hash('sha256', $podatki["txt_geslo"])
            );
            


            $rezultat = $this->prijavni_model->preveriUporabnika($podatki_array);
            if($rezultat==null){
                $podatki_array = array(
                    "email"=>$podatki["txt_email"],
                    "geslo"=>$podatki["txt_geslo"]
                );
                $rezultat = $this->prijavni_model->preveriUporabnikaZacasno($podatki_array);
            }


            if ($rezultat!=null){

                $this->session->set_userdata("ime", $rezultat["ime"]);
                $this->session->set_userdata("idOseba", $rezultat["idOseba"]);
                $this->session->set_userdata("priimek", $rezultat["priimek"]);
                $this->session->set_userdata("datumRojstva", $rezultat["datumRojstva"]);
                $this->session->set_userdata("spol", $rezultat["spol"]);
                $this->session->set_userdata("eNaslov", $rezultat["eNaslov"]);
                $this->session->set_userdata("vloga", $rezultat["vloga"]);
                $this->session->set_userdata("oddelekID", $rezultat["Oddelek_idOddelek"]);
                $this->session->set_userdata("letnikID", $rezultat["Letnik_idLetnik"]);
                $this->session->set_userdata("programID", $rezultat["Program_idProgram"]);
                $this->session->set_userdata("solaID", $rezultat["Sola_idSola"]);
                $this->session->set_userdata("nazivSole", $rezultat["nazivSole"]);
                $this->session->set_userdata("nazivPrograma", $rezultat["nazivPrograma"]);
                $this->session->set_userdata("stevilka", $rezultat["stevilka"]);
                $this->session->set_userdata("crka", $rezultat["crka"]);


                redirect("");


            }

            else{
                $this->session->set_flashdata("error", "Nepravilno geslo");
                $this->load->view("vpis/prijava");
            }


        }

    }

    public function dodajanjeUporabnikov_dijak(){

        if($this->session->userdata("vloga") == "admin"){

            $vseOpcije["sole"] = $this->prijavni_model->pridobiSole();

            $this->load->view("vpis/dijak/dodajanje",$vseOpcije);

        }
        else{

            redirect("");
        }



    }

    public function dodajanje_submit_dijak(){

        if($this->session->userdata("vloga") != "admin"){
            redirect("");
        }


        $config_pravila = array(
            array(
                "field"=>"txt_ime",
                "label"=>"Ime",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_priimek",
                "label"=>"Priimek",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_geslo",
                "label"=>"Geslo",
                "rules"=>"required|min_length[5]"
            ),
            array(
                "field"=>"txt_sola",
                "label"=>"Šola",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_program",
                "label"=>"Program",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_letnik",
                "label"=>"Letnik",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_oddelek",
                "label"=>"Oddelek",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_datum",
                "label"=>"Datum rojstva",
                "rules"=>"required"
            )
            
        );

        $this->form_validation->set_rules($config_pravila);

        if($this->form_validation->run()==FALSE){

            $this->dodajanjeUporabnikov_dijak();
        }
        else{
            
            $podatki = $this->input->post();
            $podatki_array = array(
                "ime"=>$podatki["txt_ime"],
                "priimek"=>$podatki["txt_priimek"],
                "datumRojstva"=>$podatki["txt_datum"],
                "spol"=>$podatki["txt_spol"],
                "eNaslov"=> "",
                "vloga"=>"dijak",
                "geslo"=>hash('sha256', $podatki["txt_geslo"]),
                "Oddelek_idOddelek"=>$podatki["txt_oddelek"]
            );
            $izid = $this->prijavni_model->pridobiKratice($podatki["txt_sola"]);
            $prava = $izid[0]["kratica"];
            $podatki_array["eNaslov"] = $this->prijavni_model->sestaviEmail($podatki_array, $prava);

            if($this->prijavni_model->vstavljanjeUporabnika($podatki_array)){

                $IDosebe = $this->prijavni_model->iskanjeIDOsebe();

                $podatki_array2 = array(
                    "Sola_idSola" => $podatki["txt_sola"],
                    "Oseba_idOseba" => $IDosebe["idOseba"]
                );

                if($this->prijavni_model->vstavljanjeSolaHasOseba($podatki_array2)){

                    $this->session->set_flashdata("succes", "Dijak je bil uspešno dodan!");

                    redirect("prijava/dodajanje-dijak");

                }

                else{
                    
                    $this->session->set_flashdata("error", "Dijaka ni bilo mogoče kreirati!");

                    redirect("prijava/dodajanje-dijak");
                }
            }

            else{

               $this->session->set_flashdata("error", "Dijaka ni bilo mogoče kreirati!");

                redirect("prijava/dodajanje-dijak");

           }
           
        }
    }

    public function dodajanjeUporabnikov_profesor(){

        if($this->session->userdata("vloga") == "admin"){

            $vseOpcije["sole"] = $this->prijavni_model->pridobiSole();

            $this->load->view("vpis/profesor/dodajanje",$vseOpcije);
            
        }
        else{

            redirect("");

        }



    }

    public function dodajanje_submit_profesor(){

        if($this->session->userdata("vloga") != "admin"){
            redirect("");
        }


        $config_pravila = array(
            array(
                "field"=>"txt_ime",
                "label"=>"Ime",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_priimek",
                "label"=>"Priimek",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_geslo",
                "label"=>"Geslo",
                "rules"=>"required|min_length[5]"
            ),
            array(
                "field"=>"txt_sola[]",
                "label"=>"Šola",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_spol",
                "label"=>"Spol",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_datum",
                "label"=>"Datum rojstva",
                "rules"=>"required"
            )
            
        );


        $this->form_validation->set_rules($config_pravila);

        if($this->form_validation->run()==FALSE){

            $this->dodajanjeUporabnikov_profesor();
        }
        else{
            
            $podatki = $this->input->post();
            $podatki_array = array(
                "ime"=>$podatki["txt_ime"],
                "priimek"=>$podatki["txt_priimek"],
                "datumRojstva"=>$podatki["txt_datum"],
                "spol"=>$podatki["txt_spol"],
                "eNaslov"=> "",
                "vloga"=>"profesor",
                "geslo"=>hash('sha256', $podatki["txt_geslo"]),
            );
            $izid = $this->prijavni_model->pridobiKratice($podatki["txt_sola"][0]);
            $prava = $izid[0]["kratica"];
            $podatki_array["eNaslov"] = $this->prijavni_model->sestaviEmail($podatki_array, $prava);

            if($this->prijavni_model->vstavljanjeUporabnika($podatki_array)){

                $IDosebe = $this->prijavni_model->iskanjeIDOsebe();
                
                foreach ($podatki['txt_sola'] as $podatek){  
                    
                    $podatki_array2 = array(
                        "Sola_idSola" => $podatek,
                        "Oseba_idOseba" => $IDosebe["idOseba"]
                    );

                    $this->prijavni_model->vstavljanjeSolaHasOseba($podatki_array2);

                }

                $this->session->set_flashdata("succes", "Profesor je bil uspešno dodan!");

                redirect("prijava/dodajanje-profesor");

                }

                else{
                
                    $this->session->set_flashdata("error", "Profesorja ni bilo mogoče kreirati!");

                    redirect("prijava/dodajanje-profesor");
                }

        }
    }

    public function urejanjeUporabnikov(){
        if($this->session->userdata("vloga") != "admin"){
            redirect("");
        }
        else{
            $uporabniki["uporabniki"] = $this->prijavni_model->isciUporabnika("");
            $this->load->view("vpis/admin/urejanjeUporabnikov", $uporabniki);
            $this->load->view("footer");
        }
    }

    public function iskanjeUporabnikov(){
        if($this->session->userdata("vloga") != "admin"){
            redirect("");
        }
        else{           
            $iskalniNiz = $this->input->post("txt_iskalniNiz");
            $uporabniki["uporabniki"] = $this->prijavni_model->isciUporabnika($iskalniNiz);
            $this->load->view("vpis/admin/urejanjeUporabnikov", $uporabniki);
            $this->load->view("footer");
        }
    }
    
    public function spremeniGeslo(){
        if($this->session->userdata("vloga") != "admin"){
            redirect("");
        }
        else{
        $config_pravila = array(
            array(
                "field"=>"txt_geslo",
                "label"=>"Geslo",
                "rules"=>"required|min_length[5]"
            )
        );
        

        $this->form_validation->set_rules($config_pravila);


        if($this->form_validation->run()==FALSE){

            $this->session->set_flashdata("error", "Novo mora biti dolgo vsaj 5 znakov!");

            redirect("prijava/urejanjeUporabnikov");
        }
        else{
        $novoGeslo = hash('sha256', $this->input->post("txt_geslo"));
        $id = $this->input->post("gumb");
        $novoGeslo = hash('sha256', $this->input->post("txt_geslo"));
        $this->db->set("geslo", $novoGeslo);
        $this->db->where('idOseba', $id);
        $this->db->update('oseba');
        $this->session->set_flashdata("succes", "Geslo je bilo spremenjeno");
        redirect("prijava/urejanjeUporabnikov");
            }
        }
    }

    public function profil(){
        $podatki["uporabnik"] = $this->prijavni_model->profil($this->session->userdata("idOseba"));
        $this->load->view("vpis/profil", $podatki);
    }


    public function spremeniGesloUporabnik(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor" and $this->session->userdata("vloga") != "dijak"){
            redirect("");
        }
        else{
        $config_pravila = array(
            array(
                "field"=>"txt_geslo",
                "label"=>"Geslo",
                "rules"=>"required|min_length[5]"
            )
        );
        

        $this->form_validation->set_rules($config_pravila);


        if($this->form_validation->run()==FALSE){

            $this->profil();
        }
        else{
            $novoGeslo = hash('sha256', $this->input->post("txt_geslo"));
            $id = $this->session->userdata("idOseba");
            $novoGeslo = hash('sha256', $this->input->post("txt_geslo"));
            $this->db->set("geslo", $novoGeslo);
            $this->db->where('idOseba', $id);
            $this->db->update('oseba');
            $this->session->set_flashdata("succes", "Geslo je bilo spremenjeno");
            redirect("prijava/profil");
            }
        }
    }

    public function uporabniki(){
        if($this->session->userdata("vloga") != "admin"){
            redirect("");
        }
        else{
            $rezultat["sole"] = $this->dejavnost_model->pridobiSoleAdmin();
            $this->load->view("vpis/admin/uporabniki", $rezultat);
        }
    }




    public function izbrisiUporabnika(){
        $idOseba = $this->input->post("gumb");
        $this->prijavni_model->izbrisiUporabnika($idOseba);
        $this->session->set_flashdata("succes", "Uporabnik je bil izbrisan!");
        redirect("prijava/urejanjeUporabnikov");   
        }
    


    

}