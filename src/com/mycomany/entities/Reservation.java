/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package entity;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

import java.util.ArrayList;
import java.util.Date;
import java.util.List;




public class Reservation {

    private int id;
  
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

}

