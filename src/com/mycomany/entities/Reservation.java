/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycomany.entities;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

import java.util.ArrayList;
import java.util.Date;
import java.util.List;




public class Reservation {

    private int id;
    private int users_id;
    private int patient_id;
    private Date start;
    private Date end;
    private String comment;

    public Reservation(int id, Date start, Date end, String comment) {
         this.id = id;  
       
        this.start = start;
         this.end = end;
        this.comment = comment;
    }
    public Reservation( Date start, Date end, String comment) {
         
        this.start = start;
         this.end = end;
        this.comment = comment;
    }

     public Reservation() {
         
    }

    public Reservation(String start, String end, String comment) {
        
        
    }
    
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }
    
    
    public Date getstart() {
        return start;
    }
    public Date getend() {
        return end;
    }

    public void setstart(Date start) {
        this.start = start;
    }
    public void setend(Date end) {
        this.end = end;
    }
    
    
    public String getComment() {
        return comment;
    }

    public void setComment(String comment) {
        this.comment = comment;
    }

 @Override
    public String toString() {
        return "|comment=" + comment+ " ||end=" + end +  " ||start=" + start +"|";
    }

    public int getUsers_id() {
        return users_id;
    }

    public void setUsers_id(int users_id) {
        this.users_id = users_id;
    }

    public int getPatient_id() {
        return patient_id;
    }

    public void setPatient_id(int patient_id) {
        this.patient_id = patient_id;
    }

    public Date getStart() {
        return start;
    }

    public void setStart(Date start) {
        this.start = start;
    }
    

}

