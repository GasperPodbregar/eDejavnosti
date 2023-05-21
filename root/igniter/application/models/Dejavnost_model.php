<?php

class Dejavnost_model extends CI_Model{

public function pridobiDejavnostiZaPrijavo($idOseba){
    $query = $this->db->query("SELECT Oseba_idOseba, Dejavnost_idDejavnost, avtor, idDejavnost, moznaMesta, opis, malica, naziv, datumZacetek, datumKonec, mozneSole, mozniProgrami, mozniLetniki, mozniOddelki, ime, priimek, odobreno FROM dejavnost 
    JOIN oseba_has_dejavnost ON oseba_has_dejavnost.Dejavnost_idDejavnost=Dejavnost.idDejavnost
    JOIN oseba ON oseba.idOseba=oseba_has_dejavnost.Oseba_idOseba
    WHERE moznaMesta > 0 AND Oseba_idOseba != $idOseba AND avtor = 1 AND stanje = 1 AND Dejavnost_idDejavnost NOT IN (SELECT Dejavnost_idDejavnost from oseba_has_dejavnost where Oseba_idOseba = $idOseba)");
    return $rezultat = $query->result_array();
}

public function pridobiPrograme($idSole){
    $this->db->select("nazivPrograma, idProgram");
    $this->db->from("program");
    $this->db->where("Sola_idSola", $idSole);
    $query = $this->db->get();
    return $rezultat = $query->result_array();
}

public function pridobiSole($idOseba){
    $this->db->select("idSola, nazivSole");
    $this->db->from("sola");
    $this->db->join("sola_has_oseba", "sola_has_oseba.Sola_idSola=sola.idSola", "inner");
    $this->db->where("sola_has_oseba.Oseba_idOseba", $idOseba);
    $query = $this->db->get();
    return $rezultat = $query->result_array();
}

public function vstavljanjeDejavnosti($podatki_array){
    return $this->db->insert("dejavnost", $podatki_array);
}

public function vstavljanjeAvtorja($podatki_array){
    return $this->db->insert("oseba_has_dejavnost", $podatki_array);
}

public function iskanjeID(){
    $this->db->select("idDejavnost");
    $this->db->from("dejavnost");
    $this->db->order_by("idDejavnost", "DESC");
    $this->db->limit("1");
    $query = $this->db->get();
    return $rezultat = $query->row_array();
}

public function mojeDejavnostiProfesor($idOseba){
    $this->db->select("*");
    $this->db->from("dejavnost");
    $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
    $this->db->where("oseba_has_dejavnost.Oseba_idOseba", $idOseba);
    $this->db->where("avtor", 1);
    $this->db->where("stanje", 1);
    $this->db->order_by('casVnosa', 'DESC');
    $query = $this->db->get();
    return $rezultat = $query->result_array();
    
}

public function mojeDejavnostiDijak($idOseba){
    $this->db->select("Oseba_idOseba, Dejavnost_idDejavnost, avtor, idDejavnost, moznaMesta, opis, malica, naziv, datumZacetek, datumKonec, mozneSole, mozniProgrami, mozniLetniki, mozniOddelki, ime, priimek, odobreno");
    $this->db->from("dejavnost");
    $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
    $this->db->join("oseba", "oseba.idOseba=oseba_has_dejavnost.Oseba_idOseba");
    $this->db->where("oseba_has_dejavnost.Oseba_idOseba", $idOseba);
    $this->db->where("odobreno", 1);
    $this->db->where("stanje", 1);
    $this->db->order_by('casVnosa', 'DESC');
    $query = $this->db->get();
    return $rezultat = $query->result_array();
}

public function fetch_programe($idSola){
    $this->db->select("nazivPrograma, idProgram");
    $this->db->from("program");
    $this->db->where_in("Sola_idSola", $idSola);
    $query = $this->db->get();
    $output = '';
    foreach($query->result() as $row){
        $output .= '<option value="' . $row->idProgram . '">' . $row->nazivPrograma . '</option>';
    }
    return $output;
}

public function fetch_letnike($idProgram){
    $this->db->select("stevilka, kraticaProgram, idLetnik");
    $this->db->from("letnik");
    $this->db->where_in("Program_idProgram", $idProgram);
    $query = $this->db->get();
    $output = '';
    foreach($query->result() as $row){
        $output .= '<option value="' . $row->idLetnik . '">' . $row->stevilka . ". " . $row->kraticaProgram . '</option>';
    }
    return $output;
}

public function fetch_oddelke($idLetnik){
    $this->db->select("crka, idOddelek");
    $this->db->from("oddelek");
    $this->db->where_in("Letnik_idLetnik", $idLetnik);
    $query = $this->db->get();
    $output = '';
    foreach($query->result() as $row){
        $output .= '<option value="' . $row->idOddelek . '">' . $row->crka . '</option>';
    }
    return $output;
}

public function imenaSol($id){
    $this->db->select("nazivSole");
    $this->db->from("sola");
    $this->db->where_in("idSola", $id);
    $query = $this->db->get();
    return $rezultat = $query->result_array();    
}

public function imenaProgramov($id){
    $this->db->select("nazivPrograma");
    $this->db->from("program");
    $this->db->where_in("idProgram", $id);
    $query = $this->db->get();
    return $rezultat = $query->result_array();    
}

public function imenaLetnikov($id){
    $this->db->select("stevilka");
    $this->db->from("letnik");
    $this->db->where_in("idLetnik", $id);
    $query = $this->db->get();
    return $rezultat = $query->result_array();    
}

public function imenaOddelkov($id){
    $this->db->select("crka");
    $this->db->from("oddelek");
    $this->db->where_in("idOddelek", $id);
    $query = $this->db->get();
    return $rezultat = $query->result_array();    
}

public function poveziVse($idSola, $sezProgramov, $sezLetnikov, $sezOddelkov){
    $this->db->select("nazivSole, nazivPrograma, stevilka, crka");
    $this->db->from("sola");
    $this->db->join("program", "program.Sola_idSola=sola.idSola", "inner");
    $this->db->join("letnik", "letnik.Program_idProgram=program.idProgram", "inner");
    $this->db->join("oddelek", "oddelek.Letnik_idLetnik=letnik.idLetnik", "inner");
    $this->db->where("idSola", $idSola);
    $this->db->where_in("idProgram", $sezProgramov);
    $this->db->where_in("idLetnik", $sezLetnikov);
    $this->db->where_in("idOddelek", $sezOddelkov);
    $query = $this->db->get();
    return $rezultat = $query->result_array();
}

public function pridobiSoleAdmin(){
    $this->db->select("idSola, nazivSole");
    $this->db->from("sola");
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function prosnjaZaPrijavo($prosnja){
    return $this->db->insert("oseba_has_dejavnost", $prosnja);
}

public function preveriRazpoložljivost($idDejavnost){
    $this->db->select("idDejavnost");
    $this->db->from("dejavnost");
    $this->db->where("idDejavnost", $idDejavnost);
    $this->db->where("moznaMesta > 0");
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function pridobiProsnjeDejavnost($idOseba, $idDejavnost){
    $this->db->select("Dejavnost_idDejavnost");
    $this->db->from("oseba_has_dejavnost");
    $this->db->where("Dejavnost_idDejavnost", $idDejavnost);
    $this->db->where("Oseba_idOseba", $idOseba);
   // $this->db->where("(SELECT '*' from 'oseba_has_dejavnost' where 'Oseba_idOseba', $idOseba)");
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function pridobiProsnjeUcenec($sezDejavnosti){
    $this->db->select("*");
    $this->db->from("oseba_has_dejavnost");
    $this->db->where_in("Dejavnost_idDejavnost", $sezDejavnosti);
    $this->db->where("odobreno", 3);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function pridobiProsnjeUcenecAdmin($sezDejavnosti){
    $this->db->select("*");
    $this->db->from("oseba_has_dejavnost");
    $this->db->where_in("Dejavnost_idDejavnost", $sezDejavnosti);
    $this->db->where("odobreno", 1);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function preveriObstojProsnje($prosnja){
    $this->db->select("Oseba_idOseba");
    $this->db->from("oseba_has_dejavnost");
    $this->db->where("Dejavnost_idDejavnost", $prosnja["Dejavnost_idDejavnost"]);
    $this->db->where("Oseba_idOseba", $prosnja["Oseba_idOseba"]);
    //$this->db->where("avtor", $prosnja["avtor"]);
    //$this->db->where("odobreno", $prosnja["odobreno"]);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function dijaKiJePoslalProsnjo($idOseba, $idDejavnost){
    $this->db->select("*");
    $this->db->from("oseba_has_dejavnost");
    $this->db->join("oseba", "oseba.idOseba=oseba_has_dejavnost.Oseba_idOseba", "inner");
    $this->db->join("dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost", "inner");
    $this->db->where("Dejavnost_idDejavnost", $idDejavnost);
    $this->db->where("Oseba_idOseba", $idOseba);
    $query = $this->db->get();
    return $rezultat = $query->row_array(); 
}

public function prijavaNiMozna($idOseba){
    $this->db->select("Dejavnost_idDejavnost");
    $this->db->from("oseba_has_dejavnost");
    $this->db->where("Oseba_idOseba", $idOseba);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function brisiDejavnost($id){
    $this->db->where("idDejavnost", $id);
    $this->db->delete("prisotnost");
    
    $this->db->where("Dejavnost_idDejavnost", $id);
    $this->db->delete("oseba_has_dejavnost");

    $this->db->where("idDejavnost", $id);
    $this->db->delete("dejavnost");

    return(1);
}

public function spreminjanjeDejavnosti($id){
    $this->db->select("*");
    $this->db->from("dejavnost");
    $this->db->where("idDejavnost", $id);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function posodobitevDejavnosti($podatki){
    $this->db->set("moznaMesta", $podatki["moznaMesta"]);
    $this->db->set("opis", $podatki["opis"]);
    $this->db->set("malica", $podatki["malica"]);
    $this->db->set("naziv", $podatki["naziv"]);
    $this->db->set("datumZacetek", $podatki["datumZacetek"]);
    $this->db->set("datumKonec", $podatki["datumKonec"]);
    $this->db->where('idDejavnost', $podatki["idDejavnost"]);
    $this->db->update('dejavnost');

    return(1);
}

public function pridobiProsnjeDejavnostAdmin($idDejavnost){
    $this->db->select("*");
    $this->db->from("oseba_has_dejavnost");
    $this->db->where("avtor", 0);
    $this->db->where("odobreno", 1);
    $this->db->where("Dejavnost_idDejavnost", $idDejavnost);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function vseDejavnosti(){
    $this->db->select("Oseba_idOseba, Dejavnost_idDejavnost, avtor, idDejavnost, moznaMesta, opis, malica, naziv, datumZacetek, datumKonec, mozneSole, mozniProgrami, mozniLetniki, mozniOddelki, ime, priimek");
    $this->db->from("dejavnost");
    $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
    $this->db->join("oseba", "oseba.idOseba=oseba_has_dejavnost.Oseba_idOseba");
    $this->db->where("avtor", 1);
    $this->db->where("stanje", 1);
    $this->db->order_by('casVnosa', 'DESC');
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function rocnaPrijava(){
    $this->db->select("*");
    $this->db->from("dejavnost");
    $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
    $this->db->where("avtor", 1);
    $this->db->where("moznaMesta > 0");
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function mozniDijaki($sezOddelkov, $id){

$this->db->distinct();
$this->db->select('Oseba_idOseba');
$this->db->from('oseba_has_dejavnost');
$this->db->where("Dejavnost_idDejavnost", $id);
$this->db->where("avtor", 0);
$this->db->where("odobreno", 1);

$where_clause = $this->db->get_compiled_select();

$this->db->select('idOseba');
$this->db->from('oseba');
$this->db->where_in("Oddelek_idOddelek", $sezOddelkov);

$where_clause2 = $this->db->get_compiled_select();


$this->db->distinct();
$this->db->select('idOseba, ime, priimek');
$this->db->from('oseba');
$this->db->where("`idOseba` NOT IN ($where_clause)", NULL, FALSE);
$this->db->where("`idOseba` IN ($where_clause2)", NULL, FALSE);

$query = $this->db->get();
return $rezultat = $query->result_array();
}

public function prosnjaZaPrijavoPotrjeno($prosnja, $id){
    $this->db->set("moznaMesta", "moznaMesta-1", FALSE);
    $this->db->where("idDejavnost", $id);
    $this->db->update("dejavnost");

    return $this->db->insert("oseba_has_dejavnost", $prosnja);
}

public function rocnaPrijavaProfesor($idOseba){
    $this->db->select("*");
    $this->db->from("dejavnost");
    $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
    $this->db->where("avtor", 1);
    $this->db->where("moznaMesta > 0");
    $this->db->where("Oseba_idOseba", $idOseba);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}


public function PrijavaPridobiMoznaMesta($id){
    $this->db->select("moznaMesta");
    $this->db->from("dejavnost");
    $this->db->where("idDejavnost", $id);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}



public function pridobiProsnjeDejavnostProfesor($idProfesor, $idDejavnost){
    #Create where clause
    $this->db->distinct();
    $this->db->select('Dejavnost_idDejavnost');
    $this->db->from('oseba_has_dejavnost');
    $this->db->where("Oseba_idOseba", $idProfesor);
    $this->db->where("Dejavnost_idDejavnost", $idDejavnost);


    $where_clause = $this->db->get_compiled_select();


    #Create main query
    $this->db->distinct();
    $this->db->select('*');
    $this->db->from('oseba_has_dejavnost');
    $this->db->where("`Dejavnost_idDejavnost` IN ($where_clause)", NULL, FALSE);
    $this->db->where("avtor", 0);
    $this->db->where("odobreno", 1);
    $query = $this->db->get();
    return $rezultat = $query->result_array();
}

public function izbrisiProsnjoCeObstaja($prosnja){
    $this->db->where("Dejavnost_idDejavnost", $prosnja["Dejavnost_idDejavnost"]);
    $this->db->where("Oseba_idOseba", $prosnja["Oseba_idOseba"]);
    $this->db->delete("oseba_has_dejavnost");
}

public function domovDijak($idOseba){
    $this->db->select("odobreno, naziv, casVnosa");
    $this->db->from("oseba");
    $this->db->join("oseba_has_dejavnost", "idOseba=Oseba_idOseba");
    $this->db->join("dejavnost", "Dejavnost_idDejavnost=idDejavnost");
    $this->db->where("idOseba", $idOseba);
    $this->db->where("stanje", 1);
    $this->db->order_by('casVnosa', 'DESC');
    $this->db->limit("50");
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function domovProfesor($idOseba){
    $this->db->distinct();
    $this->db->select('Dejavnost_idDejavnost');
    $this->db->from('oseba_has_dejavnost');
    $this->db->where("Oseba_idOseba", $idOseba);
    $this->db->where("avtor", 1);
    $this->db->order_by('casVnosa', 'DESC');
    
    
    $where_clause = $this->db->get_compiled_select();


    $this->db->select("odobreno, naziv, casVnosa, ime, priimek");
    $this->db->from("oseba");
    $this->db->join("oseba_has_dejavnost", "idOseba=Oseba_idOseba");
    $this->db->join("dejavnost", "Dejavnost_idDejavnost=idDejavnost");
    $this->db->where("`Dejavnost_idDejavnost` IN ($where_clause)", NULL, FALSE);
    $this->db->where("stanje", 1);
    $this->db->order_by('casVnosa', 'DESC');
    $this->db->limit("50");
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function domovAdmin(){
    $this->db->select("odobreno, naziv, casVnosa, ime, priimek, vloga");
    $this->db->from("oseba");
    $this->db->join("oseba_has_dejavnost", "idOseba=Oseba_idOseba");
    $this->db->join("dejavnost", "Dejavnost_idDejavnost=idDejavnost");
    $this->db->order_by('casVnosa', 'DESC');
    $this->db->where("stanje", 1);
    $this->db->limit("50");
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function pridobiVseProsnje(){
    $this->db->select("Dejavnost_idDejavnost");
    $this->db->from("oseba_has_dejavnost");
   // $this->db->where("(SELECT '*' from 'oseba_has_dejavnost' where 'Oseba_idOseba', $idOseba)");
    $this->db->where("avtor", 1);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function pridobiUdelezence($idDejavnost){
    $this->db->select("ime, priimek, naziv, stevilka, crka, nazivPrograma, nazivSole, idDejavnost");
    $this->db->from("oseba_has_dejavnost");
    $this->db->join("dejavnost", "Dejavnost_idDejavnost=idDejavnost");
    $this->db->join("oseba", "oseba.idOseba=oseba_has_dejavnost.Oseba_idOseba");
    $this->db->join("oddelek", "oddelek.idOddelek = oseba.Oddelek_idOddelek");
    $this->db->join("letnik", "letnik.idLetnik = oddelek.Letnik_idLetnik");
    $this->db->join("program", "program.idProgram = letnik.Program_idProgram");
    $this->db->join("sola", "sola.idSola = program.Sola_idSola");
    $this->db->where("idDejavnost", $idDejavnost);
    $this->db->where("avtor", 0);
    $this->db->where("odobreno", 1);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}


public function pridobiMentorja($idDejavnost){
    $this->db->select("CONCAT(ime, ' ', priimek) AS imePriimek");
    $this->db->from("oseba_has_dejavnost");
    $this->db->join("oseba", "oseba.idOseba=oseba_has_dejavnost.Oseba_idOseba");
    $this->db->where("Dejavnost_idDejavnost", $idDejavnost);
    $this->db->where("avtor", 1);
    $this->db->order_by('casVnosa', 'DESC');
    $this->db->limit("50");
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

    public function isciDejavnostiAdmin($niz){
        $this->db->select("Oseba_idOseba, Dejavnost_idDejavnost, avtor, idDejavnost, moznaMesta, opis, malica, naziv, datumZacetek, datumKonec, mozneSole, mozniProgrami, mozniLetniki, mozniOddelki, ime, priimek");
        $this->db->from("dejavnost");
        $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
        $this->db->join("oseba", "oseba.idOseba=oseba_has_dejavnost.Oseba_idOseba");
        $this->db->group_start();
        $this->db->where("avtor", 1);
        $this->db->where("stanje", 1);
        $this->db->group_start();
        $this->db->like("ime", $niz);
        $this->db->or_like("priimek", $niz);
        $this->db->or_like("naziv", $niz);
        $this->db->or_group_start();
        $this->db->where("CONCAT(ime, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->group_end();
        $this->db->group_end();
        $this->db->group_end();
        $this->db->order_by('casVnosa', 'DESC');
        $query = $this->db->get();
        return $rezultat = $query->result_array(); 
    }

    public function isciDejavnostiProfesor($niz, $idOseba){
        $this->db->select("dejavnost.*, ime, priimek");
        $this->db->from("oseba");
        $this->db->join("oseba_has_dejavnost", "idOseba=Oseba_idOseba");
        $this->db->join("dejavnost", "Dejavnost_idDejavnost=idDejavnost");
        $this->db->where("idOseba", $idOseba);
        $this->db->where("stanje", 1);
        $this->db->like("naziv", $niz);
        $this->db->order_by('casVnosa', 'DESC');
        $query = $this->db->get();
        return $rezultat = $query->result_array(); 
    }

    public function isciRelacijeProfesor($niz, $idOseba){
        $this->db->distinct();
        $this->db->select('Dejavnost_idDejavnost');
        $this->db->from('oseba_has_dejavnost');
        $this->db->where("Oseba_idOseba", $idOseba);
        $this->db->where("avtor", 1);
       
        $where_clause = $this->db->get_compiled_select();

        $this->db->select("odobreno, naziv, casVnosa, ime, priimek");
        $this->db->from("oseba");
        $this->db->join("oseba_has_dejavnost", "idOseba=Oseba_idOseba");
        $this->db->join("dejavnost", "Dejavnost_idDejavnost=idDejavnost");
        $this->db->where("stanje", 1);
        $this->db->where("`Dejavnost_idDejavnost` IN ($where_clause)", NULL, FALSE);
        $this->db->group_start();
        $this->db->where("CONCAT(ime, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->or_where("CONCAT(priimek, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->or_where("CONCAT(vloga, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->or_where("CONCAT(vloga, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->or_where("CONCAT(priimek, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->or_where("CONCAT(ime, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->or_group_start();
        $this->db->like("ime", $niz);
        $this->db->or_like("priimek", $niz);
        $this->db->or_like("naziv", $niz);
        $this->db->group_end();
        $this->db->group_end();              
        $this->db->order_by('casVnosa', 'DESC');
        $query = $this->db->get();
        return $rezultat = $query->result_array();
    }

    public function isciRelacijeAdmin($niz){
        $this->db->select("odobreno, naziv, casVnosa, ime, priimek");
        $this->db->from("oseba");
        $this->db->join("oseba_has_dejavnost", "idOseba=Oseba_idOseba");
        $this->db->join("dejavnost", "Dejavnost_idDejavnost=idDejavnost");
        $this->db->where("stanje", 1);
        $this->db->group_start();
        $this->db->where("CONCAT(ime, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->or_where("CONCAT(priimek, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->or_where("CONCAT(vloga, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->or_where("CONCAT(vloga, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->or_where("CONCAT(priimek, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->or_where("CONCAT(ime, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->or_group_start();
        $this->db->like("ime", $niz);
        $this->db->or_like("priimek", $niz);
        $this->db->or_like("naziv", $niz);
        $this->db->group_end();
        $this->db->group_end();              
        $this->db->order_by('casVnosa', 'DESC');
        $query = $this->db->get();
        return $rezultat = $query->result_array();
    }

    public function vseZakljuceneDejavnosti(){
        $this->db->select("Oseba_idOseba, Dejavnost_idDejavnost, avtor, idDejavnost, moznaMesta, opis, malica, naziv, datumZacetek, datumKonec, mozneSole, mozniProgrami, mozniLetniki, mozniOddelki, ime, priimek");
        $this->db->from("dejavnost");
        $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
        $this->db->join("oseba", "oseba.idOseba=oseba_has_dejavnost.Oseba_idOseba");
        $this->db->where("avtor", 1);
        $this->db->where("stanje", 2);
        $this->db->order_by('casVnosa', 'DESC');
        $query = $this->db->get();
        return $rezultat = $query->result_array(); 
    }

    public function isciZakljuceneDejavnostiAdmin($niz){
        $this->db->select("Oseba_idOseba, Dejavnost_idDejavnost, avtor, idDejavnost, moznaMesta, opis, malica, naziv, datumZacetek, datumKonec, mozneSole, mozniProgrami, mozniLetniki, mozniOddelki, ime, priimek");
        $this->db->from("dejavnost");
        $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
        $this->db->join("oseba", "oseba.idOseba=oseba_has_dejavnost.Oseba_idOseba");
        $this->db->group_start();
        $this->db->where("avtor", 1);
        $this->db->where("stanje", 2);
        $this->db->group_start();
        $this->db->like("ime", $niz);
        $this->db->or_like("priimek", $niz);
        $this->db->or_like("naziv", $niz);
        $this->db->or_group_start();
        $this->db->where("CONCAT(ime, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->or_where("CONCAT(priimek, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
        $this->db->group_end();
        $this->db->group_end();
        $this->db->group_end();
        $this->db->order_by('casVnosa', 'DESC');
        $query = $this->db->get();
        return $rezultat = $query->result_array(); 
    }

    public function mojeZakljuceneDejavnostiProfesor($idOseba){
        $this->db->select("*");
        $this->db->from("dejavnost");
        $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
        $this->db->where("oseba_has_dejavnost.Oseba_idOseba", $idOseba);
        $this->db->where("avtor", 1);
        $this->db->where("stanje", 2);
        $this->db->order_by('casVnosa', 'DESC');
        $query = $this->db->get();
        return $rezultat = $query->result_array();
        
    }
    
    public function isciZakljuceneDejavnostiProfesor($niz, $idOseba){
        $this->db->select("dejavnost.*, ime, priimek");
        $this->db->from("oseba");
        $this->db->join("oseba_has_dejavnost", "idOseba=Oseba_idOseba");
        $this->db->join("dejavnost", "Dejavnost_idDejavnost=idDejavnost");
        $this->db->where("idOseba", $idOseba);
        $this->db->where("stanje", 2);
        $this->db->like("naziv", $niz);
        $this->db->order_by('casVnosa', 'DESC');
        $query = $this->db->get();
        return $rezultat = $query->result_array(); 
    }

    public function potrditevUstvariPrisotnost($idDejavnost, $idDijaka){
        $this->db->select("datumZacetek, datumKonec");
        $this->db->from("dejavnost");
        $this->db->where("idDejavnost", $idDejavnost);
        $query = $this->db->get();
        $rezultat = $query->result_array();
    
        $datumi = array();
        $zacetek =  strtotime($rezultat[0]["datumZacetek"]);
        $konec = strtotime($rezultat[0]["datumKonec"]);
        $step = '+1 day';
        $output_format = 'Y/m/d';
        while( $zacetek <= $konec ) {
            $datumi[] = date($output_format, $zacetek);
            $zacetek = strtotime($step, $zacetek);
        }
    
        foreach($datumi as $datum){
    
            $prisotnost = array(
                'idOseba' => $idDijaka,
                'idDejavnost' => $idDejavnost,
                'datum' => $datum
            );
    
            $this->db->insert("prisotnost", $prisotnost);
        }
    }
    public function izbrisiPrisotnostZaOsebo($idDejavnost, $idOseba){
        $this->db->where("idDejavnost", $idDejavnost);
        $this->db->where("idOseba", $idOseba);
        $this->db->delete("prisotnost");
    }

    public function mojeZakljuceneDejavnostiDijak($idOseba){
        $this->db->select("Oseba_idOseba, Dejavnost_idDejavnost, avtor, idDejavnost, moznaMesta, opis, malica, naziv, datumZacetek, datumKonec, mozneSole, mozniProgrami, mozniLetniki, mozniOddelki, ime, priimek, odobreno");
        $this->db->from("dejavnost");
        $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
        $this->db->join("oseba", "oseba.idOseba=oseba_has_dejavnost.Oseba_idOseba");
        $this->db->where("oseba_has_dejavnost.Oseba_idOseba", $idOseba);
        $this->db->where("odobreno", 1);
        $this->db->where("stanje", 2);
        $this->db->order_by('casVnosa', 'DESC');
        $query = $this->db->get();
        return $rezultat = $query->result_array();
    }

    
        
        public function isciRelacijeProfesorVrsta($niz, $vrsta, $idOseba){
            $this->db->distinct();
            $this->db->select('Dejavnost_idDejavnost');
            $this->db->from('oseba_has_dejavnost');
            $this->db->where("Oseba_idOseba", $idOseba);
            $this->db->where("avtor", 1);
           
            $where_clause = $this->db->get_compiled_select();
    
            $this->db->select("odobreno, naziv, casVnosa, ime, priimek");
            $this->db->from("oseba");
            $this->db->join("oseba_has_dejavnost", "idOseba=Oseba_idOseba");
            $this->db->join("dejavnost", "Dejavnost_idDejavnost=idDejavnost");
            if($vrsta == "ustvarjeno"){
                $this->db->where("`Dejavnost_idDejavnost` IN ($where_clause)", NULL, FALSE);
                $this->db->where(array('odobreno' => NULL));
                $this->db->where("stanje", 1);
                $this->db->group_start();
                    $this->db->where("CONCAT(ime, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(priimek, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(vloga, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(vloga, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(priimek, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(ime, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                        $this->db->or_group_start();
                            $this->db->like("ime", $niz);
                            $this->db->or_like("priimek", $niz);
                            $this->db->or_like("naziv", $niz);
                        $this->db->group_end();
                $this->db->group_end();
            }
            elseif($vrsta == "prošnja"){
                $this->db->where("`Dejavnost_idDejavnost` IN ($where_clause)", NULL, FALSE);
                $this->db->where("stanje", 1);
                $this->db->where("odobreno", 3);
                $this->db->group_start();
                $this->db->where("CONCAT(ime, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(priimek, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(vloga, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(vloga, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(priimek, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(ime, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_group_start();
                        $this->db->like("ime", $niz);
                        $this->db->or_like("priimek", $niz);
                        $this->db->or_like("naziv", $niz);
                    $this->db->group_end();
                $this->db->group_end();
            }
            elseif($vrsta == "odobreno"){
                $this->db->where("`Dejavnost_idDejavnost` IN ($where_clause)", NULL, FALSE);
                $this->db->where("odobreno", 1);
                $this->db->where("stanje", 1);
                $this->db->group_start();
                $this->db->where("CONCAT(ime, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(priimek, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(vloga, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(vloga, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(priimek, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(ime, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_group_start();
                        $this->db->like("ime", $niz);
                        $this->db->or_like("priimek", $niz);
                        $this->db->or_like("naziv", $niz);
                    $this->db->group_end();
                $this->db->group_end();
            }
            else{
                $this->db->where("`Dejavnost_idDejavnost` IN ($where_clause)", NULL, FALSE);
                $this->db->where("odobreno", 2);
                $this->db->where("stanje", 1);
                $this->db->group_start();
                $this->db->where("CONCAT(ime, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(priimek, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(vloga, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(vloga, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(priimek, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(ime, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_group_start();
                        $this->db->like("ime", $niz);
                        $this->db->or_like("priimek", $niz);
                        $this->db->or_like("naziv", $niz);
                    $this->db->group_end();
                $this->db->group_end();
            }                 
            $this->db->order_by('casVnosa', 'DESC');
            $query = $this->db->get();
            return $rezultat = $query->result_array();
        }

        public function isciRelacijeAdminVrsta($niz, $vrsta){
            $this->db->select("odobreno, naziv, casVnosa, ime, priimek");
            $this->db->from("oseba");
            $this->db->join("oseba_has_dejavnost", "idOseba=Oseba_idOseba");
            $this->db->join("dejavnost", "Dejavnost_idDejavnost=idDejavnost");
            if($vrsta == "ustvarjeno"){
                $this->db->where(array('odobreno' => NULL));
                $this->db->where("stanje", 1);
                $this->db->group_start();
                    $this->db->where("CONCAT(ime, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(priimek, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(vloga, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(vloga, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(priimek, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_where("CONCAT(ime, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                        $this->db->or_group_start();
                            $this->db->like("ime", $niz);
                            $this->db->or_like("priimek", $niz);
                            $this->db->or_like("naziv", $niz);
                        $this->db->group_end();
                $this->db->group_end();
            }
            elseif($vrsta == "prošnja"){
                $this->db->where("stanje", 1);
                $this->db->where("odobreno", 3);
                $this->db->group_start();
                $this->db->where("CONCAT(ime, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(priimek, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(vloga, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(vloga, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(priimek, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(ime, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_group_start();
                        $this->db->like("ime", $niz);
                        $this->db->or_like("priimek", $niz);
                        $this->db->or_like("naziv", $niz);
                    $this->db->group_end();
                $this->db->group_end();
            }
            elseif($vrsta == "odobreno"){
                $this->db->where("odobreno", 1);
                $this->db->where("stanje", 1);
                $this->db->group_start();
                $this->db->where("CONCAT(ime, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(priimek, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(vloga, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(vloga, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(priimek, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(ime, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_group_start();
                        $this->db->like("ime", $niz);
                        $this->db->or_like("priimek", $niz);
                        $this->db->or_like("naziv", $niz);
                    $this->db->group_end();
                $this->db->group_end();
            }
            else{
                $this->db->where("odobreno", 2);
                $this->db->where("stanje", 1);
                $this->db->group_start();
                $this->db->where("CONCAT(ime, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(priimek, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(vloga, ' ', ime) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(vloga, ' ', priimek) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(priimek, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                $this->db->or_where("CONCAT(ime, ' ', vloga) LIKE '%".$niz."%'", NULL, FALSE);
                    $this->db->or_group_start();
                        $this->db->like("ime", $niz);
                        $this->db->or_like("priimek", $niz);
                        $this->db->or_like("naziv", $niz);
                    $this->db->group_end();
                $this->db->group_end();
            }                 
            $this->db->order_by('casVnosa', 'DESC');
            $query = $this->db->get();
            return $rezultat = $query->result_array();
        }
        
        public function pridobiZavrnitevProfesor($idProfesor, $idDejavnost){
            $this->db->select("*");
            $this->db->from("oseba_has_dejavnost");
            $this->db->where_in("Dejavnost_idDejavnost", $idDejavnost);
            $this->db->where("odobreno", 1);
            $query = $this->db->get();
            return $rezultat = $query->result_array(); 
        }


}