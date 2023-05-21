<?php

class Prijavni_model extends CI_Model{

    

    public function preveriUporabnika($podatki_array){
        $this->db->select("idOseba, ime, priimek, datumRojstva, spol, eNaslov, vloga, sola_has_oseba.Sola_idSola, letnik.Program_idProgram, oddelek.Letnik_idLetnik, oseba.Oddelek_idOddelek, letnik.stevilka, oddelek.crka, sola.nazivSole, program.nazivPrograma");
        $this->db->from("oseba");
        $this->db->join("sola_has_oseba", "oseba.idOseba = sola_has_oseba.Oseba_idOseba", "left");
        $this->db->join("oddelek", "oddelek.idOddelek = oseba.Oddelek_idOddelek", "left");
        $this->db->join("letnik", "letnik.idLetnik = oddelek.Letnik_idLetnik", "left");
        $this->db->join("program", "program.idProgram = letnik.Program_idProgram", "left");
        $this->db->join("sola", "sola.idSola = program.Sola_idSola", "left");
        $this->db->where(array(
            "oseba.eNaslov" => $podatki_array["email"],
            "oseba.geslo" => $podatki_array["geslo"]
        ));
        $query = $this->db->get();
        return $rezultat = $query->row_array();
    }

    public function vstavljanjeUporabnika($podatki_array){
        return $this->db->insert("oseba", $podatki_array);
    }

    public function pridobiSole(){
        $this->db->select("nazivSole, idSola");
        $this->db->from("sola");
        $query = $this->db->get();
        return $rezultat = $query->result_array();
    }

    public function fetch_programe($idSola){
        $this->db->select("nazivPrograma, idProgram");
        $this->db->from("program");
        $this->db->where("Sola_idSola", $idSola);
        $query = $this->db->get();
        $output = '<option value="">Izberite program</option>';
        foreach($query->result() as $row){
            $output .= '<option value="' . $row->idProgram . '">' . $row->nazivPrograma . '</option>';
        }
        return $output;
    }

    public function fetch_letnike($idProgram){
        $this->db->select("stevilka, idLetnik");
        $this->db->from("letnik");
        $this->db->where("Program_idProgram", $idProgram);
        $query = $this->db->get();
        $output = '<option value="">Izberite letnik</option>';
        foreach($query->result() as $row){
            $output .= '<option value="' . $row->idLetnik . '">' . $row->stevilka . "." . '</option>';
        }
        return $output;
    }

    public function fetch_oddelke($idLetnik){
        $this->db->select("crka, idOddelek");
        $this->db->from("oddelek");
        $this->db->where("Letnik_idLetnik", $idLetnik);
        $query = $this->db->get();
        $output = '<option value="">Izberite oddelek</option>';
        foreach($query->result() as $row){
            $output .= '<option value="' . $row->idOddelek . '">' . $row->crka . '</option>';
        }
        return $output;
    }

    
    public function pridobiKratice($naziv){

        $this->db->select("kratica");
        $this->db->from("sola");
        $this->db->where("idSola", $naziv);
        $query = $this->db->get();
        return $result = $query->result_array();
    }


    public function sestaviEmail($podatki, $kratica){
        $ime = $podatki["ime"];
        $priimek = $podatki["priimek"];
        $pretvornik1 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z', "č", "š", "ž", "Č", "Š", "Ž", "Ć", "ć");
        $pretvornik2 = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', "c", "s", "z", "c", "s", "z", "c", "c");
        $ime = str_replace($pretvornik1, $pretvornik2, $ime);
        $priimek = str_replace($pretvornik1, $pretvornik2, $priimek);
        $email = $ime . "." . $priimek . "@" . $podatki["vloga"] . "-" . $kratica . ".si";
        return($email);
    }


    public function iskanjeIDOsebe(){
        $this->db->select("idOseba");
        $this->db->from("oseba");
        $this->db->order_by("idOseba", "DESC");
        $this->db->limit("1");
        $query = $this->db->get();
        return $rezultat = $query->row_array();
    }

    public function vstavljanjeSolaHasOseba($podatki_array){
        return $this->db->insert("sola_has_oseba", $podatki_array);
    }

