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
public class Ordonnance {
    private int id;
    private String nomMedecin;
    private String nomPatient;
    private String date;
    int doctor_id;
    int patient_id;
    private String commentaire;
    private String medicaments;
    private String dosage;
    private String duration;

    public Ordonnance(String commentaire, String medicaments, String dosage, String duration) {
        this.commentaire = commentaire;
        this.medicaments = medicaments;
        this.dosage = dosage;
        this.duration = duration;
    }
    
    public void setMedicaments(String medicaments) {
        this.medicaments = medicaments;
    }

    public void setDosage(String dosage) {
        this.dosage = dosage;
    }

    public void setDuration(String duration) {
        this.duration = duration;
    }

    public String getMedicaments() {
        return medicaments;
    }

    public String getDosage() {
        return dosage;
    }

    public String getDuration() {
        return duration;
    }

    public Ordonnance() {
    }

    public Ordonnance(int id, String nomMedecin, String nomPatient, String date, String commentaire) {
        this.id = id;
        this.nomMedecin = nomMedecin;
        this.nomPatient = nomPatient;
        this.date = date;
        this.commentaire = commentaire;
    }

    public Ordonnance(String commentaire) {
        this.commentaire = commentaire;
    }

    public Ordonnance(String nomMedecin, String nomPatient, String commentaire) {
        this.nomMedecin = nomMedecin;
        this.nomPatient = nomPatient;
        this.commentaire = commentaire;
    }

    
    
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }
    
    public String getNomMedecin() {
        return nomMedecin;
    }

    public void setNomMedecin(String nomMedecin) {
        this.nomMedecin = nomMedecin;
    }

    public String getNomPatient() {
        return nomPatient;
    }

    public void setNomPatient(String nomPatient) {
        this.nomPatient = nomPatient;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public String getCommentaire() {
        return commentaire;
    }

    public void setCommentaire(String commentaire) {
        this.commentaire = commentaire;
    }
     @Override
    public String toString() {
        return "Ordonnance{" + "id=" + id + ", nomMedecin=" + nomMedecin + ", nomPatient=" + nomPatient + ", date=" + date + ", commentaire=" + commentaire + '}';
    }

    public Ordonnance(int id, String commentaire) {
        this.id = id;
        this.commentaire = commentaire;
    }

    public int getDoctor_id() {
        return doctor_id;
    }

    public void setDoctor_id(int doctor_id) {
        this.doctor_id = doctor_id;
    }

    public int getPatient_id() {
        return patient_id;
    }

    public void setPatient_id(int patient_id) {
        this.patient_id = patient_id;
    }
    
}
