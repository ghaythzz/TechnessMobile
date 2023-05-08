/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycomany.entities;

import java.util.Date;

/**
 *
 * @author asus
 */
public class Fiche {
    private int id;
    private Date dateNaissance;
    private int tel;
    private String etatClinique;

    public Fiche(int tel,String etatClinique, String genre, String TypeAssurance) {
        this.tel = tel;
        this.etatClinique = etatClinique;
        this.genre = genre;
        this.TypeAssurance = TypeAssurance;
    }
    private String genre;
    private String TypeAssurance;

    public Fiche() {
    }

    public Fiche(int id, Date dateNaissance, int tel, String etatClinique, String genre, String TypeAssurance) {
        this.id = id;
        this.dateNaissance = dateNaissance;
        this.tel = tel;
        this.etatClinique = etatClinique;
        this.genre = genre;
        this.TypeAssurance = TypeAssurance;
    }

    public int getId() {
        return id;
    }

    public Date getDateNaissance() {
        return dateNaissance;
    }

    public int getTel() {
        return tel;
    }

    public String getEtatClinique() {
        return etatClinique;
    }

    public String getGenre() {
        return genre;
    }

    public String getTypeAssurance() {
        return TypeAssurance;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setDateNaissance(Date dateNaissance) {
        this.dateNaissance = dateNaissance;
    }

    public void setTel(int tel) {
        this.tel = tel;
    }

    public void setEtatClinique(String etatClinique) {
        this.etatClinique = etatClinique;
    }

    public void setGenre(String genre) {
        this.genre = genre;
    }

    public void setTypeAssurance(String TypeAssurance) {
        this.TypeAssurance = TypeAssurance;
    }

    @Override
    public String toString() {
        return "Fiche{" + "id=" + id + ", dateNaissance=" + dateNaissance + ", tel=" + tel + ", etatClinique=" + etatClinique + ", genre=" + genre + ", TypeAssurance=" + TypeAssurance + '}';
    }
    
}