    public function isciUporabnika($niz){
        $this->db->select("idOseba, ime, priimek, vloga, eNaslov, spol");
        $this->db->from("oseba");
        $this->db->group_start();
            $this->db->like("ime", $niz);
            $this->db->or_like("priimek", $niz);
            $this->db->or_like("vloga", $niz);
                $this->db->or_group_start();
                    $this->db->or_where("CONCAT(ime, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(priimek, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(vloga, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(vloga, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(priimek, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(ime, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->group_end();
        $this->db->group_end();
        $this->db->order_by("vloga", "DESC");
        $this->db->order_by("priimek", "ASC");
        $query = $this->db->get();
        return $rezultat = $query->result_array();
    }

    public function profil($idOseba){
        $this->db->select('ime, priimek, crka, stevilka, nazivPrograma, nazivSole, eNaslov, vloga, datumRojstva');
        $this->db->from('oseba');
        $this->db->join("sola_has_oseba", "sola_has_oseba.Oseba_idOseba=oseba.idOseba", "left");
        $this->db->join("oddelek", "oddelek.idOddelek = oseba.Oddelek_idOddelek", "left");
        $this->db->join("letnik", "letnik.idLetnik = oddelek.Letnik_idLetnik", "left");
        $this->db->join("program", "program.idProgram = letnik.Program_idProgram", "left");
        $this->db->join("sola", "sola.idSola = program.Sola_idSola", "left");
        $this->db->where("idOseba", $idOseba);
        $query = $this->db->get();
        return $rezultat = $query->result_array();     
    }

    public function preveriUporabnikaZacasno($podatki_array){
        $this->db->select("idOseba, ime, priimek, datumRojstva, spol, eNaslov, vloga, sola_has_oseba.Sola_idSola, letnik.Program_idProgram, oddelek.Letnik_idLetnik, oseba.Oddelek_idOddelek, letnik.stevilka, oddelek.crka, sola.nazivSole, program.nazivPrograma");
        $this->db->from("oseba");
        $this->db->join("sola_has_oseba", "oseba.idOseba = sola_has_oseba.Oseba_idOseba", "left");
        $this->db->join("oddelek", "oddelek.idOddelek = oseba.Oddelek_idOddelek", "left");
        $this->db->join("letnik", "letnik.idLetnik = oddelek.Letnik_idLetnik", "left");
        $this->db->join("program", "program.idProgram = letnik.Program_idProgram", "left");
        $this->db->join("sola", "sola.idSola = program.Sola_idSola", "left");
        $this->db->where(array(
            "oseba.eNaslov" => $podatki_array["email"],
            "oseba.zacasnoGeslo" => $podatki_array["geslo"]
        ));
        $query = $this->db->get();
        return $rezultat = $query->row_array();
    }

    public function podatkiZapPrijavoOddelek($idOddelek){
        $this->db->select("*");
        $this->db->from("oseba");
        $this->db->where("Oddelek_idOddelek", $idOddelek);
        $this->db->where('zacasnoGeslo is NOT NULL', NULL, FALSE);
        $this->db->where('geslo is NULL', NULL, FALSE);
        $this->db->order_by('priimek', 'ASC');
        $this->db->order_by('ime', 'ASC');
        $data = $this->db->get();
        $output = "<div class='table-responsive'>
        <table class='table table-striped table-bordered'>
            <tr>
            <th>Ime</th>
            <th>Priimek</th>
            <th>datumRojstva</th>
            <th>eNaslov</th>
            <th>zacasnoGeslo</th>
            </tr>";
        foreach($data->result() as $row){
        $output .= '
        <tr>
        <td>'.$row->ime.'</td>
        <td>'.$row->priimek.'</td>
        <td>'.$row->datumRojstva.'</td>
        <td>'.$row->eNaslov.'</td>
        <td>'.$row->zacasnoGeslo.'</td>
        </tr>
        ';
        }
        $output .= '</table></div>';
        return $output;
    }

    public function podatkiZaPrijavoSola($idSola){
        $this->db->select("*");
        $this->db->from("oseba");
        $this->db->join("sola_has_oseba", "oseba.idOseba = sola_has_oseba.Oseba_idOseba");
        $this->db->where('Oddelek_idOddelek is NULL', NULL, FALSE);
        $this->db->where('zacasnoGeslo is NOT NULL', NULL, FALSE);
        $this->db->where('geslo is NULL', NULL, FALSE);
        $this->db->where("Sola_idSola", $idSola);
        $this->db->order_by('priimek', 'ASC');
        $this->db->order_by('ime', 'ASC');
        $data = $this->db->get();
        $output = "<div class='table-responsive'>
        <table class='table table-striped table-bordered'>
            <tr>
            <th>Ime</th>
            <th>Priimek</th>
            <th>datumRojstva</th>
            <th>eNaslov</th>
            <th>zacasnoGeslo</th>
            </tr>";
        foreach($data->result() as $row){
        $output .= '
        <tr>
        <td>'.$row->ime.'</td>
        <td>'.$row->priimek.'</td>
        <td>'.$row->datumRojstva.'</td>
        <td>'.$row->eNaslov.'</td>
        <td>'.$row->zacasnoGeslo.'</td>
        </tr>
        ';
        }
        $output .= '</table></div>';
        return $output;
    }

    public function izbrisiUporabnika($idOseba){
        $this->db->select('vloga');
        $this->db->from('oseba');
        $this->db->where("idOseba", $idOseba);
        $query = $this->db->get();
        $rezultat = $query->result_array();  

        if($rezultat[0]["vloga"] == "profesor"){
            $this->db->select('Dejavnost_idDejavnost');
            $this->db->from('oseba_has_dejavnost');
            $this->db->where("Oseba_idOseba", $idOseba);
            $this->db->where("avtor", 1);
            $query = $this->db->get();
            $rezultat = $query->result_array(); 

            $sez = array();
            foreach($rezultat as $vrstica){
                array_push($sez, $vrstica["Dejavnost_idDejavnost"]);
            }
            if($sez != null){
                $this->db->where_in("idDejavnost", $sez);
                $this->db->delete('prisotnost');
    
                $this->db->where_in("Dejavnost_idDejavnost", $sez);
                $this->db->delete('oseba_has_dejavnost');

                $this->db->where_in("idDejavnost", $sez);
                $this->db->delete('dejavnost');
            }

            $this->db->where('Oseba_idOseba', $idOseba);
            $this->db->delete('sola_has_oseba');
    
            $this->db->where('idOseba', $idOseba);
            $this->db->delete('oseba');
        }
        elseif($rezultat[0]["vloga"] == "dijak"){

            $this->db->where('idOseba', $idOseba);
            $this->db->delete('prisotnost');

            $this->db->where('Oseba_idOseba', $idOseba);
            $this->db->delete('oseba_has_dejavnost');

            $this->db->where('Oseba_idOseba', $idOseba);
            $this->db->delete('sola_has_oseba');
    
            $this->db->where('idOseba', $idOseba);
            $this->db->delete('oseba');
        }


        }
    }