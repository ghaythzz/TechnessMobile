/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycomany.entities;

/**
 *
 * @author asus
 */
public class Medicament {
    private int id;
    int medicament;
    private String nom;
    private String type;
    private int nb_dose;
    private int stock;
    private int prix;
    int dosage;
    int duration;

    public Medicament() {
    }

    public Medicament(int id, int medicament, int dosage, int duration) {
        this.id = id;
        this.medicament = medicament;
        this.dosage = dosage;
        this.duration = duration;
    }

    public Medicament(int medicament, int dosage, int duration) {
        this.medicament = medicament;
        this.dosage = dosage;
        this.duration = duration;
    }

    public int getId() {
        return id;
    }

    public int getMedicament() {
        return medicament;
    }

    public int getDosage() {
        return dosage;
    }

    public int getDuration() {
        return duration;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setMedicament(int medicament) {
        this.medicament = medicament;
    }

    public void setDosage(int dosage) {
        this.dosage = dosage;
    }

    public void setDuration(int duration) {
        this.duration = duration;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public int getNb_dose() {
        return nb_dose;
    }

    public void setNb_dose(int nb_dose) {
        this.nb_dose = nb_dose;
    }
   
    

    public int getStock() {
        return stock;
    }

    public void setStock(int stock) {
        this.stock = stock;
    }

    public int getPrix() {
        return prix;
    }

    public void setPrix(int prix) {
        this.prix = prix;
    }
    
}
