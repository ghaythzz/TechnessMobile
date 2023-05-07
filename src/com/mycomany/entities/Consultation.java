/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package entity;

import java.util.Date;

/**
 *
 * @author selmi
 */
public class Consultation {
    
    private int id;
    private String comment ;
    private String start,end ;
    
    
    public Consultation(int id, String start,String end, String commentaire) {
        this.id = id;
        this.start = start;
        this.end = end;
        this.comment = commentaire;
    }

    public Consultation(String start, String end) {
        this.start = start;
        this.end = end;
    }

    

    public Consultation(String commentaire) {

         this.comment = commentaire;
    }
    

    public Consultation() {
    }

    public Consultation(String start, String end, String comment) {
        this.start = start;
        this.end = end;
        this.comment = comment;
    }
    
    
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getStart() {
        return start;
    }

    public void setStart(String start) {
        this.start = start;
    }
    
    public String getEnd() {
        return end;
    }

    public void setEnd(String end) {
        this.end = end;
    }

    public String getCommentaire() {
        return comment;
    }

    public void setCommentaire(String commentaire) {
        this.comment = commentaire;
    }

    @Override
    public String toString() {
        return "id=" + id +  ", commentaire=" + comment +"\n";
    }
    
}
